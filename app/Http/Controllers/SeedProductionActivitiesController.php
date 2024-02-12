<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Station;
use App\ProductionPlan;
use App\ProductionPlotCode;
use App\AffiliationUser;
use App\PlannedActivity;
use App\SeedTraceGeotag\SeedlingManagement;
use App\SeedTraceGeotag\LandPreparation;
use App\SeedTraceGeotag\CropEstablishment;
use App\SeedTraceGeotag\WaterManagement;
use App\SeedTraceGeotag\NutrientManagement;
use App\SeedTraceGeotag\Roguing;
use App\SeedTraceGeotag\PestManagement;
use App\SeedTraceGeotag\DiseaseManagement;
use App\SeedTraceGeotag\DamageAssessment;
use App\SeedTraceGeotag\Harvesting;
use Auth, DB, Entrust;
use Yajra\Datatables\Datatables;

class SeedProductionActivitiesController extends Controller
{
    public function activities_viewer() {
        $role = $this->role();

        // PhilRice stations
        $stations = Station::select('philrice_station_id', 'name')->orderBy('philrice_station_id', 'ASC')->get();

        // Production plan years
        $years = ProductionPlan::select('year')->groupBy('year')->get();

        // Get station code of user's station
        $philriceStationID = $this->userStationID();

        return view('seed_production_activities.activities_viewer', compact(['role', 'years', 'stations', 'philriceStationID']));
    }

    public function show_activities(Request $request) {
        $stationID = $request->stationID;
        $year = $request->year;
        $sem = $request->sem;
        $activities = array();

        // get production plans
        $production_plans = ProductionPlan::select('production_plan_id', 'variety', 'seed_class', 'philrice_station_id')
        ->where([
            ['year', '=', $year],
            ['sem', '=', $sem]
        ])
        ->when($stationID != 0, function($query) use ($stationID) {
            return $query->where('philrice_station_id', '=', $stationID);
        })
        ->get();

        if ($production_plans->count() > 0) {
            foreach ($production_plans as $p) {
                // station
                $station = Station::select('station_code')->where('philrice_station_id', '=', $p->philrice_station_id)->first();

                // production plot code
                $production_plot_code = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $p->production_plan_id)->first();
                $production_plot_code = $production_plot_code->production_plot_code;

                // get planned activities
                $planned_activities = DB::table('planned_activities as p')
                ->leftJoin('activities as a', 'a.activity_id', '=', 'p.activity_id')
                ->select('a.name as activity', 'p.date_start as date')
                ->where('p.production_plan_id', '=', $p->production_plan_id)
                ->get();

                if ($planned_activities->count() > 0) {
                    foreach ($planned_activities as $pa) {
                        $key = date('Y-m-d', strtotime($pa->date));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $pa->activity,
                            'date' => date('M d, Y', strtotime($pa->date)),
                            'station' => $station->station_code,
                            'is_actual' => 0
                        );
                    }
                }

                // get seedling management activities
                $seedling_management = SeedlingManagement::select('activity', 'timestamp')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($seedling_management->count() > 0) {
                    foreach ($seedling_management as $sm) {
                        $key = date('Y-m-d', strtotime($sm->timestamp));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $sm->activity,
                            'date' => date('M d, Y', strtotime($sm->timestamp)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get land preparation activities
                $land_prep = LandPreparation::select('crop_phase', 'activity', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($land_prep->count() > 0) {
                    foreach ($land_prep as $lp) {
                        $key = date('Y-m-d', strtotime($lp->datetime_start));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activity = $lp->activity . " (" . $lp->crop_phase . ")";

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $activity,
                            'date' => date('M d, Y', strtotime($sm->datetime_start)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get crop establishment activities
                $crop_establish = CropEstablishment::select('activity', 'transplanting_method', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($crop_establish->count() > 0) {
                    foreach ($crop_establish as $ce) {
                        $key = date('Y-m-d', strtotime($ce->datetime_start));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activity = ($ce->transplanting_method != null) ? $ce->activity . " (" . $ce->transplanting_method . ")" : $ce->activity;

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $activity,
                            'date' => date('M d, Y', strtotime($ce->datetime_start)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get water management activities
                $water_management = WaterManagement::select('activity', 'crop_phase', 'crop_stage', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($water_management->count() > 0) {
                    foreach ($water_management as $wm) {
                        $key = date('Y-m-d', strtotime($wm->datetime_start));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activity = $wm->activity . " (" . $wm->crop_phase . " - " . $wm->crop_stage . ")";

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $activity,
                            'date' => date('M d, Y', strtotime($wm->datetime_start)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get nutrient management activities
                $nutrient_management = NutrientManagement::select('crop_phase', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($nutrient_management->count() > 0) {
                    foreach ($nutrient_management as $nm) {
                        $key = date('Y-m-d', strtotime($nm->datetime_start));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activity = "Nutrient management - " . $nm->activity;

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $activity,
                            'date' => date('M d, Y', strtotime($nm->datetime_start)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get roguing activities
                $roguing = Roguing::select('timestamp')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($roguing->count() > 0) {
                    foreach ($roguing as $r) {
                        $key = date('Y-m-d', strtotime($r->timestamp));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Roguing",
                            'date' => date('M d, Y', strtotime($r->timestamp)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get pest management activities
                $pest_management = PestManagement::select('pest_type', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($pest_management->count() > 0) {
                    foreach ($pest_management as $pm) {
                        $key = date('Y-m-d', strtotime($pm->datetime_start));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activity = "Pest management - " . $pm->pest_type;

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $activity,
                            'date' => date('M d, Y', strtotime($pm->datetime_start)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get disease management activities
                $disease_mangement = DiseaseManagement::select('disease_type', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($disease_mangement->count() > 0) {
                    foreach ($disease_management as $dm) {
                        $key = date('Y-m-d', strtotime($dm->datetime_start));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activity = "Disease management - " . $dm->diseases_type;

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $activity,
                            'date' => date('M d, Y', strtotime($dm->datetime_start)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get damage assessment activities
                $damage_assessment = DamageAssessment::select('damage_cause', 'timestamp')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($damage_assessment->count() > 0) {
                    foreach ($damage_assessment as $da) {
                        $key = date('Y-m-d', strtotime($da->timestamp));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activity = "Damage assessment - " . $da->damage_cause;

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $activity,
                            'date' => date('M d, Y', strtotime($da->timestamp)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }

                // get harvesting activities
                $harvesting = Harvesting::select('harvesting_method', 'timestamp')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($harvesting->count() > 0) {
                    foreach ($harvesting as $h) {
                        $key = date('Y-m-d', strtotime($h->timestamp));

                        if (!array_key_exists($key, $activities)) {
                            $activities[$key] = array();
                        }

                        $activity = $h->harvesting_cause;

                        $activities[$key][] = array(
                            'production_plan_id' => $p->production_plan_id,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => $activity,
                            'date' => date('M d, Y', strtotime($h->timestamp)),
                            'station' => $station->station_code,
                            'is_actual' => 1
                        );
                    }
                }
            }
        }

        krsort($activities);

        echo json_encode($activities);
    }

    public function submitted_activities() {
        $role = $this->role();

        // PhilRice stations
        $stations = Station::select('philrice_station_id', 'name')->orderBy('philrice_station_id', 'ASC')->get();

        // Production plan years
        $years = ProductionPlan::select('year')->groupBy('year')->get();

        // Get station code of user's station
        $philriceStationID = $this->userStationID();

        return view('seed_production_activities.submitted_activities', compact(['role', 'years', 'stations', 'philriceStationID']));
    }

    public function datatable_submitted_activities(Request $request) {
        // get production plot codes
        $production_plans = DB::table('production_plans as plans')
        ->leftJoin('production_plot_codes as codes', 'codes.production_plan_id', '=', 'plans.production_plan_id')
        ->select('codes.production_plot_code', 'plans.variety', 'plans.seed_class', 'plans.philrice_station_id');

        if (isset($request->philriceStation)) {
            $philriceStationID = $request->philriceStation;

            if ($philriceStationID != 0) {
                if ($philriceStationID == 1) {
                    $production_plans = $production_plans;
                } else {
                    $production_plans = $production_plans->where('plans.philrice_station_id', '=', $philriceStationID);
                }
            }
        } else {
            if (Entrust::can('view_all_seed_production_plans')) {
                $production_plans = $production_plans;
            } else {
                // Get station code of user's station
                $philriceStationID = $this->userStationID();

                $production_plans = $production_plans->where('plans.philrice_station_id', '=', $philriceStationID);
            }
        }

        if (isset($request->year_filter) && isset($request->sem_filter)) {
            $year_filter = $request->year_filter;
            $sem_filter = $request->sem_filter;

            $production_plans = $production_plans->where([
                ['plans.year', '=', $year_filter],
                ['plans.sem', '=', $sem_filter]
            ]);
        }

        $production_plans = $production_plans->where([
            ['plans.is_deleted', '=', 0],
            ['plans.is_finalized', '=', 1]
        ])
        ->orderBy('plans.year', 'desc')
        ->orderBy('plans.sem', 'desc')
        ->orderBy('plans.philrice_station_id', 'asc')
        ->orderBy('plans.production_plan_id', 'desc')
        ->get();

        $data = array();

        if ($production_plans->count() > 0) {
            foreach ($production_plans as $p) {
                $production_plot_code = $p->production_plot_code;

                // station
                $station = Station::select('station_code')->where('philrice_station_id', '=', $p->philrice_station_id)->first();
                $station = $station->station_code;

                // get land prep activities
                $land_prep = LandPreparation::select('land_preparation_id', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($land_prep->count() > 0) {
                    foreach ($land_prep as $lp) {
                        $key = date('Y-m-d', strtotime($lp->datetime_start));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Land Preparation",
                            'activity_id' => $lp->land_preparation_id,
                            'date' => date('M d, Y', strtotime($lp->datetime_start)),
                            'station' => $station
                        );
                    }
                }

                // get seedling management
                $seedling_management = SeedlingManagement::select('seedling_management_id', 'timestamp')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($seedling_management->count() > 0) {
                    foreach ($seedling_management as $sm) {
                        $key = date('Y-m-d', strtotime($sm->timestamp));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Seedling Management",
                            'activity_id' => $sm->seedling_management_id,
                            'date' => date('M d, Y', strtotime($sm->timestamp)),
                            'station' => $station
                        );
                    }
                }

                // get crop establishment
                $crop_establish = CropEstablishment::select('crop_establishment_id', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($crop_establish->count() > 0) {
                    foreach ($crop_establish as $ce) {
                        $key = date('Y-m-d', strtotime($ce->datetime_start));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Crop Establishment",
                            'activity_id' => $ce->crop_establishment_id,
                            'date' => date('M d, Y', strtotime($ce->datetime_start)),
                            'station' => $station
                        );
                    }
                }

                // get water management
                $water_management = WaterManagement::select('water_management_id', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($water_management->count() > 0) {
                    foreach ($water_management as $wm) {
                        $key = date('Y-m-d', strtotime($wm->datetime_start));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Water Management",
                            'activity_id' => $wm->water_management_id,
                            'date' => date('M d, Y', strtotime($wm->datetime_start)),
                            'station' => $station
                        );
                    }
                }

                // get nutrient management
                $nutrient_management = NutrientManagement::select('nutrient_management_id', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($nutrient_management->count() > 0) {
                    foreach ($nutrient_management as $nm) {
                        $key = date('Y-m-d', strtotime($nm->datetime_start));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Nutrient Management",
                            'activity_id' => $nm->nutrient_management_id,
                            'date' => date('M d, Y', strtotime($nm->datetime_start)),
                            'station' => $station
                        );
                    }
                }

                // get roguing
                $roguing = Roguing::select('roguing_id', 'timestamp')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($roguing->count() > 0) {
                    foreach ($roguing as $r) {
                        $key = date('Y-m-d', strtotime($r->timestramp));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Roguing",
                            'activity_id' => $r->roguing_id,
                            'date' => date('M d, Y', strtotime($r->timestamp)),
                            'station' => $station
                        );
                    }
                }

                // get pest management
                $pest_management = PestManagement::select('pest_management_id', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($pest_management->count() > 0) {
                    foreach ($pest_management as $pm) {
                        $key = date('Y-m-d', strtotime($pm->datetime_start));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Pest Management",
                            'activity_id' => $pm->pest_management_id,
                            'date' => date('M d, Y', strtotime($pm->datetime_start)),
                            'station' => $station
                        );
                    }
                }

                // get disease management
                $disease_management = DiseaseManagement::select('disease_management_id', 'datetime_start')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($disease_management->count() > 0) {
                    foreach ($disease_management as $dm) {
                        $key = date('Y-m-d', strtotime($dm->datetime_start));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Disease Management",
                            'activity_id' => $dm->disease_management_id,
                            'date' => date('M d, Y', strtotime($dm->datetime_start)),
                            'station' => $station
                        );
                    }
                }

                // get damage assessment
                $damage_assessment = DamageAssessment::select('damage_assessment_id', 'timestamp')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($damage_assessment->count() > 0) {
                    foreach ($damage_assessment as $da) {
                        $key = date('Y-m-d', strtotime($da->timestamp));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Damage Assessment",
                            'activity_id' => $da->damage_assessment_id,
                            'date' => date('M d, Y', strtotime($da->timestamp)),
                            'station' => $station
                        );
                    } 
                }

                // get harvesting
                $harvesting = Harvesting::select('harvesting_id', 'timestamp')
                ->where('production_plot_code', '=', $production_plot_code)
                ->get();

                if ($harvesting->count() > 0) {
                    foreach ($harvesting as $h) {
                        $key = date('Y-m-d', strtotime($h->timestamp));

                        if (!array_key_exists($key, $data)) {
                            $data[$key] = array();
                        }

                        $data[$key][] = array(
                            'production_plot_code' => $production_plot_code,
                            'variety' => $p->variety,
                            'seed_class' => $p->seed_class,
                            'activity' => "Harvesting",
                            'activity_id' => $h->harvesting_id,
                            'date' => date('M d, Y', strtotime($h->timestamp)),
                            'station' => $station
                        );
                    }
                }
            }
        }

        krsort($data);

        $data_sorted = array();

        foreach ($data as $key => $value) {
            $activities = $value;

            foreach ($activities as $ax) {
                $data_sorted[] = array(
                    'production_plot_code' => $ax['production_plot_code'],
                    'variety' => $ax['variety'],
                    'seed_class' => $ax['seed_class'],
                    'activity' => $ax['activity'],
                    'activity_id' => $ax['activity_id'],
                    'date' => $ax['date'],
                    'station' => $ax['station']
                );
            }
        }

        return Datatables::of($data_sorted)
            ->addColumn('actions', function($data) {
                $buttons = '<button class="btn btn-info btn-sm mr-sm" onclick="show_activity_data(`'.$data['activity'].'`, '.$data['activity_id'].')"><i class="fa fa-eye"></i> View</button><button class="btn btn-primary btn-sm" onclick="show_activity_map(`'.$data['activity'].'`, '.$data['activity_id'].')"><i class="fa fa-eye"></i> View map</button>';
                return $buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // StationID of logged in user
    private function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }
}
