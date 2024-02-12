<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personnel;
use App\PersonnelActivities;
use App\User;
use App\AffiliationUser;
use App\Station;
use Auth, DB, Session, Validator, Entrust;
use Yajra\Datatables\Datatables;

class PersonnelController extends Controller {

    public function __construct() {
        $this->middleware('permission:view_personnel')->only(['index', 'show', 'datatable']);
        $this->middleware('permission:add_personnel')->only(['create', 'store']);
        $this->middleware('permission:edit_personnel')->only(['edit', 'update']);
        $this->middleware('permission:delete_personnel')->only(['destroy']);
        $this->middleware('permission:update_personnel_status')->only(['update_personnel_status', 'multiple_update_personnel_status']);
    }

    public function index() {
        $role = $this->role();

        $philriceStations = Station::get();

        return view('personnel.index', compact(['role', 'philriceStations']));
    }

    public function create() {
        $role = $this->role();

        return view('personnel.create', compact(['role']));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            // 'empIDNo' => 'required|unique:personnel,emp_idno',
            'empIDNo' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'role' => 'required'
        ], [
            'empIDNo.required' => 'The ID No. field is required.',
            // 'empIDNo.unique' => 'The ID No. has already been taken.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $philriceStationID = $this->userStationID();

        DB::beginTransaction();
        try {
            // Insert personnel to database
            $personnel = new Personnel();
            $personnel->emp_idno = $request->empIDNo;
            $personnel->first_name = $request->firstName;
            $personnel->last_name = $request->lastName;
            $personnel->role = $request->role;
            $personnel->philrice_station_id = $philriceStationID;
            $personnel->save();
            $personnelID = $personnel->personnel_id;

            // Insert personnel activity log
            $personnelActivity = new PersonnelActivities;
            $personnelActivity->personnel_id = $personnelID;
            $personnelActivity->user_id = Auth::user()->user_id;
            $personnelActivity->browser = $this->browser();
            $personnelActivity->activity = "Added new personnel";
            $personnelActivity->device = $this->device();
            $personnelActivity->ip_env_address = $request->ip();
            $personnelActivity->ip_server_address = $request->server('SERVER_ADDR');
            $personnelActivity->OS = $this->operating_system();
            $personnelActivity->save();

            DB::commit();

            return redirect()->back()->with('success', 'New personnel successfully added.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error adding new personnel.');
        }
    }

    public function show($id) {
        $personnel = Personnel::where('personnel_id', '=', $id)->first();
        echo json_encode($personnel);
    }

    public function edit($id) {
        $role = $this->role();
        $personnel = Personnel::where('personnel_id', '=', $id)->first();
        return view('personnel.edit', compact(['personnel', 'role']));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'empIDNo' => 'required|unique:personnel,emp_idno,'.$id.',personnel_id',
            'firstName' => 'required',
            'lastName' => 'required',
            'role' => 'required'
        ], [
            'empIDNo.required' => 'The ID No. field is required.',
            'empIDNo.unique' => 'The ID No. has already been taken.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $personnelUpdated = array(
            'emp_idno' => $request->empIDNo,
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'role' => $request->role
        );

        $personnelOld = array(
            'old_emp_idno' => $request->oldEmpIDNo,
            'old_first_name' => $request->oldFirstName,
            'old_last_name' => $request->oldLastName,
            'old_role' => $request->oldRole
        );

        DB::beginTransaction();
        try {
            // Update personnel row
            $personnel = Personnel::find($id);
            $personnel->emp_idno = $personnelUpdated['emp_idno'];
            $personnel->first_name = $personnelUpdated['first_name'];
            $personnel->last_name = $personnelUpdated['last_name'];
            $personnel->role = $personnelUpdated['role'];
            $personnel->save();

            // Check if old value is different from updated value
            // If different, save as activity log
            foreach ($personnelUpdated as $key => $value) {
                if ($personnelOld['old_'.$key] != $value) {
                    // Insert personnel activity log
                    $personnelActivity = new PersonnelActivities();
                    $personnelActivity->personnel_id = $id;
                    $personnelActivity->user_id = Auth::user()->user_id;
                    $personnelActivity->browser = $this->browser();
                    $personnelActivity->activity = "Updated personnel";
                    $personnelActivity->device = $this->device();
                    $personnelActivity->ip_env_address = $request->ip();
                    $personnelActivity->ip_server_address = $request->server('SERVER_ADDR');
                    $personnelActivity->new_value = $value;
                    $personnelActivity->old_value = $personnelOld['old_'.$key];
                    $personnelActivity->OS = $this->operating_system();
                    $personnelActivity->save();                
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Personnel successfully updated.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error updating personnel.');
        }
    }

    public function destroy(Request $request, $id) {
        DB::beginTransaction();
        try {
            // Delete personnel row
            $personnel = Personnel::find($id);
            $personnel->is_deleted = 1;
            $personnel->save();

            // Insert personnel activity log
            $personnelActivity = new PersonnelActivities();
            $personnelActivity->personnel_id = $id;
            $personnelActivity->user_id = Auth::user()->user_id;
            $personnelActivity->browser = $this->browser();
            $personnelActivity->activity = "Deleted personnel";
            $personnelActivity->device = $this->device();
            $personnelActivity->ip_env_address = $request->ip();
            $personnelActivity->ip_server_address = $request->server('SERVER_ADDR');
            $personnelActivity->OS = $this->operating_system();
            $personnelActivity->save();

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
        $personnel = Personnel::select('*');

        if (isset($request->is_active)) {
            $is_active = $request->is_active;
            $personnel = $personnel->where('is_active', '=', $is_active)
                                    ->where('is_deleted', '=', 0);
        } else {
            $personnel = $personnel->where('is_deleted', '=', 0);
        }

        if (isset($request->philriceStation)) {
            $philriceStationID = $request->philriceStation;

            if ($philriceStationID != 0) {
                if ($philriceStationID == 1) {
                    $personnel = $personnel->get();
                } else {
                    $personnel = $personnel->where('philrice_station_id', '=', $philriceStationID)->get();
                }
            }
            
        } else {
            if (Entrust::can('view_all_personnel')) {
                $personnel = $personnel->get();
            } else {
                // Get station code of user's station
                $philriceStationID = $this->userStationID();

                $personnel = $personnel->where('philrice_station_id', '=', $philriceStationID)->get();
            }
        }

        $philriceStationID = $this->userStationID();

        $data = collect($personnel);

        return Datatables::of($data)
            ->addColumn('status', function($data) {
                if ($data->is_active == 1) {
                    $status = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-success'><i class='fa fa-check-circle'></i> Active</button>";
                } elseif ($data->is_active == 0) {
                    $status = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-danger'><i class='fa fa-ban'></i> Deactivated</button>";
                }

                return $status;
            })
            ->addColumn('station', function($data) {
                $philriceStationID = $data->philrice_station_id;

                $station = Station::select('name')->where('philrice_station_id', '=', $philriceStationID)->first();

                return $station->name;
            })
            ->addColumn('actions', function($data) {
                $actions = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-info' onclick='viewPersonnelInfo(".$data->personnel_id.")'><i class='fa fa-eye'></i> View</button>&nbsp;";

                if (Entrust::can('edit_personnel_status')) {
                    $actions .= "<a href='".route('personnel.edit', $data->personnel_id)."' class='mb-xs mt-xs mr-xs btn btn-warning'><i class='fa fa-edit'></i> Edit</a>&nbsp;";
                }

                if (Entrust::can('update_personnel_status')) {
                    if ($data->is_active == 1) {
                        $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-danger' onclick='updatePersonnelStatus(".$data->personnel_id.", 0)'><i class='fa fa-ban'></i> Deactivate</button>&nbsp;";
                    } elseif ($data->is_active == 0) {
                        $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-success' onclick='updatePersonnelStatus(".$data->personnel_id.", 1)'><i class='fa fa-check-circle'></i> Activate</button>&nbsp;";
                    }
                }

                if (Entrust::can('delete_personnel')) {
                    $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-danger' onclick='deletePersonnel(".$data->personnel_id.")'><i class='fa fa-trash-o'></i> Delete</button>";
                }

                return $actions;
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function update_personnel_status(Request $request) {
        $personnel_id = $request->personnel_id;
        $is_active = $request->is_active;

        DB::beginTransaction();
        try {
            // Update personnel row
            $personnel = Personnel::find($personnel_id);
            $personnel->is_active = $is_active;
            $personnel->save();

            // Insert personnel activity log
            $personnelActivity = new PersonnelActivities();
            $personnelActivity->personnel_id = $personnel_id;
            $personnelActivity->user_id = Auth::user()->user_id;
            $personnelActivity->browser = $this->browser();
            if ($is_active == 1) {
                $personnelActivity->activity = "Activated personnel";
            } elseif ($is_active == 0) {
                $personnelActivity->activity = "Deactivated personnel";
            }
            $personnelActivity->device = $this->device();
            $personnelActivity->ip_env_address = $request->ip();
            $personnelActivity->ip_server_address = $request->server('SERVER_ADDR');
            $personnelActivity->OS = $this->operating_system();
            $personnelActivity->save();

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

    public function multiple_update_personnel_status(Request $request) {
        $personnelIDs = $request->personnelIDs;
        $is_active = $request->is_active;

        DB::beginTransaction();
        try {
            foreach ($personnelIDs as $personnel_id) {
                // Update personnel row
                $personnel = Personnel::find($personnel_id);
                $personnel->is_active = $is_active;
                $personnel->save();

                // Insert personnel activity log
                $personnelActivity = new PersonnelActivities();
                $personnelActivity->personnel_id = $personnel_id;
                $personnelActivity->user_id = Auth::user()->user_id;
                $personnelActivity->browser = $this->browser();
                if ($is_active == 1) {
                    $personnelActivity->activity = "Activated personnel";
                } elseif ($is_active == 0) {
                    $personnelActivity->activity = "Deactivated personnel";
                }
                $personnelActivity->device = $this->device();
                $personnelActivity->ip_env_address = $request->ip();
                $personnelActivity->ip_server_address = $request->server('SERVER_ADDR');
                $personnelActivity->OS = $this->operating_system();
                $personnelActivity->save();
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

    // StationID of logged in user
    public function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }
}
