<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plot;
use App\ProductionPlan;
use App\ProductionPlot;
use App\ProductionPlotCode;
use App\SeedTraceGeotag\CropEstablishment;
use App\Station;

class DataSubmissionController extends Controller {
    
    public function index() {
        $role = $this->role();

        // Total plot area per station
        $plots = Plot::select('area', 'philrice_station_id')
                    ->where('is_active', '=', 1)
                    ->get();

        $data = array();
        foreach ($plots as $plot) {
            if (array_key_exists($plot->philrice_station_id, $data)) {
                $data[$plot->philrice_station_id]['totalArea'] = $data[$plot->philrice_station_id]['totalArea'] + $plot->area;
            } else {
                $data[$plot->philrice_station_id]['totalArea'] = $plot->area;
            }
        }

        // Current year and season
        $currDate = date('Y-m-d');
        $currYear = date('Y');
        $lastYear = $currYear - 1;
        $sem1_start = $lastYear . '-09-16';
        $sem1_end = $currYear . '-03-15';
        $sem2_start = $currYear . '-03-16';
        $sem2_end = $currYear . '-09-15';

        if ($currDate >= $sem1_start && $currDate <= $sem1_end) {
            $year = $currYear;
            $sem = 1;
        } else if ($currDate >= $sem2_start && $currDate <= $sem2_end) {
            $year = $currYear;
            $sem = 2;
        } else {
            // $year = $currYear + 1;
            // $sem = 1;
            $year = 2021;
            $sem = 2;
        }

        // Production plans for current year and season
        $productionPlans = ProductionPlan::select('production_plan_id', 'philrice_station_id')
                                        ->where([
                                            ['year', '=', $year],
                                            ['sem', '=', $sem],
                                            ['is_finalized', '=', 1]
                                        ])
                                        ->get();

        foreach ($productionPlans as $productionPlan) {
            // Plots used in each production plan
            $plotsUsed = ProductionPlot::select('plot_id')
                                    ->where('production_plan_id', '=', $productionPlan->production_plan_id)
                                    ->get();

            $totalAreaPlanned = 0;

            foreach ($plotsUsed as $plotUsed) {
                // Area of each plot used
                $plotArea = Plot::select('area')
                                ->where('plot_id', '=', $plotUsed->plot_id)
                                ->first();

                $totalAreaPlanned = $totalAreaPlanned + $plotArea->area;
            }

            if (array_key_exists('totalAreaPlanned', $data[$productionPlan->philrice_station_id])) {
                $data[$productionPlan->philrice_station_id]['totalAreaPlanned'] = $data[$productionPlan->philrice_station_id]['totalAreaPlanned'] + $totalAreaPlanned;
            } else {
                $data[$productionPlan->philrice_station_id]['totalAreaPlanned'] = $totalAreaPlanned;
            }

            // Production plot code
            $productionPlotCode = ProductionPlotCode::select('production_plot_code')
                                                    ->where('production_plan_id', '=', $productionPlan->production_plan_id)
                                                    ->first();

            // Transplanting data from crop establishment table
            $transplanting = CropEstablishment::select('crop_establishment_id')
                                        ->where([
                                            ['production_plot_code', '=', $productionPlotCode->production_plot_code],
                                            ['activity', '=', 'Transplanting']
                                        ])
                                        ->first();

            if ($transplanting) {
                if (array_key_exists('totalAreaTransplanted', $data[$productionPlan->philrice_station_id])) {
                    $data[$productionPlan->philrice_station_id]['totalAreaTransplanted'] = $data[$productionPlan->philrice_station_id]['totalAreaTransplanted'] + $totalAreaPlanned;
                } else {
                    $data[$productionPlan->philrice_station_id]['totalAreaTransplanted'] = $totalAreaPlanned;
                }
            }
        }

        foreach ($data as $key => $value) {
            $philrice_station_id = $key;

            // Name of philrice station
            $station = Station::select('name', 'station_code')
                            ->where('philrice_station_id', '=', $philrice_station_id)
                            ->first();

            $data[$key]['station'] = $station->name;
            $data[$key]['stationCode'] = $station->station_code;
        }

        $data2 = array(
            'year' => $year,
            'sem' => $sem,
            'data' => $data
        );

        // dd($data2);

        return view('data_submission.index', compact(['data2', 'role']));
    }

}
