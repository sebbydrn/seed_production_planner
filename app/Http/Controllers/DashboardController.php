<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AffiliationUser;
use App\Station;
use App\ProductionPlan;
use App\ProductionPlot;
use App\ProductionPlotCode;
use App\SeedTraceGeotag\SeedlingManagement;
use App\SeedTraceGeotag\LandPreparation;
use App\SeedTraceGeotag\CropEstablishment;
use App\SeedTraceGeotag\WaterManagement;
use App\SeedTraceGeotag\NutrientManagement;
use App\SeedTraceGeotag\DiseaseManagement;
use App\SeedTraceGeotag\PestManagement;
use App\SeedTraceGeotag\Roguing;
use App\SeedTraceGeotag\Offtype;
use App\SeedTraceGeotag\Harvesting;
use App\SeedTraceGeotag\DamageAssessment;
use Auth, Entrust;

class DashboardController extends Controller {
    
    public function __construct() {
        $this->middleware('permission:view_dashboard')->only(['index']);
    }

	public function index() {
		$role = $this->role();

		if (Entrust::can('view_dashboard_all_stations')) {
			$philriceStationID = 0;
			$varietiesPlanted = "";
		} else {
			$philriceStationID = $this->userStationID();
			$varietiesPlanted = ProductionPlan::select('variety')->where('philrice_station_id', '=', $philriceStationID)->groupBy('variety')->get();
		}

		// PhilRice stations
		$stations = Station::select('philrice_station_id', 'name')->get();

		return view('dashboard.index', compact(['role', 'philriceStationID', 'stations', 'varietiesPlanted']));
	}

	// StationID of logged in user
    public function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }

    // Varieties planted of the station
    public function varieties_planted(Request $request) {
    	$stationID = $request->stationID;
    	$year = $request->year;
    	$sem = $request->sem;
    	$varietiesPlanted = ProductionPlan::select('variety')
    									->where('philrice_station_id', '=', $stationID)
    									->where('year', '=', $year)
    									->where('sem', '=', $sem)
    									->where('is_finalized', '=', 1)
    									->groupBy('variety')->get();
    	echo json_encode($varietiesPlanted);
    }

    public function show_activities(Request $request) {
    	$stationID = $request->stationID;
    	$year = $request->year;
    	$sem = $request->sem;
    	$variety = $request->variety;

    	$productionPlans = ProductionPlan::select('*')
    									->where('philrice_station_id', '=', $stationID)
    									->where('year', '=', $year)
    									->where('sem', '=', $sem)
    									->where('is_finalized', '=', 1);
    	if ($variety == "All Varieties") {
    		$productionPlans = $productionPlans->get();
    	} else {
    		$productionPlans = $productionPlans->where('variety', '=', $variety)->get();
    	}

    	$data = array();
    	$data['plots'] = array();
    	$data['seedlingManagement'] = array();
    	$data['landPreparation'] = array();
    	$data['cropEstablishment'] = array();
    	$data['waterManagement'] = array();
    	$data['nutrientManagement'] = array();
    	$data['diseaseManagement'] = array();
    	$data['pestManagement'] = array();
    	$data['roguing'] = array();
    	$data['harvesting'] = array();
    	$data['damageAssessment'] = array();

    	foreach ($productionPlans as $productionPlan) {
    		$productionPlanID = $productionPlan->production_plan_id;

    		// Plots
    		$productionPlots = ProductionPlot::where('production_plan_id', '=', $productionPlanID)->get();

    		foreach ($productionPlots as $productionPlot) {
    			$coordinates = $productionPlot->area->coordinates;
    			$plotName = $productionPlot->area->name;
    			$plotArea = $productionPlot->area->area;
    			$variety = $productionPlan->variety;
    			$seedClass = $productionPlan->seed_class;

    			$plot = array(
    				'coordinates' => $coordinates,
    				'variety' => $variety,
    				'seedClass' => $seedClass,
    				'plotName' => $plotName,
    				'plotArea' => $plotArea
    			);
    			
    			array_push($data['plots'], $plot);
    		}

    		// Production Plot Code
    		$productionPlotCode = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();
    		$code = $productionPlotCode->production_plot_code;

    		// Seedling Management Activities
    		$seedlingManagement = SeedlingManagement::where('production_plot_code', '=', $code)->get();

    		foreach ($seedlingManagement as $item) {
    			$activity = array(
    				'activity' => $item->activity,
    				'status' => $item->status,
    				'timestamp' => date('F d, Y h:i a', strtotime($item->timestamp)),
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point
    			);

    			array_push($data['seedlingManagement'], $activity);
    		}

    		// Land Preparation Activities
    		$landPreparation = LandPreparation::where('production_plot_code', '=', $code)->get();

    		foreach ($landPreparation as $item) {
    			$activity = array(
    				'cropPhase' => $item->crop_phase,
    				'activity' => $item->activity,
    				'datetimeStart' => date('F d, Y h:i a', strtotime($item->datetime_start)),
    				'datetimeEnd' => date('F d, Y h:i a', strtotime($item->datetime_end)),
    				'laborCost' => $item->labor_cost,
    				'workersNo' => $item->workers_no,
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point 
    			);

    			array_push($data['landPreparation'], $activity);
    		}

    		// Crop Establishment
    		$cropEstablishment = CropEstablishment::where('production_plot_code', '=', $code)->get();

    		foreach ($cropEstablishment as $item) {
    			$activity = array(
    				'activity' => $item->activity,
    				'transplantingMethod' => $item->transplanting_method,
    				'datetimeStart' => date('F d, Y h:i a', strtotime($item->datetime_start)),
    				'datetimeEnd' => date('F d, Y h:i a', strtotime($item->datetime_end)),
    				'laborCost' => $item->labor_cost,
    				'workersNo' => $item->workers_no,
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point 
    			);

    			array_push($data['cropEstablishment'], $activity);
    		}

    		// Water Management
    		$waterManagement = WaterManagement::where('production_plot_code', '=', $code)->get();

    		foreach ($waterManagement as $item) {
    			$activity = array(
    				'cropPhase' => $item->crop_phase,
    				'cropStage' => $item->crop_stage,
    				'activity' => $item->activity,
    				'datetimeStart' => date('F d, Y h:i a', strtotime($item->datetime_start)),
    				'datetimeEnd' => date('F d, Y h:i a', strtotime($item->datetime_end)),
    				'laborCost' => $item->labor_cost,
    				'workersNo' => $item->workers_no,
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point
    			);

    			array_push($data['waterManagement'], $activity);
    		}

    		// Nutrient Management
    		$nutrientManagement = NutrientManagement::where('production_plot_code', '=', $code)->get();

    		foreach ($nutrientManagement as $item) {
    			$activity = array(
    				'cropPhase' => $item->crop_phase,
    				'technologyUsed' => $item->technology_used,
    				'fertilizerUsed' => $item->fertilizer_used,
    				'otherFertilizer' => $item->other_fertilizer,
    				'formulation' => $item->formulation,
    				'unit' => $item->unit,
    				'totalChemicalUsed' => $item->total_chemical_used,
    				'tankLoadNo' => $item->tank_load_no,
    				'tankLoadVolume' => $item->tank_load_volume,
    				'tankLoadRate' => $item->tank_load_rate,
    				'datetimeStart' => date('F d, Y h:i a', strtotime($item->datetime_start)),
    				'datetimeEnd' => date('F d, Y h:i a', strtotime($item->datetime_end)),
    				'laborCost' => $item->labor_cost,
    				'workersNo' => $item->workers_no,
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point,
    				'isWaterAvailable' => $item->is_water_available
    			);

    			array_push($data['nutrientManagement'], $activity);
    		}

    		// Disease Management
    		$diseaseManagement = DiseaseManagement::where('production_plot_code', '=', $code)->get();

    		foreach ($diseaseManagement as $item) {
    			$activity = array(
    				'cropPhase' => $item->crop_phase,
    				'diseaseType' => $item->disease_type,
    				'otherDisease' => $item->other_disease,
    				'controlType' => $item->control_type,
    				'controlSpec' => $item->control_spec,
    				'chemicalUsed' => $item->chemical_used,
    				'activeIngredient' => $item->active_ingredient,
    				'applicationMode' => $item->application_mode,
    				'brandName' => $item->brand_name,
    				'formulation' => $item->formulation,
    				'unit' => $item->unit,
    				'totalChemicalUsed' => $item->total_chemical_used,
    				'tankLoadNo' => $item->tank_load_no,
    				'tankLoadVolume' => $item->tank_load_volume,
    				'tankLoadRate' => $item->tank_load_rate,
    				'datetimeStart' => date('F d, Y h:i a', strtotime($item->datetime_start)),
    				'datetimeEnd' => date('F d, Y h:i a', strtotime($item->datetime_end)),
    				'laborCost' => $item->labor_cost,
    				'workersNo' => $item->workers_no,
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point,
    			);

    			array_push($data['diseaseManagement'], $activity);
    		}

    		// Pest Management
    		$pestManagement = PestManagement::where('production_plot_code', '=', $code)->get();

    		foreach ($pestManagement as $item) {
    			$activity = array(
    				'cropPhase' => $item->crop_phase,
    				'pestType' => $item->pest_type,
    				'pestSpec' => $item->pest_spec,
    				'controlType' => $item->control_type,
    				'controlSpec' => $item->control_spec,
    				'chemicalUsed' => $item->chemical_used,
    				'activeIngredient' => $item->active_ingredient,
    				'applicationMode' => $item->application_mode,
    				'brandName' => $item->brand_name,
    				'formulation' => $item->formulation,
    				'unit' => $item->unit,
    				'totalChemicalUsed' => $item->total_chemical_used,
    				'tankLoadNo' => $item->tank_load_no,
    				'tankLoadVolume' => $item->tank_load_volume,
    				'tankLoadRate' => $item->tank_load_rate,
    				'datetimeStart' => date('F d, Y h:i a', strtotime($item->datetime_start)),
    				'datetimeEnd' => date('F d, Y h:i a', strtotime($item->datetime_end)),
    				'laborCost' => $item->labor_cost,
    				'workersNo' => $item->workers_no,
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point,
    			);

    			array_push($data['pestManagement'], $activity);
    		}

    		// Roguing
    		$roguing = Roguing::where('production_plot_code', '=', $code)->get();

    		foreach ($roguing as $item) {
    			$roguingID = $item->roguing_id;
    			$offtypes = Offtype::where('roguing_id', '=', $roguingID)->get();
    			$offtypesKind = "";

    			foreach ($offtypes as $offtype) {
    				$offtypesKind .= $offtype->offtype_kind . "; ";
    			}

    			$activity = array(
    				'cropPhase' => $item->crop_phase,
    				'offtypesRemovedCount' => $item->offtypes_removed_count,
    				'timestamp' => date('F d, Y h:i a', strtotime($item->timestamp)),
    				'remarks' => $item->remarks,
    				'laborers' => $item->laborers,
    				'locationPoint' => $item->location_point,
    				'offtypesKind' => $offtypesKind
    			);

    			array_push($data['roguing'], $activity);
    		}

    		// Harvesting
    		$harvesting = Harvesting::where('production_plot_code', '=', $code)->get();

    		foreach ($harvesting as $item) {
    			$activity = array(
    				'harvestingMethod' => $item->harvesting_method,
    				'timestamp' => date('F d, Y h:i a', strtotime($item->timestamp)),
    				'bagsNo' => $item->bags_no,
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point
    			);

    			array_push($data['harvesting'], $activity);
    		}

    		// Damage Assessment
    		$damageAssessment = DamageAssessment::where('production_plot_code', '=', $code)->get();

    		foreach ($damageAssessment as $item) {
    			$activity = array(
    				'timestamp' => date('F d, Y h:i a', strtotime($item->timestamp)),
    				'damageCause' => $item->damage_cause,
    				'damageSpec' => $item->damage_spec,
    				'remarks' => $item->remarks,
    				'locationPoint' => $item->location_point
    			);

    			array_push($data['damageAssessment'], $activity);
    		}
    	}
    									
    	echo json_encode($data);
    }

    public function years(Request $request) {
    	$stationID = $request->stationID;
    	$years = ProductionPlan::select('year')->where('philrice_station_id', '=', $stationID)->groupBy('year')->get();
    	echo json_encode($years);
    }


}
