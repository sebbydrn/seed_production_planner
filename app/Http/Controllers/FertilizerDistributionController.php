<?php

namespace App\Http\Controllers;

use App\Farmer;
use App\FertilizerInventory;
use Illuminate\Http\Request;
use App\FertilizerDistributionList;
use Yajra\Datatables\Datatables;

class FertilizerDistributionController extends Controller
{
    public function index()
    {
        $role = $this->role();

        return view('fertilizer_distribution.index', compact(['role']));
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
        $fertilizer_distribution->fertilizer = $request->fertilizer;
        $fertilizer_distribution->quantity = $request->quantity;
        $fertilizer_distribution->save();

        return redirect()->route('fertilizer_distribution.index')->with('success', 'Fertilizer distribution successfully added!');
    }

    public function datatable(Request $request)
    {
        $fertilizer_distribution_list = FertilizerDistributionList::select('fertilizer_distribution_list.fertilizer_distribution_list_id', 'fertilizer_distribution_list.farmer_id', 'fertilizer_distribution_list.semester', 'fertilizer_distribution_list.year', 'fertilizer_distribution_list.fertilizer', 'fertilizer_distribution_list.quantity', 'fertilizer_distribution_list.area', 'farmers.first_name', 'farmers.last_name', 'farmers.rsbsa_no')
            ->join('farmers', 'farmers.farmer_id', '=', 'fertilizer_distribution_list.farmer_id')
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
                return $data->semester;
            })
            ->addColumn('fertilizer', function($data) {
                return $data->fertilizer;
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