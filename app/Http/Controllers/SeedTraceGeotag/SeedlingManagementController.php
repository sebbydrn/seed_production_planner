<?php

namespace App\Http\Controllers\SeedTraceGeotag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SeedTraceGeotag\SeedlingManagement;
use App\AffiliationUser;
use App\ProductionPlan;
use App\ProductionPlotCode;
use Auth, DB, Session;
use Yajra\Datatables\Datatables;

class SeedlingManagementController extends Controller {
    
    public function __construct() {
        $this->middleware('permission:view_seedtrace_geotag_forms')->only(['index', 'show', 'datatable']);
        $this->middleware('permission:add_seedtrace_geotag_form')->only(['create', 'store']);
    }
    
	public function index() {
		$role = $this->role();

		return view('seed_trace_geotag.seedling_management.index', compact(['role']));
	}

	public function create() {
		$role = $this->role();
		
		$philriceStationID = $this->userStationID();

		// Production plan years
		$years = ProductionPlan::select('year')->groupBy('year')->get();

		return view('seed_trace_geotag.seedling_management.create', compact(['role', 'philriceStationID', 'years']));
	}

	public function store(Request $request) {
		DB::beginTransaction();
		try {
			$data = new SeedlingManagement();
			$data->production_plot_code = $request->productionPlotCode;
			$data->activity = $request->activity;
			$data->status = $request->status;
			$data->timestamp = date('Y-m-d H:i', strtotime($request->date . ' ' . $request->time));
			$data->remarks = $request->remarks;
			$data->location_point = $request->locationPoint;
			$data->save();

			DB::commit();

			return redirect()->back()->with('success', 'Seedling management form successfully added.');
		} catch (Exception $e) {
			DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error adding seedling management form.');
		}
	}

	public function show($id) {
        $seedlingManagement = SeedlingManagement::where('seedling_management_id', $id)->first();
        echo json_encode($seedlingManagement);
    }

	public function datatable(Request $request) {
		$data = SeedlingManagement::get();
		$data = collect($data);

		return Datatables::of($data)
			->addColumn('timestamp', function($data) {
				return date('Y-m-d h:i a', strtotime($data->timestamp));
			})
			->addColumn('actions', function($data) {
				$actions = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-info' onclick='viewFormInfo(".$data->seedling_management_id.")'><i class='fa fa-eye'></i> View</button>&nbsp;";

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

    	$seedlingManagement = SeedlingManagement::select('activity', 'status', 'timestamp')
    											->where('production_plot_code', '=', $productionPlotCode)
    											->get();

    	$data = array();
    	if ($seedlingManagement) {
	    	foreach ($seedlingManagement as $item) {
	    		$activityName = $item->activity . " (" . $item->status . ")";
	            
	            $data[] = array(
	                'title' => $activityName,
	                'start' => date('Y-m-d H:i ', strtotime($item->timestamp)),
	                // 'end' => date('Y-m-d H:i ', strtotime($item->timestamp))
	            );
	    	}
    	}

    	echo json_encode($data);
    }

}
