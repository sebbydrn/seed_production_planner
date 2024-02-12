<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ProductionPlan;
use App\ProductionPlanActivities;
use App\ProductionPlotCode;
use App\Station;
use DB, Auth, Entrust;
use Yajra\Datatables\Datatables;

class DataMonitoringController extends Controller {
    
    public function index() {
        $role = $this->role();

        $philriceStations = Station::get();

        $data = array(
            'totalDailyData' => 0,
            'totalData' => 0
        );

        // total count of production plan
        $totalProductionPlan = ProductionPlan::select('production_plan_id')->get()->count();
        $data['totalData'] = $totalProductionPlan;

        // total count of daily production plan
        $dateToday = date('Y-m-d');
        $totalDailyProductionPlan = ProductionPlanActivities::select('production_plan_id')
                                                            ->where('activity', '=', "Added new production plan")
                                                            ->whereDate('timestamp', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] = $totalDailyProductionPlan;

        // data submitted
        $dailyData = array();
        $newProductionPlan = ProductionPlanActivities::select('production_plan_id', 'timestamp')
                                                            ->where('activity', '=', "Added new production plan")
                                                            ->whereDate('timestamp', '=', $dateToday)
                                                            ->get();


        foreach ($newProductionPlan as $item) {
            $productionPlan = ProductionPlan::select('year', 'sem', 'variety', 'seed_class', 'seed_quantity', 'philrice_station_id')
                                            ->where('production_plan_id', '=', $item->production_plan_id)
                                            ->first();

            if ($productionPlan) {
                $station = Station::select('name')->where('philrice_station_id', '=', $productionPlan->philrice_station_id)->first();

                $dailyData[] = array(
                    'timestamp' => date('Y-m-d H:i:s', strtotime($item->timestamp)),
                    'year' => $productionPlan->year,
                    'sem' => $productionPlan->sem,
                    'variety' => $productionPlan->variety,
                    'seed_class' => $productionPlan->seed_class,
                    'station' => $station->name
                );
            }                                
            
        }

        usort($dailyData, function($data1, $data2) {
            if ($data1['timestamp'] == $data2['timestamp']) {
                return 0;
            }

            return ($data1['timestamp'] > $data2['timestamp']) ? -1 : 1;
        });


        return view('data_monitoring.index', compact(['role', 'data', 'dailyData', 'philriceStations']));
    }

    public function show_data() {
        $data = array(
            'totalDailyData' => 0,
            'totalData' => 0,
            'dailyData' => array()
        );

        // total count of production plan
        $totalProductionPlan = ProductionPlan::select('production_plan_id')->get()->count();
        $data['totalData'] = $totalProductionPlan;

        // total count of daily production plan
        $dateToday = date('Y-m-d');
        $totalDailyProductionPlan = ProductionPlanActivities::select('production_plan_id')
                                                            ->where('activity', '=', "Added new production plan")
                                                            ->whereDate('timestamp', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] = $totalDailyProductionPlan;

        // data submitted
        $dailyData = array();
        $newProductionPlan = ProductionPlanActivities::select('production_plan_id', 'timestamp')
                                                            ->where('activity', '=', "Added new production plan")
                                                            ->whereDate('timestamp', '=', $dateToday)
                                                            ->get();


        foreach ($newProductionPlan as $item) {
            $productionPlan = ProductionPlan::select('year', 'sem', 'variety', 'seed_class', 'seed_quantity', 'philrice_station_id')
                                            ->where('production_plan_id', '=', $item->production_plan_id)
                                            ->first();

            if ($productionPlan) {
                $station = Station::select('name')->where('philrice_station_id', '=', $productionPlan->philrice_station_id)->first();

                $data['dailyData'][] = array(
                    'timestamp' => date('Y-m-d H:i:s', strtotime($item->timestamp)),
                    'year' => $productionPlan->year,
                    'sem' => $productionPlan->sem,
                    'variety' => $productionPlan->variety,
                    'seed_class' => $productionPlan->seed_class,
                    'station' => $station->name
                );
            } 
        }

        usort($data['dailyData'], function($data1, $data2) {
            if ($data1['timestamp'] == $data2['timestamp']) {
                return 0;
            }

            return ($data1['timestamp'] > $data2['timestamp']) ? -1 : 1;
        });

        echo json_encode($data);
    }

    public function datatable(Request $request) {
        $productionPlans = ProductionPlan::select('*');

        if (isset($request->philriceStation)) {
            $philriceStationID = $request->philriceStation;

            if ($philriceStationID != 0) {
                if ($philriceStationID == 1) {
                    $productionPlans = $productionPlans->get();
                } else {
                    $productionPlans = $productionPlans->where('philrice_station_id', '=', $philriceStationID)->get();
                }
            }
            
        } else {
            $productionPlans = $productionPlans->get();
        }

        $data = collect($productionPlans);

         return Datatables::of($data)
            ->addColumn('production_plot_code', function($data) {
                $productionPlanID = $data->production_plan_id;

                $productionPlotCode = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();

                return $productionPlotCode->production_plot_code;
            })
            ->addColumn('sem', function($data) {
                $sem = ($data->sem == 1) ? "1st" : "2nd";
                return $sem;
            })
            ->addColumn('station', function($data) {
                $philriceStationID = $data->philrice_station_id;

                $station = Station::select('name')->where('philrice_station_id', '=', $philriceStationID)->first();

                return $station->name;
            })
            ->make(true);
    }

}
