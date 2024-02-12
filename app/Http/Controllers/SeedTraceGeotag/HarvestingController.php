<?php

namespace App\Http\Controllers\SeedTraceGeotag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SeedTraceGeotag\Harvesting;
use App\AffiliationUser;
use App\ProductionPlan;
use App\ProductionPlotCode;
use Auth, DB, Session;
use Yajra\Datatables\Datatables;

class HarvestingController extends Controller {
    
    public function __construct() {
        $this->middleware('permission:view_seedtrace_geotag_forms')->only(['index', 'show', 'datatable']);
        $this->middleware('permission:add_seedtrace_geotag_form')->only(['create', 'store']);
    }
    
	public function index() {
		$role = $this->role();

		return view('seed_trace_geotag.harvesting.index', compact(['role']));
	}

	public function create() {
		$role = $this->role();

		$philriceStationID = $this->userStationID();

		// Production plan years
		$years = ProductionPlan::select('year')->groupBy('year')->get();

		return view('seed_trace_geotag.harvesting.create', compact(['role', 'philriceStationID', 'years']));
	}

	public function store(Request $request) {
		DB::beginTransaction();
		try {
			$data = new Harvesting();
			$data->production_plot_code = $request->productionPlotCode;
			$data->harvesting_method = $request->harvestingMethod;
			$data->timestamp = date('Y-m-d H:i', strtotime($request->date . ' ' . $request->time));
			$data->bags_no = $request->bagsNo;
			$data->remarks = $request->remarks;
			$data->location_point = $request->locationPoint;
			$data->save();

			DB::commit();

			return redirect()->back()->with('success', 'Harvesting form successfully added.');
		} catch (Exception $e) {
			DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error adding harvesting form.');
		}
	}

	public function show($id) {
        $harvesting = Harvesting::where('harvesting_id', $id)->first();
        echo json_encode($harvesting);
    }

	public function datatable(Request $request) {
		$data = Harvesting::get();
		$data = collect($data);

		return Datatables::of($data)
			->addColumn('datetime', function($data) {
				return date('Y-m-d h:i a', strtotime($data->timestamp));
			})
			->addColumn('actions', function($data) {
				$actions = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-info' onclick='viewFormInfo(".$data->harvesting_id.")'><i class='fa fa-eye'></i> View</button>&nbsp;";

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

    	$harvesting = Harvesting::select('timestamp')
    											->where('production_plot_code', '=', $productionPlotCode)
    											->get();

    	$data = array();
    	if ($harvesting) {
	    	foreach ($harvesting as $item) {
	            $data[] = array(
	                'title' => "Harvesting",
	                'start' => date('Y-m-d H:i ', strtotime($item->timestamp)),
	                // 'end' => date('Y-m-d H:i ', strtotime($item->timestamp)),
	            );
	    	}
    	}

    	echo json_encode($data);
    }


}
