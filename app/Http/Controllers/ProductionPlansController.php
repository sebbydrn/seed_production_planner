<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductionPlan;
use App\ProductionPlanActivities;
use App\Plot;
use App\Personnel;
use App\FieldWorker;
use App\ProductionPlot;
use App\ProductionPlotCode;
use App\SeedProductionTechnology;
use App\SeedProductionTechnologyActivities;
use App\Activity;
use App\PlannedActivity;
use App\Seed;
use App\User;
use App\Role;
use App\AffiliationUser;
use App\Station;
use App\Region;
use App\Province;
use App\Municipality;
use App\ActualProductionPlot;
use App\TargetVarieties;
use App\Farmer;
use App\SeedTraceGeotag\LandPreparation;
use App\SeedTraceGeotag\SeedlingManagement;
use App\SeedTraceGeotag\CropEstablishment;
use App\SeedTraceGeotag\Harvesting;
use Auth, DB, Session, Validator, QRCode, PDF, Entrust;
use Yajra\Datatables\Datatables;

class ProductionPlansController extends Controller {

    public function __construct() {
        $this->middleware('permission:view_seed_production_plans')->only(['index', 'show', 'datatable']);
        $this->middleware('permission:add_seed_production_plan')->only(['create', 'store']);
        $this->middleware('permission:edit_seed_production_plan')->only(['edit', 'update']);
        $this->middleware('permission:delete_seed_production_plan')->only(['destroy']);

        $this->middleware('permission:add_planned_seed_production_activities')->only(['add_activities', 'store_activties']);
    }

    public function index() {
        $role = $this->role();

        $philriceStations = Station::orderBy('philrice_station_id', 'asc')->get();

        // Production plan years
        $years = ProductionPlan::select('year')->where('is_deleted', '=', 0)->groupBy('year')->orderBy('year', 'asc')->get();

        return view('production_plans.index', compact(['role', 'philriceStations', 'years']));
    }

    public function create() {
        $role = $this->role();

        // $philriceStationID = $this->userStationID();

        // Variety
        $varieties = Seed::select('variety')->where('variety_name', 'NOT LIKE', '%DWSR%')->orderBy('variety', 'asc')->get();

        // Seed production in-charge
        // $seedProductionInCharge = Personnel::select('personnel_id', 'first_name', 'last_name')
        //                                     ->where('role', '=', 'Seed Production In-Charge')
        //                                     ->where('is_active', '=', 1)
        //                                     ->where('is_deleted', '=', 0)
        //                                     ->where('philrice_station_id', '=', $philriceStationID)
        //                                     ->get();
        // Laborers
        // $laborers = Personnel::select('personnel_id', 'first_name', 'last_name')
        //                         ->where('role', '=', 'Laborer')
        //                         ->where('is_active', '=', 1)
        //                         ->where('is_deleted', '=', 0)
        //                         ->where('philrice_station_id', '=', $philriceStationID)
        //                         ->get();

        // Active plots
        // $activePlots = Plot::select('plot_id', 'name')->where('is_active', 1)->orderBy('name', 'asc')->get();

        // Provinces
        // $provinces = Province::select('name', 'prov_code')->orderBy('name', 'asc')->get();

        // Farmers
        $farmers = Farmer::select('farmer_id', 'first_name', 'last_name')->where('is_active', 1)->orderBy('first_name', 'asc')->get();

        return view('production_plans.create', compact(['role', 'varieties', 'farmers' ]));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'year' => 'required',
            'sem' => 'required',
            'variety' => 'required',
            'seedClass' => 'required',
            'seedQuantity' => 'required',
            // 'sourceSeedLot' => 'required',
            // 'seedProductionInCharge' => 'required',
            // 'fieldWorkers' => 'required',
            'plots' => 'required',
            // 'province' => 'required',
            // 'municipality' => 'required',
            'barangay' => 'required',
            // 'sitio' => 'required',
            // 'rice_program' => 'required'
        ], [
            'sem.required' => 'The semester field is required.',
            'seedClass.required' => 'The seed class to be planted field is required.',
            'seedQuantity.required' => 'The seed quantity to be used field is required.',
            'sourceSeedLot.required' => 'The source seed lot field is required.',
            'seedProductionInCharge.required' => 'The seed production in-charge field is required.',
            'fieldWorkers.required' => 'The field workers field is required.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Get station code of user's station
            $philriceStationID = $this->userStationID();

            // Insert production plan to database
            $productionPlan = new ProductionPlan();
            $productionPlan->year = $request->year;
            $productionPlan->sem = $request->sem;
            $productionPlan->variety = $request->variety;
            $productionPlan->seed_class = $request->seedClass;
            $productionPlan->seed_quantity = $request->seedQuantity;
            $productionPlan->source_seed_lot = $request->sourceSeedLot;
            // $productionPlan->seed_production_in_charge = $request->seedProductionInCharge;
            // $productionPlan->philrice_station_id = $philriceStationID;
            // $productionPlan->region = $request->region;
            // $productionPlan->province = $request->province;
            // $productionPlan->municipality = $request->municipality;
            $productionPlan->barangay = $request->barangay;
            // $productionPlan->sitio = $request->sitio;
            $productionPlan->rice_program = $request->rice_program;
            $productionPlan->remarks = $request->remarks;
            $productionPlan->save();
            $productionPlanID = $productionPlan->production_plan_id;

            // Insert field workers to database
            // $fieldWorkers = $request->fieldWorkers;
            // foreach ($fieldWorkers as $fieldWorker) {
            //     $worker = new FieldWorker();
            //     $worker->production_plan_id = $productionPlanID;
            //     $worker->personnel_id = $fieldWorker;
            //     $worker->save();
            // }

            // Insert plots to database
            $plots = $request->plots;
            foreach ($plots as $plot) {
                $productionPlot = new ProductionPlot();
                $productionPlot->production_plan_id = $productionPlanID;
                $productionPlot->plot_id = $plot;
                $productionPlot->save();
            }
            
            // PR_CES_2021_SEM1_SP_01 - Seed Production
            // PR_CES_2021_SEM1_PP_01 - Post Production
            $year = $request->year;
            $semester = ($request->sem == 1) ? "SEM1" : "SEM2";

            // $station = Station::select('station_code')->where('philrice_station_id', '=', $philriceStationID)->first();
            // $stationCode = $station->station_code;

            // Generate production plot code prefix
            // $productionPlotCode = "PR_" . $stationCode . "_" . $year . "_" . $semester . "_SP";
            $productionPlotCode = "PR_" . $year . "_" . $semester . "_SP";

            // Query last production plot code to check the iteration/count
            $lastProductionPlotCode = ProductionPlotCode::select('production_plot_code')
                                                            ->where('production_plot_code', 'LIKE', '%'.$productionPlotCode.'%')
                                                            ->orderBy('production_plot_code_id', 'desc')
                                                            ->first();

            if ($lastProductionPlotCode) {
                // If database has record of production plot code, iterate or add 1 to the last count
                $lastCount = explode("_", $lastProductionPlotCode->production_plot_code);
                $lastCount = $lastCount[5];
                $count = $lastCount + 1;
                $count = str_pad($count, '2', 0, STR_PAD_LEFT);

                $productionPlotCode = $productionPlotCode . "_" . $count;
            } else {
                // If database has no record of production plot code, start the count from 1
                $productionPlotCode = $productionPlotCode . "_01";
            }

            // Generate season code
            $seasonCode = $year . "_" . $semester;

            // Insert to database
            $code = new ProductionPlotCode();
            $code->production_plan_id = $productionPlanID;
            $code->production_plot_code = $productionPlotCode;
            $code->season_code = $seasonCode;
            $code->save();

            // Insert production plan activity log
            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $productionPlanID;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Added new production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            DB::commit();

            return redirect()->back()->with('success', 'New production plan successfully added.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error adding new production plan.');
        }
    }

    public function show($id) {
        $role = $this->role();

        $productionPlan = ProductionPlan::where('production_plan_id', '=', $id)->first();

        // $seedProductionInCharge = Personnel::select('first_name', 'last_name')->where('personnel_id', '=', $productionPlan->seed_production_in_charge)->first();

        // $selectedLaborers = FieldWorker::select('personnel_id')->where('production_plan_id', '=', $id)->get();

        // $fieldWorkers = array();
        // foreach ($selectedLaborers as $laborer) {
        //     $personnel = Personnel::select('first_name', 'last_name')->where('personnel_id', '=', $laborer->personnel_id)->first();
        //     $fieldWorkers[] = array(
        //         'first_name' => $personnel->first_name,
        //         'last_name' => $personnel->last_name
        //     );
        // }

        // $philriceStationID = $this->userStationID();

        $plots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $id)->get();

        // $region = Region::select('name')->where('reg_code', '=', $productionPlan->region)->first();

        // $province = Province::select('name')->where('prov_code', '=', $productionPlan->province)->first();

        // $municipality = Municipality::select('name')->where('mun_code', '=', $productionPlan->municipality)->first();

        // Production plot code
        $production_plot_code = ProductionPlotCode::select('production_plot_code')
                                                    ->where('production_plan_id', '=', $id)
                                                    ->first();

        $production_plot_code = $production_plot_code->production_plot_code;


        return view('production_plans.show', compact([
            'role', 
            'productionPlan', 
            'plots']));
    }

    public function edit($id) {
        $role = $this->role();

        $productionPlan = ProductionPlan::where('production_plan_id', '=', $id)->first();

        // $philriceStationID = $this->userStationID();

        // Variety
        $varieties = Seed::select('variety')->where('variety_name', 'NOT LIKE', '%DWSR%')->orderBy('variety', 'asc')->get();

        // Seed production in-charge
        $seedProductionInCharge = Personnel::select('personnel_id', 'first_name', 'last_name')
                                            ->where('role', '=', 'Seed Production In-Charge')
                                            ->where('is_active', '=', 1)
                                            ->where('is_deleted', '=', 0)
                                            ->where('philrice_station_id', '=', $philriceStationID)
                                            ->get();
        // Laborers
        $laborers = Personnel::select('personnel_id', 'first_name', 'last_name')
                                ->where('role', '=', 'Laborer')
                                ->where('is_active', '=', 1)
                                ->where('is_deleted', '=', 0)
                                ->where('philrice_station_id', '=', $philriceStationID)
                                ->get();

        // Active plots
        $activePlots = Plot::select('plot_id', 'name')->where('philrice_station_id', $philriceStationID)->where('is_active', 1)->orderBy('name', 'asc')->get();

        // Selected field workers
        $selectedLaborers = FieldWorker::select('personnel_id')->where('production_plan_id', '=', $id)->get();

        // Selected plots
        $selectedPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $id)->get();

        // Selected plots total area
        $totalArea = 0;
        foreach ($selectedPlots as $selectedPlot) {
            $area = $selectedPlot->area->area;
            $totalArea = $totalArea + $area;
        }

        // Provinces
        $provinces = Province::select('name', 'prov_code')->orderBy('name', 'asc')->get();

        // Get province id of province
        $province = Province::select('province_id')->where('prov_code', '=', $productionPlan->province)->first();
        $province_id = $province->province_id;

        // Get municipalities under the province
        $municipalities = Municipality::select('mun_code', 'name')->where('province_id', '=', $province_id)->orderBy('name', 'asc')->get();

        return view('production_plans.edit', compact(['role', 'productionPlan', 'varieties', 'seedProductionInCharge', 'laborers', 'activePlots', 'selectedLaborers', 'selectedPlots', 'totalArea', 'philriceStationID', 'provinces', 'municipalities']));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'year' => 'required',
            'sem' => 'required',
            'variety' => 'required',
            'seedClass' => 'required',
            'seedQuantity' => 'required',
            // 'sourceSeedLot' => 'required',
            'seedProductionInCharge' => 'required',
            'fieldWorkers' => 'required',
            'plots' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
            'rice_program' => 'required'
        ], [
            'sem.required' => 'The semester field is required.',
            'seedClass.required' => 'The seed class to be planted field is required.',
            'seedQuantity.required' => 'The seed quantity to be used field is required.',
            // 'sourceSeedLot.required' => 'The source seed lot field is required.',
            'seedProductionInCharge.required' => 'The seed production in-charge field is required.',
            'fieldWorkers.required' => 'The field workers field is required.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $productionPlanUpdated = array(
            'year' => $request->year,
            'sem' => $request->sem,
            'variety' => $request->variety,
            'seed_class' => $request->seedClass,
            'seed_quantity' => $request->seedQuantity,
            'source_seed_lot' => $request->sourceSeedLot,
            'seed_production_in_charge' => $request->seedProductionInCharge,
            'region' => $request->region,
            'province' => $request->province,
            'municipality' => $request->municipality,
            'barangay' => $request->barangay,
            'sitio' => $request->sitio,
            'rice_program' => $request->rice_program
        );

        $productionPlanOld = array(
            'old_year' => $request->oldYear,
            'old_sem' => $request->oldSem,
            'old_variety' => $request->oldVariety,
            'old_seed_class' => $request->oldSeedClass,
            'old_seed_quantity' => $request->oldSeedQuantity,
            'old_source_seed_lot' => $request->oldSourceSeedLot,
            'old_seed_production_in_charge' => $request->oldSeedProductionInCharge,
            'old_region' => $request->OldRegion,
            'old_province' => $request->OldProvince,
            'old_municipality' => $request->OldMunicipality,
            'old_barangay' => $request->OldBarangay,
            'old_sitio' => $request->OldSitio,
            'old_rice_program' => $request->OldRiceProgram
        );

        DB::beginTransaction();
        try {
            // Update production plan row
            $productionPlan = ProductionPlan::find($id);
            $productionPlan->year = $productionPlanUpdated['year'];
            $productionPlan->sem = $productionPlanUpdated['sem'];
            $productionPlan->variety = $productionPlanUpdated['variety'];
            $productionPlan->seed_class = $productionPlanUpdated['seed_class'];
            $productionPlan->seed_quantity = $productionPlanUpdated['seed_quantity'];
            $productionPlan->source_seed_lot = $productionPlanUpdated['source_seed_lot'];
            $productionPlan->seed_production_in_charge = $productionPlanUpdated['seed_production_in_charge'];
            $productionPlan->region = $productionPlanUpdated['region'];
            $productionPlan->province = $productionPlanUpdated['province'];
            $productionPlan->municipality = $productionPlanUpdated['municipality'];
            $productionPlan->barangay = $productionPlanUpdated['barangay'];
            $productionPlan->sitio = $productionPlanUpdated['sitio'];
            $productionPlan->rice_program = $productionPlanUpdated['rice_program'];
            $productionPlan->save();

            // Delete production plan from field workers table
            $workers = FieldWorker::where('production_plan_id', '=', $id)->delete();

            // Insert field workers to database
            $fieldWorkers = $request->fieldWorkers;
            foreach ($fieldWorkers as $fieldWorker) {
                $worker = new FieldWorker();
                $worker->production_plan_id = $id;
                $worker->personnel_id = $fieldWorker;
                $worker->save();
            }

            // Delete production plan plots
            $plots = ProductionPlot::where('production_plan_id', '=', $id)->delete();

            // Insert plots to database
            $plots = $request->plots;
            foreach ($plots as $plot) {
                $productionPlot = new ProductionPlot();
                $productionPlot->production_plan_id = $id;
                $productionPlot->plot_id = $plot;
                $productionPlot->save();
            }

            // Check if old value is different from updated value
            // If different, save as activity log
            foreach ($productionPlanUpdated as $key => $value) {
                if ($productionPlanOld['old_'.$key] != $value) {
                    // Insert production plan activity log
                    $productionPlanActivity = new ProductionPlanActivities();
                    $productionPlanActivity->production_plan_id = $id;
                    $productionPlanActivity->user_id = Auth::user()->user_id;
                    $productionPlanActivity->browser = $this->browser();
                    $productionPlanActivity->activity = "Updated production plan";
                    $productionPlanActivity->device = $this->device();
                    $productionPlanActivity->ip_env_address = $request->ip();
                    $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
                    $productionPlanActivity->new_value = $value;
                    $productionPlanActivity->old_value = $productionPlanOld['old_'.$key];
                    $productionPlanActivity->OS = $this->operating_system();
                    $productionPlanActivity->save();                
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Production plan successfully updated.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error updating production plan.');
        }
    }

    public function destroy(Request $request, $id) {
        DB::beginTransaction();
        try {
            // Delete production plan row
            $productionPlan = ProductionPlan::find($id)->delete();

            // Delete production plot code row
            $code = ProductionPlotCode::where('production_plan_id', '=', $id)->delete();

            // Delete production plan from field workers table
            $workers = FieldWorker::where('production_plan_id', '=', $id)->delete();

            // Delete production plan plots
            $plots = ProductionPlot::where('production_plan_id', '=', $id)->delete();

            // Insert production plan activity log
            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $id;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Deleted production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            DB::commit();

            $result = "success";
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // $result = $e->getMessage();

            $result = "error";
        }

        echo json_encode($result);
    }

    // Datatable
    public function datatable(Request $request) {
        $productionPlans = ProductionPlan::select('*');

        if (isset($request->is_finalized)) {
            $is_finalized = $request->is_finalized;
            $productionPlans = $productionPlans->where('is_finalized', '=', $is_finalized);
        }

        if (isset($request->year_filter) && isset($request->sem_filter)) {
            $year_filter = $request->year_filter;
            $sem_filter = $request->sem_filter;

            $productionPlans = $productionPlans->where([
                ['year', '=', $year_filter],
                ['sem', '=', $sem_filter]
            ]);
        }

        $productionPlans = $productionPlans->where('is_deleted', '=', 0)
                                            ->orderBy('year', 'desc')
                                            ->orderBy('sem', 'desc')
                                            ->orderBy('philrice_station_id', 'asc')
                                            ->orderBy('production_plan_id', 'desc')
                                            ->get();

        $data = collect($productionPlans);

        return Datatables::of($data)
            ->addColumn('production_plot_code', function($data) {
                $productionPlanID = $data->production_plan_id;

                $productionPlotCode = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();

                return $productionPlotCode->production_plot_code;
            })
            ->addColumn('year_sem', function($data) {
                $sem = ($data->sem == 1) ? "S1" : "S2";
                return $data->year . " " . $sem;
            })
            ->addColumn('planned_plots', function($data) {
                $productionPlanID = $data->production_plan_id;

                $productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();

                $plots = "";
                
                foreach ($productionPlots as $productionPlot) {
                    $plotID = $productionPlot->plot_id;

                    $plot = Plot::select('name')->where('plot_id', '=', $plotID)->first();

                    $plots .= '<button class="mb-xs mt-xs mr-xs btn btn-xs btn-primary active">'.$plot->name.'</button>';
                }

                return $plots;
            })
            ->addColumn('planned_plots_area', function ($data) {
                $productionPlanID = $data->production_plan_id;

                $productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();

                $area = 0;

                foreach ($productionPlots as $productionPlot) {
                    $plotID = $productionPlot->plot_id;

                    $plot = Plot::select('area')->where('plot_id', '=', $plotID)->first();

                    $area += floatval($plot->area);
                }

                return $area;
            })
            ->addColumn('status', function($data) {
                if ($data->is_finalized == 1) {
                    $status = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-success active'>Finalized</button>";

                    // Check if production plan has seed soaking activity (start)
                    $productionPlanID = $data->production_plan_id;

                    $productionPlotCodes = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();

                    $productionPlotCode = $productionPlotCodes->production_plot_code;

                    $seed_soaking_activity = SeedlingManagement::select('seedling_management_id')
                                                            ->where([
                                                                ['production_plot_code', '=', $productionPlotCode],
                                                                ['activity', '=', "Seed Soaking"]
                                                            ])
                                                            ->first();

                    $seed_sowing_activity = SeedlingManagement::select('seedling_management_id')
                                                            ->where([
                                                                ['production_plot_code', '=', $productionPlotCode],
                                                                ['activity', '=', "Seed Sowing"]
                                                            ])
                                                            ->first();

                    $transplanting_activity = CropEstablishment::select('crop_establishment_id')
                                                            ->where([
                                                                ['production_plot_code', '=', $productionPlotCode],
                                                                ['activity', '=', "Transplanting"]
                                                            ])
                                                            ->first();

                    $harvesting_activity = Harvesting::select('harvesting_id')
                                                            ->where('production_plot_code', '=', $productionPlotCode)
                                                            ->first();

                    if ($seed_soaking_activity)
                        $status .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-primary active'>Seed Soaking Done</button>";

                    if ($seed_sowing_activity)
                        $status .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-primary active'>Seed Sowing Done</button>";

                    if ($transplanting_activity)
                        $status .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-primary active'>Transplanting Done</button>";

                    if ($harvesting_activity)
                        $status .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-primary active'>Harvesting Done</button>";
                } elseif ($data->is_finalized == 0) {
                    $status = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-xs btn-warning active'>Pending</button>&nbsp;";
                }

                return $status;
            })
            ->addColumn('actions', function($data) {
                $actions = "<a href='".route('production_plans.show', $data->production_plan_id)."' class='mb-xs mt-xs mr-xs btn btn-sm btn-info'><i class='fa fa-eye'></i> View</a>&nbsp;<button class='mb-xs mt-xs mr-xs btn btn-sm btn-info' onclick='viewPlots(".$data->production_plan_id.")'><i class='fa fa-eye'></i> View Plots</button>&nbsp;";

                if ($data->is_finalized == 1) {
                    $actions .= "<a href='".route('production_plans.generate_qrcode', ['id' => $data->production_plan_id])."' class='mb-xs mt-xs mr-xs btn btn-sm btn-primary' target='_blank'><i class='fa fa-qrcode'></i> Generate QR Code</a>";

                    // Check if production plan has seed soaking activity (start)
                    $productionPlanID = $data->production_plan_id;

                    $productionPlotCodes = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();

                    $productionPlotCode = $productionPlotCodes->production_plot_code;

                    $seedlingManagement = SeedlingManagement::select('seedling_management_id')
                                                            ->where([
                                                                ['production_plot_code', '=', $productionPlotCode],
                                                                ['activity', '=', "Seed Soaking"]
                                                            ])
                                                            ->first();

                    // Planned seed soaking
                    $plannedActivity = PlannedActivity::select('date_start')
                                                        ->where([
                                                            ['production_plan_id', '=', $productionPlanID],
                                                            ['activity_id', '=', 3]
                                                        ]) 
                                                        ->first();

                    $dateTimeNow = date('Y-m-d h:i');
                    $seedSoakingDateTime = date('Y-m-d h:i', strtotime($plannedActivity->date_start));

                    if ($dateTimeNow < $seedSoakingDateTime) {
                        $plannedSeedSoaking = true;
                    } else {
                        $plannedSeedSoaking = false;
                    }

                    if (!$seedlingManagement && $plannedSeedSoaking == true) {
                        if (Entrust::can('edit_seed_production_plan')) {
                            // $actions .= "<a href='".route('production_plans.edit', $data->production_plan_id)."' class='mb-xs mt-xs mr-xs btn btn-sm btn-warning'><i class='fa fa-edit'></i> Edit</a>";
                        }

                        if (Entrust::can('delete_seed_production_plan')) {
                            $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-sm btn-danger' onclick='deleteFinProductionPlan(".$data->production_plan_id.")'><i class='fa fa-trash-o'></i> Delete</button>";
                        }

                        if (Entrust::can('add_planned_seed_production_activities')) {
                            $actions .= "<a href='".route('production_plans.add_activities', $data->production_plan_id)."' class='mb-xs mt-xs mr-xs btn btn-sm btn btn-warning'><i class='fa fa-edit'></i> Replace Planned Activities</a>";
                        }
                    } else {
                        // Option to discontinue production plan when there is no harvesting data yet
                        $harvest_data = Harvesting::where('production_plot_code', '=', $productionPlotCode)->get()->count();

                        if ($harvest_data == 0) {
                            if (Entrust::can('delete_seed_production_plan')) {
                                $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-sm btn-danger' onclick='discontinue_plan(`".$data->production_plan_id."`)'><i class='fa fa-ban'></i> Discontinue</a>";
                            }
                        }
                    }
                }

                if ($data->is_finalized == 0) {
                    if (Entrust::can('edit_seed_production_plan')) {
                        // $actions .= "<a href='".route('production_plans.edit', $data->production_plan_id)."' class='mb-xs mt-xs mr-xs btn btn-sm btn-warning'><i class='fa fa-edit'></i> Edit</a>";
                    }

                    if (Entrust::can('delete_seed_production_plan')) {
                        $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-sm btn-danger' onclick='deleteProductionPlan(".$data->production_plan_id.")'><i class='fa fa-trash-o'></i> Delete</button>";
                    }

                    if (Entrust::can('add_planned_seed_production_activities')) {
                        $actions .= "<a href='".route('production_plans.add_activities', $data->production_plan_id)."' class='mb-xs mt-xs mr-xs btn btn-sm btn-success'><i class='fa fa-plus'></i> Add Activities</a>";
                    }

                    /*if (Entrust::hasRole('admin')) {
                        $actions .= "<a href='".route('production_plans.input_production_plan', $data->production_plan_id)."' class='mb-xs mt-xs mr-xs btn btn-dark'><i class='fa fa-pencil'></i> Input Production Plan</a>";
                    }*/
                }

                return $actions;
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
            ->rawColumns(['planned_plots', 'actual_plots', 'status', 'actions', 'seed_class'])
            ->make(true);
    }

    // StationID of logged in user
    public function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }

    // Plots details
    public function plots(Request $request) {
        $plotIDs = $request->plotIDs;
        $plots = array();
        $totalArea = 0;

        foreach ($plotIDs as $plotID) {
            $plot = Plot::select('name', 'coordinates', 'area')->where('plot_id', $plotID)->first();

            $plots[] = array(
                'name' => $plot->name,
                'coordinates' => $plot->coordinates,
                'area' => $plot->area
            );

            $totalArea += $plot->area;
        }

        $data = array(
            'plots' => $plots,
            'totalArea' => $totalArea
        );

        echo json_encode($data);
    }

    // Add activities
    public function add_activities($id) {
        $role = $this->role();

        // Production Plan
        $productionPlan = ProductionPlan::where('production_plan_id', '=', $id)->first();

        // Variety
        $selectedVariety = $productionPlan->variety;
        $variety = Seed::select('variety', 'maturity')->where('variety', '=', $selectedVariety)->where('variety_name', 'NOT LIKE', '%DWSR%')->first();

        // Seed production technologies
        $prodTechs = SeedProductionTechnology::get();

        // Get station code of user's station
        $philriceStationID = $this->userStationID();

        $productionTechs = array();

        if ($prodTechs) {
            foreach ($prodTechs as $prodTech) {
                // Get the first production plan that used the production technology
                $techID = $prodTech->tech_id;

                $prodPlan = ProductionPlan::select('year', 'sem', 'variety', 'seed_class')
                                        ->where([
                                            ['tech_id', '=', $techID],
                                            ['philrice_station_id', '=', $philriceStationID]
                                        ])
                                        ->orderBy('production_plan_id', 'asc')
                                        ->first();

                if ($prodPlan) {
                    $sem = ($prodPlan->sem == 1) ? "1st Sem" : "2nd Sem";

                    $productionTechs[] = array(
                        'techID' => $techID,
                        'prodPlan' => $prodPlan->variety . ' - ' . $prodPlan->seed_class . ' (' . $sem . ' ' . $prodPlan->year . ')'
                    );
                }
            }
        }

        return view('production_plans.add_activities', compact(['role', 'variety', 'productionTechs']));
    }

    // Store activities
    public function store_activities(Request $request) {
        $productionPlanID = $request->productionPlanID;

        $productionPlan = ProductionPlan::select('year', 'sem')->where('production_plan_id', '=', $productionPlanID)->first();
        $year = $productionPlan->year;
        $sem = $productionPlan->sem;

        DB::beginTransaction();
        try {
            // Check if user used a production technology
            $techID = $request->techID;

            if ($techID != 0) {
                // Check if user edited the production technology
                $prodTech = SeedProductionTechnology::where('tech_id', '=', $techID)->first();

                if (!$prodTech == null) {
                    $edited = false;

                    if ($prodTech->soaking_hrs != $request->seedSoakingDuration) {
                        $edited = true;
                    }

                    if ($prodTech->incubation_hrs != $request->seedIncubationDuration) {
                        $edited = true;
                    }

                    if ($prodTech->sowing_hrs != $request->seedSowingDuration) {
                        $edited = true;
                    }

                    if ($prodTech->seedbed_irrigation_min_DAS != $request->seedbedIrrigationMinDAS) {
                        $edited = true;
                    }

                    if ($prodTech->seedbed_irrigation_max_DAS != $request->seedbedIrrigationMaxDAS) {
                        $edited = true;
                    }

                    if ($prodTech->seedbed_irrigation_interval != $request->seedbedIrrigationInterval) {
                        $edited = true;
                    }

                    if ($prodTech->seedling_fertilizer_app_init_DAS != $request->seedlingFertilizerAppInitDAS) {
                        $edited = true;
                    }

                    if ($prodTech->seedling_fertilizer_app_final_DAS != $request->seedlingFertilizerAppFinalDAS) {
                        $edited = true;
                    }

                    if ($prodTech->plowing_DAS != $request->plowingDAS) {
                        $edited = true;
                    }

                    if ($prodTech->harrowing_1_DAS != $request->harrowing1DAS) {
                        $edited = true;
                    }

                    if ($prodTech->harrowing_2_DAS != $request->harrowing2DAS) {
                        $edited = true;
                    }

                    if ($prodTech->harrowing_3_DAS != $request->harrowing3DAS) {
                        $edited = true;
                    }

                    if ($prodTech->levelling_DAS != $request->levellingDAS) {
                        $edited = true;
                    }

                    if ($prodTech->seedling_age != $request->seedlingAge) {
                        $edited = true;
                    }

                    if ($prodTech->pulling_to_transplanting != $request->pullingToTransplanting) {
                        $edited = true;
                    }

                    if ($prodTech->replanting_window_min_DAT != $request->replantingWindowMinDAT) {
                        $edited = true;
                    }

                    if ($prodTech->replanting_window_max_DAT != $request->replantingWindowMaxDAT) {
                        $edited = true;
                    }

                    if ($prodTech->irrigation_min_DAT != $request->irrigationMinDAT) {
                        $edited = true;
                    }

                    if ($prodTech->irrigation_max_DAT != $request->irrigationMaxDAT) {
                        $edited = true;
                    }

                    if ($prodTech->irrigation_interval != $request->irrigationInterval) {
                        $edited = true;
                    }

                    if ($prodTech->fertilizer_app_1_DAT != $request->fertilizerApp1DAT) {
                        $edited = true;
                    }

                    if ($prodTech->fertilizer_app_2_DAT != $request->fertilizerApp2DAT) {
                        $edited = true;
                    }

                    if ($prodTech->fertilizer_app_3_DAT != $request->fertilizerApp3DAT) {
                        $edited = true;
                    }

                    if ($prodTech->fertilizer_app_final_DAT != $request->fertilizerAppFinalDAT) {
                        $edited = true;
                    }

                    if ($prodTech->pre_emergence_app_DAT != $request->preEmergenceAppDAT) {
                        $edited = true;
                    }

                    if ($prodTech->post_emergence_app_DAT != $request->postEmergenceAppDAT) {
                        $edited = true;
                    }

                    if ($edited == true) {
                        // Insert seed production technology to database
                        $tech = new SeedProductionTechnology();
                        $tech->year = $year;
                        $tech->sem = $sem;
                        $tech->soaking_hrs = $request->seedSoakingDuration;
                        $tech->incubation_hrs = $request->seedIncubationDuration;
                        $tech->sowing_hrs = $request->seedSowingDuration;
                        $tech->seedbed_irrigation_min_DAS = $request->seedbedIrrigationMinDAS;
                        $tech->seedbed_irrigation_max_DAS = $request->seedbedIrrigationMaxDAS;
                        $tech->seedbed_irrigation_interval = $request->seedbedIrrigationInterval;
                        $tech->seedling_fertilizer_app_init_DAS = $request->seedlingFertilizerAppInitDAS;
                        $tech->seedling_fertilizer_app_final_DAS = $request->seedlingFertilizerAppFinalDAS;
                        $tech->plowing_DAS = $request->plowingDAS;
                        $tech->harrowing_1_DAS = $request->harrowing1DAS;
                        $tech->harrowing_2_DAS = $request->harrowing2DAS;
                        $tech->harrowing_3_DAS = $request->harrowing3DAS;
                        $tech->levelling_DAS = $request->levellingDAS;
                        $tech->seedling_age = $request->seedlingAge;
                        $tech->pulling_to_transplanting = $request->pullingToTransplanting;
                        $tech->replanting_window_min_DAT = $request->replantingWindowMinDAT;
                        $tech->replanting_window_max_DAT = $request->replantingWindowMaxDAT;
                        $tech->irrigation_min_DAT = $request->irrigationMinDAT;
                        $tech->irrigation_max_DAT = $request->irrigationMaxDAT;
                        $tech->irrigation_interval = $request->irrigationInterval;
                        $tech->fertilizer_app_1_DAT = $request->fertilizerApp1DAT;
                        $tech->fertilizer_app_2_DAT = $request->fertilizerApp2DAT;
                        $tech->fertilizer_app_3_DAT = $request->fertilizerApp3DAT;
                        $tech->fertilizer_app_final_DAT = $request->fertilizerAppFinalDAT;
                        $tech->pre_emergence_app_DAT = $request->preEmergenceAppDAT;
                        $tech->post_emergence_app_DAT = $request->postEmergenceAppDAT;
                        $tech->save();
                        $techID = $tech->tech_id;

                        // Insert seed production technology activity log
                        $techActivity = new SeedProductionTechnologyActivities();
                        $techActivity->tech_id = $techID;
                        $techActivity->user_id = Auth::user()->user_id;
                        $techActivity->browser = $this->browser();
                        $techActivity->activity = "Added new seed production technology";
                        $techActivity->device = $this->device();
                        $techActivity->ip_env_address = $request->ip();
                        $techActivity->ip_server_address = $request->server('SERVER_ADDR');
                        $techActivity->OS = $this->operating_system();
                        $techActivity->save();
                    }
                }
            } else {
                // Insert seed production technology to database
                $tech = new SeedProductionTechnology();
                $tech->year = $year;
                $tech->sem = $sem;
                $tech->soaking_hrs = $request->seedSoakingDuration;
                $tech->incubation_hrs = $request->seedIncubationDuration;
                $tech->sowing_hrs = $request->seedSowingDuration;
                $tech->seedbed_irrigation_min_DAS = $request->seedbedIrrigationMinDAS;
                $tech->seedbed_irrigation_max_DAS = $request->seedbedIrrigationMaxDAS;
                $tech->seedbed_irrigation_interval = $request->seedbedIrrigationInterval;
                $tech->seedling_fertilizer_app_init_DAS = $request->seedlingFertilizerAppInitDAS;
                $tech->seedling_fertilizer_app_final_DAS = $request->seedlingFertilizerAppFinalDAS;
                $tech->plowing_DAS = $request->plowingDAS;
                $tech->harrowing_1_DAS = $request->harrowing1DAS;
                $tech->harrowing_2_DAS = $request->harrowing2DAS;
                $tech->harrowing_3_DAS = $request->harrowing3DAS;
                $tech->levelling_DAS = $request->levellingDAS;
                $tech->seedling_age = $request->seedlingAge;
                $tech->pulling_to_transplanting = $request->pullingToTransplanting;
                $tech->replanting_window_min_DAT = $request->replantingWindowMinDAT;
                $tech->replanting_window_max_DAT = $request->replantingWindowMaxDAT;
                $tech->irrigation_min_DAT = $request->irrigationMinDAT;
                $tech->irrigation_max_DAT = $request->irrigationMaxDAT;
                $tech->irrigation_interval = $request->irrigationInterval;
                $tech->fertilizer_app_1_DAT = $request->fertilizerApp1DAT;
                $tech->fertilizer_app_2_DAT = $request->fertilizerApp2DAT;
                $tech->fertilizer_app_3_DAT = $request->fertilizerApp3DAT;
                $tech->fertilizer_app_final_DAT = $request->fertilizerAppFinalDAT;
                $tech->pre_emergence_app_DAT = $request->preEmergenceAppDAT;
                $tech->post_emergence_app_DAT = $request->postEmergenceAppDAT;
                $tech->save();
                $techID = $tech->tech_id;

                // Insert seed production technology activity log
                $techActivity = new SeedProductionTechnologyActivities();
                $techActivity->tech_id = $techID;
                $techActivity->user_id = Auth::user()->user_id;
                $techActivity->browser = $this->browser();
                $techActivity->activity = "Added new seed production technology";
                $techActivity->device = $this->device();
                $techActivity->ip_env_address = $request->ip();
                $techActivity->ip_server_address = $request->server('SERVER_ADDR');
                $techActivity->OS = $this->operating_system();
                $techActivity->save();
            }

            $seedSoakingStart = date('Y-m-d H:i:s', strtotime($request->seedSoakingStart));

            // Update production plan add techID, seed soaking start and is_finalized
            $productionPlan = ProductionPlan::find($productionPlanID);
            $productionPlan->tech_id = $techID;
            $productionPlan->seed_soaking_start = $seedSoakingStart;
            $productionPlan->is_finalized = 1;
            $productionPlan->save();

            // Insert production plan activity log
            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $productionPlanID;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Updated production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->new_value = $techID;
            $productionPlanActivity->old_value = '';
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $productionPlanID;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Updated production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->new_value = $seedSoakingStart;
            $productionPlanActivity->old_value = '';
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $productionPlanID;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Updated production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->new_value = 1;
            $productionPlanActivity->old_value = 0;
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            // Add activities to database
            // Seed Soaking
            $seedSoakingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Seed Soaking"),
                'dateStart' => $seedSoakingStart,
                'dateEnd' => date('Y-m-d H:i:s', strtotime($request->seedSoakingEnd)),
                'dateAlert' => $this->date_alert($seedSoakingStart)
            );
            $this->store_planned_activity($seedSoakingData);

            // Seed Incubation
            $seedIncubationData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Seed Incubation"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->seedSoakingEnd)),
                'dateEnd' => date('Y-m-d H:i:s', strtotime($request->seedIncubationEnd)),
                'dateAlert' => $this->date_alert($request->seedSoakingEnd)
            );
            $this->store_planned_activity($seedIncubationData);

            // Seed Sowing
            $seedSowingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Seed Sowing"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->seedIncubationEnd)),
                'dateEnd' => date('Y-m-d H:i:s', strtotime($request->seedSowingEnd)),
                'dateAlert' => $this->date_alert($request->seedSowingEnd)
            );
            $this->store_planned_activity($seedSowingData);

            // Seedbed Irrigation
            $seedbedIrrigationDates = $request->seedbedIrrigationDates;
            foreach ($seedbedIrrigationDates as $date) {
                $date = explode("-", $date);
                $seedbedIrrigationData = array(
                    'productionPlanID' => $productionPlanID,
                    'activityID' => $this->activity("Seedbed Irrigation"),
                    'dateStart' => date('Y-m-d H:i:s', strtotime($date[0])),
                    'dateEnd' => date('Y-m-d H:i:s', strtotime($date[1])),
                    'dateAlert' => $this->date_alert($date[0])
                );
                $this->store_planned_activity($seedbedIrrigationData);
            }

            // Seedling Fertilizer App Init
            $seedlingFertilizerAppInitData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Seedling - Fertilizer Application"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->seedlingFertilizerAppInitDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->seedlingFertilizerAppInitDate)
            );
            $this->store_planned_activity($seedlingFertilizerAppInitData);

            // Seedling Fertilizer App Final
            $seedlingFertilizerAppFinalData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Seedling - Fertilizer Application"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->seedlingFertilizerAppFinalDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->seedlingFertilizerAppFinalDate)
            );
            $this->store_planned_activity($seedlingFertilizerAppFinalData);

            // Plowing
            $plowingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Plowing"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->plowingDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->plowingDate)
            );
            $this->store_planned_activity($plowingData);

            // Harrowing 1
            $harrowing1Data = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("1st Harrowing"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->harrowing1Date)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->harrowing1Date)
            );
            $this->store_planned_activity($harrowing1Data);

            // Harrowing 2
            $harrowing2Data = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("2nd Harrowing"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->harrowing2Date)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->harrowing2Date)
            );
            $this->store_planned_activity($harrowing2Data);

            // Harrowing 3
            $harrowing3Data = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("3rd Harrowing"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->harrowing3Date)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->harrowing3Date)
            );
            $this->store_planned_activity($harrowing3Data);

            // Levelling
            $levellingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("1st Harrowing"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->levellingDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->levellingDate)
            );
            $this->store_planned_activity($levellingData);

            // Transplanting
            $transplantingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Transplanting"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->transplantingDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->transplantingDate)
            );
            $this->store_planned_activity($transplantingData);

            // Replanting
            $replantingWindowDate = explode("-", $request->replantingWindowDate);
            $replantingWindowData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Replanting"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($replantingWindowDate[0])),
                'dateEnd' => date('Y-m-d H:i:s', strtotime($replantingWindowDate[1])),
                'dateAlert' => $this->date_alert($replantingWindowDate[0])
            );
            $this->store_planned_activity($replantingWindowData);

            // Irrigation
            $irrigationDates = $request->irrigationDates;
            foreach ($irrigationDates as $date) {
                $date = explode("-", $date);
                $irrigationData = array(
                    'productionPlanID' => $productionPlanID,
                    'activityID' => $this->activity("Irrigation"),
                    'dateStart' => date('Y-m-d H:i:s', strtotime($date[0])),
                    'dateEnd' => date('Y-m-d H:i:s', strtotime($date[1])),
                    'dateAlert' => $this->date_alert($date[0])
                );
                $this->store_planned_activity($irrigationData);
            }

            // 1st Fertilizer Application
            $Fertilizer1Data = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("1st Fertilizer Application"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->fertilizerApp1Date)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->fertilizerApp1Date)
            );
            $this->store_planned_activity($Fertilizer1Data);

            // 2nd Fertilizer Application
            $Fertilizer2Data = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("2nd Fertilizer Application"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->fertilizerApp2Date)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->fertilizerApp2Date)
            );
            $this->store_planned_activity($Fertilizer2Data);

            // 3rd Fertilizer Application
            $Fertilizer3Data = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("3rd Fertilizer Application"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->fertilizerApp3Date)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->fertilizerApp3Date)
            );
            $this->store_planned_activity($Fertilizer3Data);

            // Final Fertilizer Application
            $FertilizerFinalData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Final Fertilizer Application"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->fertilizerAppFinalDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->fertilizerAppFinalDate)
            );
            $this->store_planned_activity($FertilizerFinalData);

            // Roguing 10 DAT
            $Roguing10DATData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Roguing"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->roguing10DATDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->roguing10DATDate)
            );
            $this->store_planned_activity($Roguing10DATData);

            // Roguing 20 DAT
            $Roguing20DATData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Roguing"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->roguing20DATDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->roguing20DATDate)
            );
            $this->store_planned_activity($Roguing20DATData);

            // Pre-emergence Herbicide Application
            $preEmergenceAppData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Pre-emergence Herbicide Application"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->preEmergenceAppDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->preEmergenceAppDate)
            );
            $this->store_planned_activity($preEmergenceAppData);

            // Post-emergence Herbicide Application
            $postEmergenceAppData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Post-emergence Herbicide Application"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->postEmergenceAppDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->postEmergenceAppDate)
            );
            $this->store_planned_activity($postEmergenceAppData);

            // Harvesting
            $harvestingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Harvesting"),
                'dateStart' => date('Y-m-d H:i:s', strtotime($request->harvestingDate)),
                'dateEnd' => null,
                'dateAlert' => $this->date_alert($request->harvestingDate)
            );
            $this->store_planned_activity($harvestingData);

            DB::commit();

            $result = "success";
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            $result = "error";
        }

        echo json_encode($result);
    }

    // Returns the ID of the activity
    public function activity($activity) {
        $activity = Activity::select('activity_id')->where('name', '=', $activity)->first();
        return $activity->activity_id;
    }

    // Store planned activity to database
    public function store_planned_activity($data) {
        $plannedActivity = new PlannedActivity();
        $plannedActivity->production_plan_id = $data['productionPlanID'];
        $plannedActivity->activity_id = $data['activityID'];
        $plannedActivity->date_start = $data['dateStart'];
        $plannedActivity->date_end = $data['dateEnd'];
        $plannedActivity->date_alert = $data['dateAlert'];
        $plannedActivity->save();
    }

    // Calculate date of alert to mobile
    public function date_alert($date) {
        $dateAlert = date('Y-m-d H:i:s', strtotime($date . " - 1 day"));
        return $dateAlert;
    }

    // Returns the activities of the production plan
    public function activities(Request $request) {
        $productionPlanID = $request->productionPlanID;

        $activities = PlannedActivity::select('activity_id', 'date_start', 'date_end')->where('production_plan_id', '=', $productionPlanID)->get();

        $data = array();
        foreach ($activities as $activity) {
            $activityName = $activity->activity[0]->name;
            
            $data[] = array(
                'title' => $activityName,
                'start' => date('Y-m-d H:i ', strtotime($activity->date_start)),
                'end' => ($activity->date_end) ? date('Y-m-d H:i', strtotime($activity->date_end)) : ""
            );
        }

        echo json_encode($data);
    }

    public function generate_qrcode($id) {
        $productionPlanID = $id;

        // Get production plot code
        $productionPlotCode = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();

        // Get production plan
        $productionPlan = ProductionPlan::where('production_plan_id', '=', $productionPlanID)->first();

        // Get plots
        // $productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();

        // Get variety characteristics
        $seedChar = Seed::select('ecosystem', 'maturity')
                        ->where([
                            ['variety', '=', $productionPlan->variety],
                            ['variety_name', 'NOT LIKE', '%DWSR%']
                        ])
                        ->first();

        // $plots = array();

        // $totalArea = 0;

        // foreach ($productionPlots as $productionPlot) {
        //     $plotID = $productionPlot->plot_id;
        //     $plot = Plot::select('name', 'area')->where('plot_id', '=', $plotID)->first();

        //     $totalArea += $plot->area;
        //     array_push($plots, $plot->name);
        // }

        $fileName = $productionPlotCode->production_plot_code . ".pdf";
        // $pdf = PDF::loadView('production_plans.qrcode.template', compact(['productionPlotCode', 'productionPlan', 'plots', 'seedChar', 'totalArea']));
        $pdf = PDF::loadView('production_plans.qrcode.template', compact(['productionPlotCode', 'productionPlan', 'seedChar']));
        $customPaperSize = array(0,0,576.00,1440.00);
        $pdf->setPaper($customPaperSize, 'landscape');
        return $pdf->stream();
    }

    public function input_production_plan($id) {
        $role = $this->role();

        // Production Plan
        $productionPlan = ProductionPlan::where('production_plan_id', '=', $id)->first();

        // Variety
        $selectedVariety = $productionPlan->variety;
        $variety = Seed::select('variety', 'maturity')->where('variety', '=', $selectedVariety)->where('variety_name', 'NOT LIKE', '%DWSR%')->first();

        return view('input_production_plan.index', compact(['role', 'variety', 'productionPlan']));
    }

    public function store_input_production_plan(Request $request) {
        $productionPlanID = $request->productionPlanID;
        $soakingDate = date('Y-m-d H:i:s', strtotime($request->soakingDate));
        $sowingDate = date('Y-m-d H:i:s', strtotime($request->sowingDate));
        $transplantingDate = date('Y-m-d H:i:s', strtotime($request->transplantingDate));
        $harvestingDate = date('Y-m-d H:i:s', strtotime($request->harvestingDate));

        DB::beginTransaction();
        try {
            // Update production plan add seed soaking start and is_finalized
            $productionPlan = ProductionPlan::find($productionPlanID);
            $productionPlan->seed_soaking_start = $soakingDate;
            $productionPlan->is_finalized = 1;
            $productionPlan->save();

            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $productionPlanID;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Updated production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->new_value = $soakingDate;
            $productionPlanActivity->old_value = '';
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $productionPlanID;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Updated production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->new_value = 1;
            $productionPlanActivity->old_value = 0;
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            // Seed Soaking
            $seedSoakingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Seed Soaking"),
                'dateStart' => $soakingDate,
                'dateEnd' => null,
                'dateAlert' => $soakingDate
            );
            $this->store_planned_activity($seedSoakingData);

            // Seed Sowing
            $seedSowingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Seed Sowing"),
                'dateStart' => $sowingDate,
                'dateEnd' => null,
                'dateAlert' => $sowingDate
            );
            $this->store_planned_activity($seedSowingData);

            // Transplanting
            $transplantingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Transplanting"),
                'dateStart' => $transplantingDate,
                'dateEnd' => null,
                'dateAlert' => $transplantingDate
            );
            $this->store_planned_activity($transplantingData);

            // Harvesting
            $harvestingData = array(
                'productionPlanID' => $productionPlanID,
                'activityID' => $this->activity("Harvesting"),
                'dateStart' => $harvestingDate,
                'dateEnd' => null,
                'dateAlert' => $harvestingDate
            );
            $this->store_planned_activity($harvestingData);

            DB::commit();

            return redirect()->route('production_plans.index')->with('success', 'Production plan successfully saved.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->route('production_plans.index')->with('error', 'Error saving production plan.');
        }
    }

    public function varieties_planted(Request $request) {
        $year = $request->year;
        $sem = $request->sem;

        // For CES only
        $varieties = ProductionPlan::select('production_plan_id', 'variety')
                                    ->where([
                                        ['year', '=', $year],
                                        ['sem', '=', $sem],
                                        ['philrice_station_id', '=', 4],
                                        ['is_finalized', '=', 1]
                                    ])
                                    ->get();

        echo json_encode($varieties);
    }

    public function production_plan_plots(Request $request) {

        $productionPlanID = $request->productionPlanID;

        $productionPlots = ProductionPlot::select('plot_id')
                                    ->where('production_plan_id', '=', $productionPlanID)
                                    ->get();

        $plots = array();

        foreach ($productionPlots as $productionPlot) {

            $plot = Plot::select('name')
                        ->where('plot_id', '=', $productionPlot->plot_id)
                        ->first();

            array_push($plots, $plot->name);


        }

        $productionPlotCode = ProductionPlotCode::select('production_plot_code')
                                                ->where('production_plan_id', '=', $productionPlanID)
                                                ->first();

        $data = array(
            'plots' => $plots,
            'productionPlotCode' => $productionPlotCode->production_plot_code
        );


        echo json_encode($data);

    }

    public function seed_production_technology(Request $request) {
        $techID = $request->techID;

        $prodTech = SeedProductionTechnology::select('*')->where('tech_id', '=', $techID)->first();

        echo json_encode($prodTech);
    }

    public function view_plan_plots(Request $request) {
        $productionPlanID = $request->productionPlanID;

        $productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();

        $plots = array();

        foreach ($productionPlots as $productionPlot) {
            $plotID = $productionPlot->plot_id;
            $plot = Plot::select('name', 'coordinates', 'area')->where('plot_id', '=', $plotID)->first();
            array_push($plots, $plot);
        }

        echo json_encode($plots);
    }

    public function delete_finalized_plan(Request $request) {
        DB::beginTransaction();
        try {
            $productionPlanID = $request->productionPlanID;
            $remarks = $request->remarks;

            $productionPlan = ProductionPlan::find($productionPlanID);
            $productionPlan->is_deleted = 1;
            $productionPlan->remarks = $remarks;
            $productionPlan->save();

            // Insert production plan activity log
            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $productionPlanID;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Deleted finalized production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            DB::commit();

            $result = "success";
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // $result = $e->getMessage();

            $result = "error";
        }

        echo json_encode($result);
    }

    public function discontinue_production_plan(Request $request) {
        DB::beginTransaction();
        try {
            $production_plan_id = $request->production_plan_id;
            $remarks = $request->remarks;

            $productionPlan = ProductionPlan::find($production_plan_id);
            $productionPlan->is_deleted = 1;
            $productionPlan->remarks = $remarks;
            $productionPlan->save();

            // Insert production plan activity log
            $productionPlanActivity = new ProductionPlanActivities();
            $productionPlanActivity->production_plan_id = $production_plan_id;
            $productionPlanActivity->user_id = Auth::user()->user_id;
            $productionPlanActivity->browser = $this->browser();
            $productionPlanActivity->activity = "Discontinued production plan";
            $productionPlanActivity->device = $this->device();
            $productionPlanActivity->ip_env_address = $request->ip();
            $productionPlanActivity->ip_server_address = $request->server('SERVER_ADDR');
            $productionPlanActivity->OS = $this->operating_system();
            $productionPlanActivity->save();

            DB::commit();

            $result = "success";
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // $result = $e->getMessage();

            $result = "error";
        }

        echo json_encode($result);
    }

    public function show_municipalities(Request $request) {
        $province_code = $request->provinceCode;

        // Get region id and province id of province
        $province = Province::select('region_id', 'province_id')->where('prov_code', '=', $province_code)->first();
        $region_id = $province->region_id;
        $province_id = $province->province_id;

        // Get region code of province
        $region = Region::select('reg_code')->where('region_id', '=', $region_id)->first();
        $region_code = $region->reg_code;

        // Get municipalities under the province
        $municipalities = Municipality::select('mun_code', 'name')->where('province_id', '=', $province_id)->orderBy('name', 'asc')->get();

        $data = array(
            'region_code' => $region_code,
            'municipalities' => $municipalities
        );

        echo json_encode($data);
    }

    public function variety_targets(Request $request) {
        $target_varieties = TargetVarieties::select('variety')
        ->where([
            ['philrice_station_id', '=', $this->userStationID()],
            ['year', '=', $request->year],
            ['sem', '=', $request->sem],
            ['is_approved', '=', 2]
        ])
        ->groupBy('variety')
        ->orderBy('variety', 'asc')
        ->get();

        echo json_encode($target_varieties);
    }

    public function seed_class_targets(Request $request) {
        $seed_class_targets = TargetVarieties::select('seed_class')
        ->where([
            ['philrice_station_id', '=', $this->userStationID()],
            ['year', '=', $request->year],
            ['sem', '=', $request->sem],
            ['variety', '=', $request->variety],
            ['is_approved', '=', 2]
        ])
        ->groupBy('seed_class')
        ->orderBy('seed_class', 'asc')
        ->get();

        echo json_encode($seed_class_targets);
    }

    // Compare date start and date end
    public function compare_dates($date1, $date2) {
        $date1= date('M d, Y', strtotime($date1));
        $date2 = date('M d, Y', strtotime($date2));

        if ($date1 == $date2) {
            $date = $date1;
        } else {
            $date = $date1 . " - " . $date2;
        }

        return $date;
    }

    public function area_summary(Request $request) {
        $philrice_station_id = ($request->philriceStation != null) ? $request->philriceStation : $this->userStationID();

        $planned_area = DB::table('production_plans as plan')
        ->leftJoin('production_plots as planned_plots', 'plan.production_plan_id', '=', 'planned_plots.production_plan_id')
        ->leftJoin('plots', 'planned_plots.plot_id', '=', 'plots.plot_id')
        ->where([
            ['plan.year', '=', $request->year_filter],
            ['plan.sem', '=', $request->sem_filter],
            ['plan.is_finalized', '=', 1],
            ['plan.philrice_station_id', '=', $philrice_station_id]
        ])
        ->select(DB::raw('SUM(CAST(plots.area AS DECIMAL(10,4))) AS total_area_planned'))
        ->first();

        $production_plans = DB::table('production_plans as plan')
        ->leftJoin('production_plot_codes as plot_codes', 'plan.production_plan_id', '=', 'plot_codes.production_plan_id')
        ->select('plan.production_plan_id', 'plot_codes.production_plot_code')
        ->where([
            ['plan.year', '=', $request->year_filter],
            ['plan.sem', '=', $request->sem_filter],
            ['plan.is_finalized', '=', 1],
            ['plan.philrice_station_id', '=', $philrice_station_id]
        ])
        ->get();

        $planted_area = 0;

        foreach ($production_plans as $item) {
            // Check if there is a transplanting data sent from sp app
            $production_plot_code = $item->production_plot_code;
            $production_plan_id = $item->production_plan_id;

            $transplanting = CropEstablishment::where('production_plot_code', '=', $production_plot_code)->get()->count();

            if ($transplanting > 0) {
                $productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $production_plan_id)->get();

                $actual_production_plots = ActualProductionPlot::select('plot_id')
                                                                ->where('production_plan_id', '=', $production_plan_id)
                                                                ->get();

                $area = 0;

                if ($actual_production_plots->count() > 0) {
                    foreach ($actual_production_plots as $productionPlot) {
                        $plotID = $productionPlot->plot_id;

                        $plot = Plot::select('area')->where('plot_id', '=', $plotID)->first();

                        $area += floatval($plot->area);
                    }
                } else {
                    foreach ($productionPlots as $productionPlot) {
                        $plotID = $productionPlot->plot_id;

                        $plot = Plot::select('area')->where('plot_id', '=', $plotID)->first();

                        $area += floatval($plot->area);
                    }
                }

                $planted_area += $area;
            }
        }

        $data = array('planned_area' => floatval($planned_area->total_area_planned), 'planted_area' => floatval($planted_area));

        echo json_encode($data);
    }

    public function getPlots(Request $request)
    {
        $farmer_id = $request->farmer_id;

        // get plots that has a farmer_id of the request and is active
        $plots = Plot::select('plot_id', 'name', 'coordinates')->where('farmer_id', '=', $farmer_id)->where('is_active', '=', 1)->get();

        echo json_encode($plots);
    }
}
