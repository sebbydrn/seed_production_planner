<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SeedDistributionList;
use App\Farmer;
use App\Seed;
use App\Plot;
use App\SeedInventory;
use Yajra\Datatables\Datatables;

class SeedDistributionController extends Controller
{
    public function index() {
        $role = $this->role();

        return view('seed_distribution.index', compact(['role']));
    }

    public function create() {
        $role = $this->role();

        // Get farmers
        $farmers = Farmer::select('farmer_id', 'first_name', 'last_name', 'rsbsa_no')->where('is_active', 1)->orderBy('first_name', 'asc')->get();

        // Get varieties from seed_inventory table
        $variety = SeedInventory::select('variety', 'seed_type')
                    ->where('remaining_bags', '>', 0)
                    ->orWhere('kilograms_remaining', '>', 0)
                    ->get();

        return view('seed_distribution.create', compact(['role', 'farmers', 'variety']));
    }

    public function store(Request $request) {
        // save to seed_distribution_lists table
        $seed_distribution_list = new SeedDistributionList;
        $seed_distribution_list->farmer_id = $request->farmer;
        $seed_distribution_list->semester = $request->sem;
        $seed_distribution_list->year = $request->year;
        $seed_distribution_list->variety = $request->variety;
        $seed_distribution_list->quantity = $request->quantity;
        $seed_distribution_list->area = $request->area;
        $seed_distribution_list->seed_type = $request->seed_type;
        $seed_distribution_list->save();

        // refresh page
        return redirect()->back()->with('success', 'Seed distribution successfully added!');
    }

    public function datatable(Request $request) {
        $seed_distribution_list = SeedDistributionList::select('seed_distribution_list.seed_distribution_list_id', 'seed_distribution_list.farmer_id', 'seed_distribution_list.semester', 'seed_distribution_list.year', 'seed_distribution_list.variety', 'seed_distribution_list.quantity', 'seed_distribution_list.area', 'farmers.first_name', 'farmers.last_name', 'farmers.rsbsa_no', 'seed_distribution_list.seed_type')
            ->join('farmers', 'farmers.farmer_id', '=', 'seed_distribution_list.farmer_id')
            ->orderBy('seed_distribution_list.date_distributed', 'desc')
            ->get();

        return Datatables::of($seed_distribution_list)
            ->addColumn('name', function($data) {
                return $data->first_name . ' ' . $data->last_name;
            })
            ->addColumn('rsbsa_no', function($data) {
                return $data->rsbsa_no;
            })
            ->addColumn('sem', function($data) {
                return $data->semester;
            })
            ->addColumn('variety', function($data) {
                return $data->variety;
            })
            ->addColumn('seed_type', function($data) {
                return $data->seed_type;
            })
            ->addColumn('quantity', function($data) {
                if ($data->seed_type == 'Inbred') {
                    return $data->quantity . ' bags';
                } else {
                    return $data->quantity . ' kg';
                }
            })
            ->addColumn('actions', function($data) {
                return '<button type="button" name="delete" id="'.$data->seed_distribution_list_id.'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash-o"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getFarmerArea(Request $request)
    {
        // Get the sum of area column in the plots table using farmer_id and is_active = 1
        $area = Plot::selectRaw('CAST(SUM(CAST(area AS DECIMAL)) AS INTEGER) as area')
             ->where('farmer_id', $request->farmer_id)
             ->where('is_active', 1)
             ->first();

        // Using the farmer_id, semester and year, get the sum of area column in the seed_distribution_lists table
        $area_distributed = SeedDistributionList::selectRaw('CAST(SUM(CAST(area AS DECIMAL)) AS INTEGER) as area')
                                         ->where('farmer_id', $request->farmer_id)
                                         ->where('semester', $request->sem)
                                         ->where('year', $request->year)
                                         ->first();

        // Get the difference of area and area_distributed
        $area_remaining = $area->area - $area_distributed->area;

        return response()->json(['area_remaining' => $area_remaining]);
    }

    public function delete(Request $request) {
        $seed_distribution_list = SeedDistributionList::find($request->seed_distribution_list_id);
        $seed_distribution_list->delete();

        return response()->json(['status' => 'success']);
    }
}