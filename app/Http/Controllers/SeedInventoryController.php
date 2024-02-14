<?php

namespace App\Http\Controllers;

use App\SeedInventory;
use App\Seed;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class SeedInventoryController extends Controller
{
    /**
     * Display a listing of the seed inventory.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = $this->role();

        $seedInventory = SeedInventory::all();
        return view('seed_inventory.index', compact('role', 'seedInventory'));
    }

    /**
     * Show the form for creating a new seed inventory.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = $this->role();

        // Get variety
        $variety = Seed::select('variety', 'maturity')->where('variety_name', 'NOT LIKE', '%DWSR%')->get();

        return view('seed_inventory.create', compact('role', 'variety'));
    }

    /**
     * Store a newly created seed inventory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seed_inventory = new SeedInventory;
        $seed_inventory->variety = $request->variety;
        $seed_inventory->seed_type = $request->seed_type;
        
        if ($request->seed_type == 'Inbred') {
            $seed_inventory->bags = $request->quantity;
            $seed_inventory->remaining_bags = $request->quantity;
        }

        if ($request->seed_type == 'Hybrid') {
            $seed_inventory->kilograms = $request->quantity;
            $seed_inventory->kilograms_remaining = $request->quantity;
        }

        $seed_inventory->save();

        // Redirect to the index page with a success message
        return redirect()->route('seed_inventory.index')->with('success', 'Seed inventory created successfully.');
    }

    public function datatable(Request $request) {
        $seed_inventory = SeedInventory::orderBy('seed_inventory.date_created', 'desc')
            ->get();

        return Datatables::of($seed_inventory)
            ->addColumn('quantity', function($data) {
                if ($data->seed_type == 'Inbred') {
                    return $data->remaining_bags . ' bags';
                } else {
                    return $data->kilograms_remaining . ' kg';
                }
            })
            ->addColumn('date_created', function($data) {
                return date('Y/m/d h:i A', strtotime($data->date_created));
            })
            ->addColumn('date_updated', function($data) {
                return date('Y/m/d h:i A', strtotime($data->date_updated));
            })
            ->make(true);
    }
}
