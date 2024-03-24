<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Farmer;
use App\Plot;
use Auth, DB, Session, Validator, Entrust;
use Yajra\Datatables\Datatables;

class FarmerController extends Controller
{
    public function index()
    {
        $role = $this->role();

        return view('farmers.index', compact(['role']));
    }

    public function create()
    {
        $role = $this->role();

        return view('farmers.create', compact(['role']));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'birthdate'     => 'required',
            'sex'           => 'required',
            'barangay'      => 'required',
            'rsbsa_no'      => 'required|unique:farmers,rsbsa_no'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Insert farmer to database
            $farmer = new farmer();
            $farmer->first_name = $request->first_name;
            $farmer->last_name = $request->last_name;
            $farmer->middle_name = $request->middle_name;
            $farmer->suffix = $request->suffix;
            $farmer->birthdate = $request->birthdate;
            $farmer->sex = $request->sex;
            $farmer->barangay = $request->barangay;
            $farmer->rsbsa_no = $request->rsbsa_no;
            $farmer->save();

            DB::commit();

            return redirect()->back()->with('success', 'New farmer successfully added.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error adding new farmer.');
        }
    }

    public function edit($id)
    {
        $role = $this->role();

        $farmer = Farmer::find($id);

        return view('farmers.edit', compact(['role', 'farmer']));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'birthdate'     => 'required',
            'sex'           => 'required',
            'barangay'      => 'required',
            'rsbsa_no'      => 'required|unique:farmers,rsbsa_no,'.$id.',farmer_id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Insert farmer to database
            $farmer = Farmer::find($id);
            $farmer->first_name = $request->first_name;
            $farmer->last_name = $request->last_name;
            $farmer->middle_name = $request->middle_name;
            $farmer->suffix = $request->suffix;
            $farmer->birthdate = $request->birthdate;
            $farmer->sex = $request->sex;
            $farmer->barangay = $request->barangay;
            $farmer->rsbsa_no = $request->rsbsa_no;
            $farmer->save();

            DB::commit();

            return redirect()->back()->with('success', 'Farmer successfully updated.');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo $e->getMessage();

            return redirect()->back()->with('error', 'Error updating farmer.');
        }
    }

    public function show($id)
    {
        $role = $this->role();

        $farmer = Farmer::find($id);

        return view('farmers.show', compact(['role', 'farmer']));
    }

    // Datatable
    public function datatable(Request $request) {
        $farmers = Farmer::select('*');

        if (isset($request->is_active)) {
            $is_active = $request->is_active;
            $farmers = $farmers->where('is_active', '=', $is_active);
        } else {
            $farmers = $farmers->where('is_active', '=', 1);
        }

        $farmers = $farmers->get();

        $data = collect($farmers);

        return Datatables::of($data)
            ->addColumn('rsbsa_no', function($data) {
                $rsbsa_no = $data->rsbsa_no;
                return $rsbsa_no;
            })
            ->addColumn('name', function($data) {
                $name = $data->first_name." ".$data->last_name;
                return $name;
            })
            ->addColumn('sex', function($data){
                // 1 for female and 2 for male
                if ($data->sex == 1) return 'Female';
                else return 'Male';
            })
            
            ->addColumn('area', function($data) {
                // get area of all plots of the farmer
                $area = 0;
                $plots = Plot::select('area')->where('farmer_id', $data->farmer_id)->where('is_active', 1)->get();
                foreach ($plots as $plot) {
                    $area += $plot->area;
                }
                return $area;
            })
            ->addColumn('status', function($data) {
                if ($data->is_active == 1) {
                    $status = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-success'><i class='fa fa-check-circle'></i> Active</button>";
                } elseif ($data->is_active == 0) {
                    $status = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-danger'><i class='fa fa-ban'></i> Deactivated</button>";
                }

                return $status;
            })
            ->addColumn('actions', function($data) {
                $actions = "";
                // $actions = "<button type='button' class='mb-xs mt-xs mr-xs btn btn-info' onclick='viewFarmerInfo(".$data->farmer_id.")'><i class='fa fa-eye'></i> View</button>&nbsp;";

                $actions .= "<a href='".route('farmers.edit', $data->farmer_id)."' class='mb-xs mt-xs mr-xs btn btn-warning'><i class='fa fa-edit'></i> Edit</a>&nbsp;";
                
                // if ($data->is_active == 1) {
                //     $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-danger' onclick='updateFarmerStatus(".$data->farmer_id.", 0)'><i class='fa fa-ban'></i> Deactivate</button>&nbsp;";
                // } elseif ($data->is_active == 0) {
                //     $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-success' onclick='updateFarmerStatus(".$data->farmer_id.", 1)'><i class='fa fa-check-circle'></i> Activate</button>&nbsp;";
                // }

                // $actions .= "<button type='button' class='mb-xs mt-xs mr-xs btn btn-danger' onclick='deleteFarmer(".$data->farmer_id.")'><i class='fa fa-trash-o'></i> Delete</button>";

                return $actions;
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }
}
