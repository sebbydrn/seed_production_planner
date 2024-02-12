<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\ActivitiesLogs;
use App\User;
use App\AffiliationUser;
use App\Station;
use Auth, DB, Session, Validator, Entrust;
use Yajra\Datatables\Datatables;

class ActivitiesController extends Controller {

    public function __construct() {
        $this->middleware('permission:view_seed_production_activities')->only(['index', 'show', 'datatable']);
        $this->middleware('permission:add_seed_production_activity')->only(['create', 'store']);
        $this->middleware('permission:edit_seed_production_activity')->only(['edit', 'update']);
    }

    public function index() {
        $role = $this->role();

        return view('activities.index', compact(['role']));
    }

    public function create() {
        $role = $this->role();

        return view('activities.create', compact(['role']));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'The activity name field is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Insert activity to database
            $activity = new Activity();
            $activity->name = $request->name;
            $activity->save();
            $activityID = $activity->activity_id;

            // Insert activity log
            $activityLog = new ActivitiesLogs;
            $activityLog->activity_id = $activityID;
            $activityLog->user_id = Auth::user()->user_id;
            $activityLog->browser = $this->browser();
            $activityLog->activity = "Added new activity";
            $activityLog->device = $this->device();
            $activityLog->ip_env_address = $request->ip();
            $activityLog->ip_server_address = $request->server('SERVER_ADDR');
            $activityLog->OS = $this->operating_system();
            $activityLog->save();

            DB::commit();

            return redirect()->back()->with('success', 'New activity successfully added.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error adding new activity.');
        }
    }

    public function show($id) {
        $activity = Activity::where('activity_id', '=', $id)->first();
        echo json_encode($activity);
    }

    public function edit($id) {
        $role = $this->role();
        $activity = Activity::where('activity_id', '=', $id)->first();
        return view('activities.edit', compact(['role', 'activity']));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'The activity name field is required.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $activityUpdated = array(
            'name' => $request->name
        );

        $activityOld = array(
            'old_name' => $request->oldName
        );

        DB::beginTransaction();
        try {
            // Update activity row
            $activity = Activity::find($id);
            $activity->name = $activityUpdated['name'];
            $activity->save();

            // Check if old value is different from updated value
            // If different, save as activity log
            foreach ($activityUpdated as $key => $value) {
                if ($activityOld['old_'.$key] != $value) {
                    // Insert activities log
                    $personnelActivity = new ActivitiesLogs();
                    $personnelActivity->activity_id = $id;
                    $personnelActivity->user_id = Auth::user()->user_id;
                    $personnelActivity->browser = $this->browser();
                    $personnelActivity->activity = "Updated activity";
                    $personnelActivity->device = $this->device();
                    $personnelActivity->ip_env_address = $request->ip();
                    $personnelActivity->ip_server_address = $request->server('SERVER_ADDR');
                    $personnelActivity->new_value = $value;
                    $personnelActivity->old_value = $activityOld['old_'.$key];
                    $personnelActivity->OS = $this->operating_system();
                    $personnelActivity->save();                
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Activity successfully updated.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error updating activity.');
        }
    }

    // Datatable
    public function datatable(Request $request) {
        $activities = Activity::get();

        $data = collect($activities);

        return Datatables::of($data)
            ->addColumn('actions', function($data) {
                if (Entrust::can('edit_seed_production_activity')) {
                    $actions = "<a href='".route('activities.edit', $data->activity_id)."' class='mb-xs mt-xs mr-xs btn btn-warning'><i class='fa fa-edit'></i> Edit</a>&nbsp;";

                    return $actions;
                }
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    // StationID of logged in user
    public function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }
}
