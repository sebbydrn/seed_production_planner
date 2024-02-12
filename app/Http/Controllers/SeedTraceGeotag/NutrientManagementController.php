<?php

namespace App\Http\Controllers\SeedTraceGeotag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SeedTraceGeotag\NutrientManagement;
use App\AffiliationUser;
use App\ProductionPlan;
use App\ProductionPlotCode;
use Auth, DB, Session;
use Yajra\Datatables\Datatables;

class NutrientManagementController extends Controller {
    
    public function __construct() {
        $this->middleware('permission:view_seedtrace_geotag_forms')->only(['index', 'show', 'datatable']);
        $this->middleware('permission:add_seedtrace_geotag_form')->only(['create', 'store']);
    }
    
	public function index() {
		$role = $this->role();

		return view('seed_trace_geotag.nutrient_management.index', compact(['role']));
	}

	public function create() {
		$role = $this->role();

		$philriceStationID = $this->userStationID();

		// Production plan years
		$years = ProductionPlan::select('year')->groupBy('year')->get();

		return view('seed_trace_geotag.nutrient_management.create', compact(['role', 'philriceStationID', 'years']));
	}

	public function store(Request $request) {
		DB::beginTransaction();
		try {
			$data = new NutrientManagement();
			$data->production_plot_code = $request->productionPlotCode;
			$data->crop_phase = $request->cropPhase;
			$data->technology_used = $request->technologyUsed;
			$data->fertilizer_used = $request->fertilizerUsed;
			$data->other_fertilizer = $request->otherFertilizer;
			$data->formulation = $request->formulation;
			$data->unit = $request->unit;
			$data->total_chemical_used = $request->totalChemicalUsed;
			$data->tank_load_no = $request->tankLoadNo;
			$data->tank_load_volume = $request->tankLoadVolume;
			$data->tank_load_rate = $request->tankLoadRate;
			$data->datetime_start = date('Y-m-d H:i', strtotime($request->dateStart . ' ' . $request->timeStart));
			$data->datetime_end = date('Y-m-d H:i', strtotime($request->dateEnd . ' ' . $request->timeEnd));
			$data->labor_cost = $request->laborCost;
			$data->workers_no = $request->workersNo;
			$data->remarks = $request->remarks;
			$data->is_water_available = $request->isWaterAvailable;
			$data->location_point = $request->locationPoint;
			$data->save();

			DB::commit();

			return redirect()->back()->with('success', 'Nutrient management form successfully added.');
		} catch (Exception $e) {
			DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error adding nutrient management form.');
		}
	}

	public function show($id) {
		$nutrientManagement = NutrientManagement::where('nutrient_management_id', $id)->first();
        echo json_encode($nutrientManagement);
	}

	public function datatable(Request $request) {
		$data = NutrientManagement::get();
		$data = collect($data);

		return Datatables::of($data)
			->addColumn('datetime_start', function($data) {
				return date('Y-m-d h:i a', strtotime($data->datetime_start));
			})
			->addColumn('datetime_end', function($data) {
				return date('Y-m-d h:i a', strtotime($data->datetime_end));
			})
			->addColumn('actions', function($data) {
				$actions = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-info' onclick='viewFormInfo(".$data->nutrient_management_id.")'><i class='fa fa-eye'></i> View</button>&nbsp;";

				return $actions;
			})
			->rawColumns(['actions'])
			->make(true);
	}

	// StationID of logged in user
    public function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }

    public function activities(Request $request) {
    	$productionPlanID = $request->productionPlanID;

    	$productionPlotCodes = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();
    	$productionPlotCode = $productionPlotCodes->production_plot_code;

    	$nutrientManagement = NutrientManagement::select('crop_phase', 'datetime_start', 'datetime_end')
    											->where('production_plot_code', '=', $productionPlotCode)
    											->get();

    	$data = array();
    	if ($nutrientManagement) {
	    	foreach ($nutrientManagement as $item) {
	    		$activityName = "Fertilizer Application (" . $item->crop_phase . ")";
	            
	            $data[] = array(
	                'title' => $activityName,
	                'start' => date('Y-m-d H:i ', strtotime($item->datetime_start)),
	                'end' => date('Y-m-d H:i ', strtotime($item->datetime_end)),
	            );
	    	}
    	}

    	echo json_encode($data);
    }

}
