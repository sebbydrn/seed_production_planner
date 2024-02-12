<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeedProductionDashboard\AreaPlannedData;
use App\SeedProductionDashboard\AreaPlantedData;
use Auth, Entrust;

class Dashboard2Controller extends Controller
{
    public function __construct() {
        $this->middleware('permission:view_dashboard')->only(['index']);
    }

    public function index() {
        $role = $this->role();

        $area_planned_data = AreaPlannedData::orderBy('timestamp', 'desc')->first();

        $area_planted_data = AreaPlantedData::orderBy('timestamp', 'desc')->first();

        return view('dashboard2.index')->with(compact('role', 'area_planned_data', 'area_planted_data'));
    }
}
