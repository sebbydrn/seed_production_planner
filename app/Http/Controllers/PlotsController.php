<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plot;
use App\User;
use App\AffiliationUser;
use App\PlotActivities;
use App\Station;
use App\Farmer;
use Auth, DB, Session, Validator, Entrust;
use Yajra\Datatables\Datatables;

class PlotsController extends Controller {

    public function __construct() {
        $this->middleware('permission:view_plots')->only(['index', 'show', 'datatable', 'view_all_plots']);
        $this->middleware('permission:add_plots')->only(['create', 'store']);
        $this->middleware('permission:update_plot_status')->only(['update_plot_status', 'multiple_update_plot_status']);
    }

    public function index() {
        $role = $this->role();

        $philriceStationID = $this->userStationID();

        $philriceStations = Station::orderBy('philrice_station_id', 'ASC')->get();

        return view('plots.index', compact(['role', 'philriceStationID', 'philriceStations']));
    }

    public function create() {
        $role = $this->role();

        // active farmers
        $farmers = Farmer::select('farmer_id', 'first_name', 'last_name')->where('is_active', 1)->orderBy('first_name', 'asc')->get();

        // Active plots
        $activePlots = Plot::select('name')->where('is_active', 1)->orderBy('name', 'asc')->get();

        return view('plots.create', compact(['role', 'philriceStationID', 'activePlots', 'farmers']));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'farmer' => 'required',
            'name' => 'required',
            'coordinates' => 'required',
            'area' => 'required|regex:/^\d*(\.\d{1,8})?$/'
        ], [
            'area.regex' => 'The area field only accepts numbers and two decimal digits.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Insert created plot to database
            $plot = new Plot();
            $plot->name = $request->name;
            $plot->coordinates = $request->coordinates;
            $plot->area = $request->area;
            $plot->farmer_id = $request->farmer;
            $plot->save();
            $plotID = $plot->plot_id;

            // Insert plot activity log
            $plotActivity = new PlotActivities();
            $plotActivity->plot_id = $plotID;
            $plotActivity->user_id = Auth::user()->user_id;
            $plotActivity->browser = $this->browser();
            $plotActivity->activity = "Added new plot";
            $plotActivity->device = $this->device();
            $plotActivity->ip_env_address = $request->ip();
            $plotActivity->ip_server_address = $request->server('SERVER_ADDR');
            $plotActivity->OS = $this->operating_system();
            $plotActivity->save();

            DB::commit();

            // return redirect()->route('plots.create')->with('success', 'New plot successfully added.');
            $result = "success";
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            // return redirect()->route('plots.create')->with('error', 'Error adding new plot.');
            $result = "error";
        }

        echo json_encode($result);
    }

    public function show($id) {
        $plot = Plot::where('plot_id', $id)->first();
        echo json_encode($plot);
    }

    // StationID of logged in user
    public function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }

    // Datatable
    public function datatable(Request $request) {
        $plots = Plot::select('*');

        if (isset($request->is_active)) {
            $is_active = $request->is_active;
            $plots = $plots->where('is_active', '=', $is_active); // TODO: commit this
        }

        $plots = $plots->get();

        $data = collect($plots);

        return Datatables::of($data)
            ->addColumn('status', function($data) {
                if ($data->is_active == 1) {
                    $status = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-success'><i class='fa fa-check-circle'></i> Active</button>";
                } elseif ($data->is_active == 0) {
                    $status = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-danger'><i class='fa fa-ban'></i> Deactivated</button>";
                }

                return $status;
            })
            ->addColumn('farmer', function($data) {
                // get farmer name
                $farmer = Farmer::select('first_name', 'last_name')->where('farmer_id', $data->farmer_id)->first();
                $farmer_name = $farmer->first_name . " " . $farmer->last_name;
                return $farmer_name;
            })
            ->addColumn('actions', function($data) {
                $actions = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-info' onclick='viewPlotInfo(".$data->plot_id.")'><i class='fa fa-eye'></i> View</button>&nbsp;";

                if (Entrust::can('update_plot_status')) {
                    if ($data->is_active == 1) {
                        $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-danger' onclick='updatePlotStatus(".$data->plot_id.", 0)'><i class='fa fa-ban'></i> Deactivate</button>";
                    } elseif ($data->is_active == 0) {
                        $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-success' onclick='updatePlotStatus(".$data->plot_id.", 1)'><i class='fa fa-check-circle'></i> Activate</button>";
                    }
                }

                return $actions;
            })
            ->rawColumns(['farmer', 'status', 'actions'])
            ->make(true);
    }

    public function active_plots() {
        $plots = Plot::select('name', 'coordinates', 'area')->where('is_active', '=', 1);

        if (Entrust::can('view_all_plots')) {
            $plots = $plots->get();
        }

        echo json_encode($plots);
    }

    public function update_plot_status(Request $request) {
        $plot_id = $request->plot_id;
        $is_active = $request->is_active;

        DB::beginTransaction();
        try {
            // Update plot row
            $plot = Plot::find($plot_id);
            $plot->is_active = $is_active;
            $plot->save();

            // Insert plot activity log
            $plotActivity = new PlotActivities();
            $plotActivity->plot_id = $plot_id;
            $plotActivity->user_id = Auth::user()->user_id;
            $plotActivity->browser = $this->browser();
            if ($is_active == 1) {
                $plotActivity->activity = "Activated plot";
            } elseif ($is_active == 0) {
                $plotActivity->activity = "Deactivated plot";
            }
            $plotActivity->device = $this->device();
            $plotActivity->ip_env_address = $request->ip();
            $plotActivity->ip_server_address = $request->server('SERVER_ADDR');
            $plotActivity->OS = $this->operating_system();
            $plotActivity->save();

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

    public function multiple_update_plot_status(Request $request) {
        $plotIDs = $request->plotIDs;
        $is_active = $request->is_active;

        DB::beginTransaction();
        try {
            foreach ($plotIDs as $plot_id) {
                // Update plot row
                $plot = Plot::find($plot_id);
                $plot->is_active = $is_active;
                $plot->save();

                // Insert plot activity log
                $plotActivity = new PlotActivities();
                $plotActivity->plot_id = $plot_id;
                $plotActivity->user_id = Auth::user()->user_id;
                $plotActivity->browser = $this->browser();
                if ($is_active == 1) {
                    $plotActivity->activity = "Activated plot";
                } elseif ($is_active == 0) {
                    $plotActivity->activity = "Deactivated plot";
                }
                $plotActivity->device = $this->device();
                $plotActivity->ip_env_address = $request->ip();
                $plotActivity->ip_server_address = $request->server('SERVER_ADDR');
                $plotActivity->OS = $this->operating_system();
                $plotActivity->save();
            }

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

    public function view_all_plots() {
        $role = $this->role();

        $philriceStationID = $this->userStationID();

        return view('plots.viewAll', compact(['role', 'philriceStationID']));
    }

}
