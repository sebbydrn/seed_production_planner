<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ProductionPlan;
use App\ProductionPlanActivities;
use App\ProductionPlotCode;
use App\Station;
use App\SeedTraceGeotag\CropEstablishment;
use App\SeedTraceGeotag\DamageAssessment;
use App\SeedTraceGeotag\DiseaseManagement;
use App\SeedTraceGeotag\Harvesting;
use App\SeedTraceGeotag\LandPreparation;
use App\SeedTraceGeotag\NutrientManagement;
use App\SeedTraceGeotag\PestManagement;
use App\SeedTraceGeotag\Roguing;
use App\SeedTraceGeotag\SeedlingManagement;
use App\SeedTraceGeotag\WaterManagement;
use DB, Auth, Entrust;
use Yajra\Datatables\Datatables;

class DataMonitoringGeotagController extends Controller {
    
    public function index() {
        $role = $this->role();

        $philriceStations = Station::get();

        $data = array(
            'totalDailyData' => 0,
            'totalData' => 0
        );

        // total count of Crop Establishment
        $totalCropEstablishment = CropEstablishment::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalCropEstablishment;

        // total count of Damage Assessment
        $totalDamageAssessment = DamageAssessment::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalDamageAssessment;

        // total count of Disease Management
        $totalDiseaseManagement = DiseaseManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalDiseaseManagement;

        // total count of Harvesting
        $totalHarvesting = Harvesting::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalHarvesting;

        // total count of Land Preparation
        $totalLandPreparation = LandPreparation::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalLandPreparation;

        // total count of Nutrient Management
        $totalNutrientManagement = NutrientManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalNutrientManagement;

        // total count of Pest Management
        $totalPestManagement = PestManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalPestManagement;

        // total count of Roguing
        $totalRoguing = Roguing::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalRoguing;

        // total count of Seedling Management
        $totalSeedlingManagement = SeedlingManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalSeedlingManagement;

        // total count of Water Management
        $totalWaterManagement = WaterManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalWaterManagement;

        // total count of daily production plan
        $dateToday = date('Y-m-d');
        $totalDailyCropEstablishment = CropEstablishment::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyCropEstablishment;

        $totalDailyDamageAssessment = DamageAssessment::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyDamageAssessment;

        $totalDailyDiseaseManagement = DiseaseManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyDiseaseManagement;

        $totalDailyHarvesting = Harvesting::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyHarvesting;

        $totalDailyLandPreparation = LandPreparation::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyLandPreparation;

        $totalDailyNutrientManagement = NutrientManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyNutrientManagement;

        $totalDailyPestManagement = PestManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyPestManagement;

        $totalDailyRoguing = Roguing::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyRoguing;

        $totalDailySeedlingManagement = SeedlingManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailySeedlingManagement;

        $totalDailyWaterManagement = WaterManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyWaterManagement;

        // data submitted
        $dailyData = array();
        $newDailyCropEstablishment = CropEstablishment::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyDamageAssessment = DamageAssessment::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyDiseaseManagement = DiseaseManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyHarvesting = Harvesting::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyLandPreparation = LandPreparation::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyNutrientManagement = NutrientManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyPestManagement = PestManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyRoguing = Roguing::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailySeedlingManagement = SeedlingManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyWaterManagement = WaterManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        foreach($newDailyCropEstablishment as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Crop Establishment'
            );
        }

        foreach($newDailyDamageAssessment as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Damage Assessment'
            );
        }

        foreach($newDailyDiseaseManagement as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Disease Management'
            );
        }

        foreach($newDailyHarvesting as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Harvesting'
            );
        }

        foreach($newDailyLandPreparation as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Land Preparation'
            );
        }

        foreach($newDailyNutrientManagement as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Nutrient Management'
            );
        }

        foreach($newDailyPestManagement as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Pest Management'
            );
        }

        foreach($newDailyRoguing as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Roguing'
            );
        }

        foreach($newDailySeedlingManagement as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Seedling Management'
            );
        }

        foreach($newDailyWaterManagement as $item) {
            $dailyData[] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Water Management'
            );
        }

        usort($dailyData, function($data1, $data2) {
            if ($data1['timestamp'] == $data2['timestamp']) {
                return 0;
            }

            return ($data1['timestamp'] > $data2['timestamp']) ? -1 : 1;
        });


        return view('data_monitoring_geotag.index', compact(['role', 'data', 'dailyData', 'philriceStations']));
    }

    public function show_data() {
        $data = array(
            'totalDailyData' => 0,
            'totalData' => 0,
            'dailyData' => array()
        );

        // total count of Crop Establishment
        $totalCropEstablishment = CropEstablishment::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalCropEstablishment;

        // total count of Damage Assessment
        $totalDamageAssessment = DamageAssessment::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalDamageAssessment;

        // total count of Disease Management
        $totalDiseaseManagement = DiseaseManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalDiseaseManagement;

        // total count of Harvesting
        $totalHarvesting = Harvesting::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalHarvesting;

        // total count of Land Preparation
        $totalLandPreparation = LandPreparation::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalLandPreparation;

        // total count of Nutrient Management
        $totalNutrientManagement = NutrientManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalNutrientManagement;

        // total count of Pest Management
        $totalPestManagement = PestManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalPestManagement;

        // total count of Roguing
        $totalRoguing = Roguing::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalRoguing;

        // total count of Seedling Management
        $totalSeedlingManagement = SeedlingManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalSeedlingManagement;

        // total count of Water Management
        $totalWaterManagement = WaterManagement::select('production_plot_code')->get()->count();
        $data['totalData'] += $totalWaterManagement;

        // total count of daily production plan
        $dateToday = date('Y-m-d');
        $totalDailyCropEstablishment = CropEstablishment::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyCropEstablishment;

        $totalDailyDamageAssessment = DamageAssessment::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyDamageAssessment;

        $totalDailyDiseaseManagement = DiseaseManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyDiseaseManagement;

        $totalDailyHarvesting = Harvesting::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyHarvesting;

        $totalDailyLandPreparation = LandPreparation::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyLandPreparation;

        $totalDailyNutrientManagement = NutrientManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyNutrientManagement;

        $totalDailyPestManagement = PestManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyPestManagement;

        $totalDailyRoguing = Roguing::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyRoguing;

        $totalDailySeedlingManagement = SeedlingManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailySeedlingManagement;

        $totalDailyWaterManagement = WaterManagement::select('production_plot_code')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get()
                                                            ->count();
        $data['totalDailyData'] += $totalDailyWaterManagement;

        // data submitted
        $dailyData = array();
        $newDailyCropEstablishment = CropEstablishment::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyDamageAssessment = DamageAssessment::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyDiseaseManagement = DiseaseManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyHarvesting = Harvesting::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyLandPreparation = LandPreparation::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyNutrientManagement = NutrientManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyPestManagement = PestManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyRoguing = Roguing::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailySeedlingManagement = SeedlingManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        $newDailyWaterManagement = WaterManagement::select('*')
                                                            ->whereDate('date_collected', '=', $dateToday)
                                                            ->get();

        foreach($newDailyCropEstablishment as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Crop Establishment'
            );
        }

        foreach($newDailyDamageAssessment as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Damage Assessment'
            );
        }

        foreach($newDailyDiseaseManagement as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Disease Management'
            );
        }

        foreach($newDailyHarvesting as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Harvesting'
            );
        }

        foreach($newDailyLandPreparation as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Land Preparation'
            );
        }

        foreach($newDailyNutrientManagement as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Nutrient Management'
            );
        }

        foreach($newDailyPestManagement as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Pest Management'
            );
        }

        foreach($newDailyRoguing as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Roguing'
            );
        }

        foreach($newDailySeedlingManagement as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Seedling Management'
            );
        }

        foreach($newDailyWaterManagement as $item) {
            $data['dailyData'][] = array(
                'timestamp' => date('Y-m-d H:i:s', strtotime($item->date_collected)),
                'productionPlotCode' => $item->production_plot_code,
                'form' => 'Water Management'
            );
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
