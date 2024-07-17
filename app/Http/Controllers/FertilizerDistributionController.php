<?php

namespace App\Http\Controllers;

use App\Farmer;
use App\FertilizerInventory;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\FertilizerDistributionList;

class FertilizerDistributionController extends Controller
{
    public function index()
    {
        $role = $this->role();

        // Get all barangays
        $barangays = DB::table('farmers')->select('barangay')->distinct()->get();

        // Get all fertilizer types from the distribution table
        $fertilizers = FertilizerDistributionList::select('fertilizer')->distinct()->get();

        return view('fertilizer_distribution.index', compact(['role', 'barangays', 'fertilizers']));
    }

    public function create()
    {
        $role = $this->role();

        // Get farmers
        $farmers = Farmer::select('farmer_id', 'first_name', 'last_name', 'rsbsa_no')->where('is_active', 1)->orderBy('first_name', 'asc')->get();

        // Get fertilizers from fertilizer_inventory table
        $fertilizers = FertilizerInventory::select('fertilizer', 'remaining_bags')
                    ->where('remaining_bags', '>', 0)
                    ->get();

        return view('fertilizer_distribution.create' , compact(['role', 'farmers', 'fertilizers']));
    }

    public function store(Request $request)
    {
        $fertilizer_distribution = new FertilizerDistributionList;
        $fertilizer_distribution->farmer_id = $request->farmer;
        $fertilizer_distribution->semester = $request->sem;
        $fertilizer_distribution->year = $request->year;
        $fertilizer_distribution->fertilizer = "";
        $fertilizer_distribution->quantity = $request->quantity;
        $fertilizer_distribution->save();

        // Update remaining bags in fertilizer_inventory table
        // $fertilizer_inventory = FertilizerInventory::where('fertilizer', $request->fertilizer)->first();
        // $fertilizer_inventory->remaining_bags = $fertilizer_inventory->remaining_bags - $request->quantity;
        // $fertilizer_inventory->save();

        return redirect()->route('fertilizer_distribution.index')->with('success', 'Fertilizer distribution successfully added!');
    }

    public function datatable(Request $request)
    {
        $fertilizer_distribution_list = FertilizerDistributionList::select('fertilizer_distribution_list.fertilizer_distribution_list_id', 'fertilizer_distribution_list.farmer_id', 'fertilizer_distribution_list.semester', 'fertilizer_distribution_list.year', 'fertilizer_distribution_list.fertilizer', 'fertilizer_distribution_list.quantity', 'fertilizer_distribution_list.area', 'farmers.first_name', 'farmers.last_name', 'farmers.rsbsa_no');

        if (isset($request->barangay) && $request->barangay != 'All') {
            $fertilizer_distribution_list = $fertilizer_distribution_list->where('farmers.barangay', $request->barangay);
        }

        if (isset($request->year) && $request->year != '') {
            $fertilizer_distribution_list = $fertilizer_distribution_list->where('fertilizer_distribution_list.year', $request->year);
        }

        if (isset($request->sem) && $request->sem != 'All') {
            $fertilizer_distribution_list = $fertilizer_distribution_list->where('fertilizer_distribution_list.semester', $request->sem);
        }

        // if (isset($request->fertilizer) && $request->fertilizer != 'All') {
        //     $fertilizer_distribution_list = $fertilizer_distribution_list->where('fertilizer_distribution_list.fertilizer', $request->fertilizer);
        // }

        $fertilizer_distribution_list = $fertilizer_distribution_list->join('farmers', 'farmers.farmer_id', '=', 'fertilizer_distribution_list.farmer_id')
            ->orderBy('fertilizer_distribution_list.date_distributed', 'desc')
            ->get();

        return Datatables::of($fertilizer_distribution_list)
            ->addColumn('name', function($data) {
                return $data->first_name . ' ' . $data->last_name;
            })
            ->addColumn('rsbsa_no', function($data) {
                return $data->rsbsa_no;
            })
            ->addColumn('sem', function($data) {
                return $data->semester == 1 ? "Dry Season" : "Wet Season";
            })
            // ->addColumn('fertilizer', function($data) {
            //     return $data->fertilizer;
            // })
            ->addColumn('quantity', function($data) {
                return $data->quantity;
            })
            ->addColumn('actions', function($data) {
                return '<button type="button" name="delete" id="'.$data->fertilizer_distribution_list_id.'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash-o"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function delete(Request $request)
    {
        $fertilizer_distribution = FertilizerDistributionList::find($request->fertilizer_distribution_list_id);
        $fertilizer_distribution->delete();

        return response()->json(['status' => 'success']);
    }
}