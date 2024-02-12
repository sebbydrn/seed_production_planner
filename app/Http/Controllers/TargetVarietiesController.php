<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Station;
use App\Seed;
use App\AffiliationUser;
use App\TargetVarieties;
use App\TargetVarietyActivities;
use App\ProductionPlan;
use Auth, DB, Entrust, Validator;
use Yajra\Datatables\Datatables;

class TargetVarietiesController extends Controller
{
    public function index() {
        $role = $this->role();

        // Variety
        $varieties = Seed::select('variety')->where('variety_name', 'NOT LIKE', '%DWSR%')->orderBy('variety', 'asc')->get();

        // PhilRice Stations
        $philriceStations = Station::orderBy('philrice_station_id', 'asc')->get();

        // Production plan years
        $years = TargetVarieties::select('year')->where('is_deleted', '=', 0)->groupBy('year')->orderBy('year', 'asc')->get();

        return view('target_varieties.index')->with(compact('role', 'varieties', 'philriceStations', 'years'));
    }

    public function datatable(Request $request) {
        $target_varieties = TargetVarieties::select('target_variety_id', 'philrice_station_id', 'year', 'sem', 'variety', 'area', 'seed_class');

        if (isset($request->philriceStation)) {
            $philriceStationID = $request->philriceStation;

            if ($philriceStationID != 0) {
                if ($philriceStationID == 1) {
                    $target_varieties = $target_varieties;
                } else {
                    $target_varieties = $target_varieties->where('philrice_station_id', '=', $philriceStationID);
                }
            }
        } else {
            if (Entrust::can('view_all_target_varieties')) {
                $target_varieties = $target_varieties;
            } else {
                // Get station code of user's station
                $philriceStationID = $this->userStationID();
                $target_varieties = $target_varieties->where('philrice_station_id', '=', $philriceStationID);
            }
        }

        if (isset($request->year_filter) && isset($request->sem_filter)) {
            $year_filter = $request->year_filter;
            $sem_filter = $request->sem_filter;

            $target_varieties = $target_varieties->where([
                ['year', '=', $year_filter],
                ['sem', '=', $sem_filter]
            ]);
        }

        $target_varieties = $target_varieties->where('is_deleted', '=', 0)->orderBy('philrice_station_id', 'asc')->orderBy('target_variety_id', 'desc')->get();

        $data = collect($target_varieties);

        return Datatables::of($data)
            ->addColumn('station', function($data) {
                $philrice_station_id = $data->philrice_station_id;

                $station = Station::select('station_code')->where('philrice_station_id', '=', $philrice_station_id)->first();

                return $station->station_code;
            })
            ->addColumn('year_sem', function($data) {
                $sem = ($data->sem == 1) ? "S1" : "S2";
                return $data->year . " " . $sem;
            })
            ->addColumn('seed_class', function($data) {
                switch ($data->seed_class) {
                    case 'Nucleus':
                        return "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-default active'>Nucleus</button>";
                        break;
                    case 'Breeder':
                        return "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-default active'>Breeder</button>";
                        break;
                    case 'Foundation':
                        return "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-danger active'>Foundation</button>";
                        break;
                    case 'Registered':
                        return "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-success active'>Registered</button>";
                        break;
                    case 'Certified':
                        return "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-primary active'>Certified</button>";
                        break;
                    case 'SQR':
                        return "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-info active'>SQR</button>";
                        break;
                }
            })
            ->addColumn('area_inputted', function($data) {
                // get inputted production plans
                $production_plans = DB::table('production_plans as plan')
                                        ->leftJoin('production_plots as planned_plots', 'plan.production_plan_id', '=', 'planned_plots.production_plan_id')
                                        ->leftJoin('plots', 'planned_plots.plot_id', '=', 'plots.plot_id')
                                        ->where([
                                            ['plan.year', '=', $data->year],
                                            ['plan.sem', '=', $data->sem],
                                            ['plan.variety', '=', $data->variety],
                                            ['plan.seed_class', '=', $data->seed_class],
                                            ['plan.is_finalized', '=', 1],
                                            ['plan.philrice_station_id', '=', $data->philrice_station_id]
                                        ])
                                        ->select(DB::raw('SUM(CAST(plots.area AS DECIMAL(10,4))) AS total_area_planned'))
                                        ->first();

                return ($production_plans->total_area_planned == NULL) ? 'NO DATA' : floatval($production_plans->total_area_planned);
            })
            ->addColumn('progress', function($data) {
                // get inputted production plans
                $production_plans = DB::table('production_plans as plan')
                                        ->leftJoin('production_plots as planned_plots', 'plan.production_plan_id', '=', 'planned_plots.production_plan_id')
                                        ->leftJoin('plots', 'planned_plots.plot_id', '=', 'plots.plot_id')
                                        ->where([
                                            ['plan.year', '=', $data->year],
                                            ['plan.sem', '=', $data->sem],
                                            ['plan.variety', '=', $data->variety],
                                            ['plan.seed_class', '=', $data->seed_class],
                                            ['plan.is_finalized', '=', 1],
                                            ['plan.philrice_station_id', '=', $data->philrice_station_id]
                                        ])
                                        ->select(DB::raw('SUM(CAST(plots.area AS DECIMAL(10,4))) AS total_area_planned'))
                                        ->first();

                if ($production_plans->total_area_planned != NULL) {
                    $percent = floatval($production_plans->total_area_planned) / floatval($data->area);
                    $percent = floatval($percent * 100);
                    $percent = round($percent, 0);
                } else {
                    $percent = 0;
                }

                if ($percent == 0) {
                    $progress = '<div class="progress progress-md progress-striped progress-half-rounded m-none mt-xs active dark">
                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                    0% Complete
                    </div>
                    </div>';
                }

                if ($percent > 0 && $percent < 100) {
                    $progress = '<div class="progress progress-md progress-striped progress-half-rounded m-none mt-xs active dark">
                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%;">
                    '.$percent.'% Complete
                    </div>
                    </div>';
                }

                if ($percent >= 100) {
                    $progress = '<div class="progress progress-md progress-half-rounded m-none mt-xs dark">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                    100% Complete
                    </div>
                    </div>';
                }

                return $progress;
            })
            ->addColumn('actions', function($data) {
                if ($data->is_approved != 0) {
                    return "<button type='button' class='mb-xs mt-xs mr-xs btn btn-sm btn-danger' onclick='delete_target(".$data->target_variety_id.")'><i class='fa fa-trash-o'></i> Delete</button>";
                }
            })
            ->rawColumns(['seed_class', 'progress', 'actions'])
            ->make(true);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'year' => 'required',
            'sem' => 'required',
            'variety' => 'required',
            'seed_class' => 'required',
            'area' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            echo json_encode("Failed");
        } else {
            // Get station code of user's station
            $philriceStationID = $this->userStationID();

            // Check if variety and seed class already targetted for the year and semester
            $target = TargetVarieties::where([
                ['philrice_station_id', '=', $philriceStationID],
                ['year', '=', $request->year],
                ['sem', '=', $request->sem],
                ['variety', '=', $request->variety],
                ['seed_class', '=', $request->seed_class],
                ['is_deleted', '=', 0]
            ])->get()->count();

            if ($target == 0) {
                DB::beginTransaction();
                try {
                    // Insert target to database
                    $target = new TargetVarieties;
                    $target->philrice_station_id = $philriceStationID;
                    $target->year = $request->year;
                    $target->sem = $request->sem;
                    $target->variety = $request->variety;
                    $target->seed_class = $request->seed_class;
                    $target->area = $request->area;
                    $target->save();

                    // Insert activity
                    $target_activity = new TargetVarietyActivities;
                    $target_activity->user_id = Auth::user()->user_id;
                    $target_activity->activity = "Added a new target variety";
                    $target_activity->browser = $this->browser();
                    $target_activity->device = $this->device();
                    $target_activity->ip_env_address = $request->ip();
                    $target_activity->ip_server_address = $request->server('SERVER_ADDR');
                    $target_activity->OS = $this->operating_system();
                    $target_activity->save();

                    DB::commit();

                    echo json_encode("Success");
                } catch (Exception $e) {
                    DB::rollback();

                    echo json_encode($e->getMessage());
                }
            } else {
                echo json_encode("Duplicate");
            }

        }
    }

    public function destroy(Request $request) {
        DB::beginTransaction();
        try {
            // Delete target
            $target = TargetVarieties::where('target_variety_id', '=', $request->target_variety_id)
            ->update([
                'is_deleted' => 1,
                'remarks' => $request->remarks
            ]);

            // Insert activity
            $target_activity = new TargetVarietyActivities;
            $target_activity->user_id = Auth::user()->user_id;
            $target_activity->activity = "Deleted target variety";
            $target_activity->browser = $this->browser();
            $target_activity->device = $this->device();
            $target_activity->ip_env_address = $request->ip();
            $target_activity->ip_server_address = $request->server('SERVER_ADDR');
            $target_activity->OS = $this->operating_system();
            $target_activity->save();

            DB::commit();

            echo json_encode("Success");
        } catch (Exception $e) {
            DB::rollback();

            echo json_encode($e->getMessage());
        }
    }

    // StationID of logged in user
    private function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }
}
