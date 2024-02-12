<?php

namespace App\Http\Controllers\SeedTraceGeotag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SeedTraceGeotag\Roguing;
use App\SeedTraceGeotag\Offtype;
use App\AffiliationUser;
use App\ProductionPlan;
use App\ProductionPlotCode;
use Auth, DB, Session;
use Yajra\Datatables\Datatables;

class RoguingController extends Controller {
    
    public function __construct() {
        $this->middleware('permission:view_seedtrace_geotag_forms')->only(['index', 'show', 'datatable']);
        $this->middleware('permission:add_seedtrace_geotag_form')->only(['create', 'store']);
    }
    
	public function index() {
		$role = $this->role();

		return view('seed_trace_geotag.roguing.index', compact(['role']));
	}

	public function create() {
		$role = $this->role();

		$philriceStationID = $this->userStationID();

		// Production plan years
		$years = ProductionPlan::select('year')->groupBy('year')->get();

		return view('seed_trace_geotag.roguing.create', compact(['role', 'philriceStationID', 'years']));
	}

	public function store(Request $request) {
		DB::beginTransaction();
		try {
			$data = new Roguing();
			$data->production_plot_code = $request->productionPlotCode;
			$data->crop_phase = $request->cropPhase;
			$data->offtypes_removed_count = $request->offtypesRemovedCount;
			$data->timestamp = date('Y-m-d H:i', strtotime($request->date . ' ' . $request->time));
			$data->laborers = $request->laborers;
			$data->remarks = $request->remarks;
			$data->location_point = $request->locationPoint;
			$data->save();
			$roguingID =  $data->roguing_id;

			foreach ($request->offtypeKind as $offtypeKind) {
				$offtype = new Offtype();
				$offtype->roguing_id = $roguingID;
				$offtype->offtype_kind = $offtypeKind;
				$offtype->save();
			}

			DB::commit();

			return redirect()->back()->with('success', 'Roguing form successfully added.');
		} catch (Exception $e) {
			DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error adding roguing form.');
		}
	}

	public function show($id) {
		$roguing = Roguing::where('roguing_id', '=', $id)->first();
		$offtype = OffType::where('roguing_id', '=', $id)->get();
		$data = array('roguing' => $roguing, 'offtype' => $offtype);

        echo json_encode($data);
	}

	public function datatable(Request $request) {
		$data = Roguing::get();
		$data = collect($data);

		return Datatables::of($data)
			->addColumn('datetime', function($data) {
				return date('Y-m-d h:i a', strtotime($data->timestamp));
			})
			->addColumn('actions', function($data) {
				$actions = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-info' onclick='viewFormInfo(".$data->roguing_id.")'><i class='fa fa-eye'></i> View</button>&nbsp;";

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

    	$roguing = Roguing::select('crop_phase', 'timestamp')
    											->where('production_plot_code', '=', $productionPlotCode)
    											->get();

    	$data = array();
    	if ($roguing) {
	    	foreach ($roguing as $item) {
	    		$activityName = "Roguing (" . $item->crop_phase . ")";
	            
	            $data[] = array(
	                'title' => $activityName,
	                'start' => date('Y-m-d H:i ', strtotime($item->timestamp)),
	                // 'end' => date('Y-m-d H:i ', strtotime($item->datetime_end)),
	            );
	    	}
    	}

    	echo json_encode($data);
    }

}
