<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FertilizerInventory;
use Yajra\Datatables\Datatables;

class FertilizerInventoryController extends Controller
{
    public function index() {
        $role = $this->role();

        return view('fertilizer_inventory.index', compact(['role']));
    }

    public function datatable(Request $request) {
        $fertilizer_inventory = FertilizerInventory::select('fertilizer_inventory_id', 'fertilizer', 'remaining_bags', 'date_created', 'date_updated')
            ->where('remaining_bags', '>', 0)
            ->get();

        return Datatables::of($fertilizer_inventory)
            ->addColumn('bags', function($data) {
                return $data->remaining_bags;
            })
            ->addColumn('date_created', function($data) {
                return date('F d, Y h:i A', strtotime($data->date_created));
            })
            ->addColumn('date_updated', function($data) {
                return date('F d, Y h:i A', strtotime($data->date_updated));
            })
            ->make(true);
    }

    public function create() {
        $role = $this->role();

        return view('fertilizer_inventory.create', compact(['role']));
    }

    public function store(Request $request) {
        $fertilizer_inventory = new FertilizerInventory;
        $fertilizer_inventory->fertilizer = $request->fertilizer;
        $fertilizer_inventory->bags = $request->quantity;
        $fertilizer_inventory->remaining_bags = $request->quantity;
        $fertilizer_inventory->save();

        return redirect()->route('fertilizer_inventory.index')->with('success', 'Fertilizer inventory successfully added!');
    }
}