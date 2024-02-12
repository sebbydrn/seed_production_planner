<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Station;
use App\Seed;
use App\User;
use App\AffiliationUser;
use App\ProductionPlan;
use App\ProductionPlotCode;
use App\Signatory;
use App\SeedTraceGeotag\Harvesting;
use App\PostProduction\ProcessingCode;
use App\PostProduction\PreDrying;
use DB, Excel, Auth, PDF, DateTime;

class HarvestingReportController extends Controller
{   
    public function __construct() {
        $this->middleware('permission:view_planting_reports')->only(['index']);
    }
    
    public function index() {
        $role = $this->role();

        // PhilRice stations
        $stations = Station::select('philrice_station_id', 'name')->orderBy('philrice_station_id', 'ASC')->get();

        // Production plan years
        $years = ProductionPlan::select('year')->groupBy('year')->get();

        // Get station code of user's station
        $philriceStationID = $this->userStationID();

        return view('reports.harvesting_report.index', compact(['role', 'years', 'stations', 'philriceStationID']));
    }

    public function generate(Request $request) {
        $stationID = $request->stationID;
        $year = $request->year;
        $sem = $request->sem;
        $seed_class = $request->seedClass;
        $harvesting_report = array();

        $harvesting_report = $this->harvesting_report_data($stationID, $year, $sem, $seed_class);

        echo json_encode($harvesting_report);
    }

    public function exportToPDF(Request $request) {
        $stationID = $request->stationID;
        $year = $request->year;
        $sem = $request->sem;
        $seed_class = $request->seedClass;

        $harvesting_report_data = $this->harvesting_report_data($stationID, $year, $sem, $seed_class);

        $harvesting_report_data = collect($harvesting_report_data);

        $data = array();

        $total_area = 0;
        $total_area_bs = 0;
        $total_area_fs = 0;
        $total_area_rs = 0;
        $total_weight = 0;
        $total_weight_bs = 0;
        $total_weight_fs = 0;
        $total_weight_rs = 0;

        foreach ($harvesting_report_data as $key => $value) {
            $station = $key;
            $variety_array = $value;

            foreach ($variety_array as $key => $value) {
                $variety = $key;
                $seed_class_array = $value;

                foreach ($seed_class_array as $key => $value) {
                    $seed_class = $key;

                    // get the average of moisture content if values are more than 1
                    $moisture_content_len = count($value['moisture_content']);
                    $moisture_content = 0;

                    if ($moisture_content_len > 1) {
                        foreach ($value['moisture_content'] as $val) {
                            $moisture_content += floatval($val);
                        }

                        $moisture_content = $moisture_content / $moisture_content_len;
                    } else {
                        $moisture_content = $value['moisture_content'][0];
                    }

                    $data[] = array(
                        'station' => $station,
                        'variety' => $variety,
                        'ecosystem' => $value['ecosystem'],
                        'maturity' => $value['maturity'],
                        'seed_class' => $seed_class,
                        'area' => number_format($value['area'], 2),
                        'harvest_date' => $value['date_harvest'],
                        'weight' => number_format($value['weight'], 2),
                        'moisture_content' => number_format($moisture_content, 2),
                        'remarks' => ''
                    );

                    $total_area += $value['area'];
                    $total_weight += $value['weight'];

                    switch ($seed_class) {
                        case "Nucleus":
                            $total_area_bs += $value['area'];
                            $total_weight_bs += $value['weight'];
                            break;
                        case "Breeder":
                            $total_area_fs += $value['area'];
                            $total_weight_fs += $value['weight'];
                            break;
                        case "Foundation":
                            $total_area_rs += $value['area'];
                            $total_weight_rs += $value['weight'];
                            break;
                    }
                }
            }
        }

        if ($stationID == 0) {
            $station = "All PhilRice Branch and Satellite Stations";
        } else {
            // Name of philrice station
            $station = Station::select('name', 'station_code', 'philrice_station_id')
            ->where('philrice_station_id', '=', $stationID)
            ->first();
        }

        // Signatories
        if ($stationID == 0) {
            $prepared = "";
            $certified = "";
            $approved = "";
        } else if ($stationID == 4) {
            $prepared = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                                    ['designation', '=', 'SRS II'] // Update this when changed in database
                                ])
            ->first();

            $certified = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'Seed Production In-Charge']
            ])
            ->first();

            $approved = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'BDD Head']
            ])
            ->first();
        } else {
            $prepared = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'Seed Production In-Charge']
            ])
            ->first();

            $certified = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'BDD/U Coordinator']
            ])
            ->first();

            // For satellite stations
            if ($stationID == 15) {
                // CMU -> Agusan
                $stationID2 = 10;
            } else if ($stationID == 16) {
                // Zamboanga -> Midsayap
                $stationID2 = 8;
            } else if ($stationID == 17) {
                // Samar -> Bicol
                $stationID2 = 14;
            } else if ($stationID == 18) {
                // Mindoro -> LB
                $stationID2 = 9;
            } else {
                $stationID2 = $stationID;
            }

            $approved = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID2],
                ['designation', '=', 'Branch Director']
            ])
            ->first();
        }

        try {
            $custom_paper = array(0, 0, 612.00, 936.00);
            $fileName = "Harvesting Report.pdf";
            $pdf = PDF::loadView('reports.harvesting_report.pdf', compact([
                'data', 
                'total_area', 
                'total_weight',
                'total_area_bs', 
                'total_area_rs', 
                'total_area_fs',
                'total_weight_bs', 
                'total_weight_rs', 
                'total_weight_fs', 
                'year', 
                'sem', 
                'station', 
                'prepared', 
                'certified', 
                'approved'
            ]));
            $pdf->setPaper($custom_paper, 'landscape');
            return $pdf->stream();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function export(Request $request) {
         $stationID = $request->stationID;
        $year = $request->year;
        $sem = $request->sem;
        $seed_class = $request->seedClass;

        $harvesting_report_data = $this->harvesting_report_data($stationID, $year, $sem, $seed_class);

        $harvesting_report_data = collect($harvesting_report_data);

        $data = array();

        $total_area = 0;
        $total_area_bs = 0;
        $total_area_fs = 0;
        $total_area_rs = 0;
        $total_weight = 0;
        $total_weight_bs = 0;
        $total_weight_fs = 0;
        $total_weight_rs = 0;

        foreach ($harvesting_report_data as $key => $value) {
            $station = $key;
            $variety_array = $value;

            foreach ($variety_array as $key => $value) {
                $variety = $key;
                $seed_class_array = $value;

                foreach ($seed_class_array as $key => $value) {
                    $seed_class = $key;

                    // get the average of moisture content if values are more than 1
                    $moisture_content_len = count($value['moisture_content']);
                    $moisture_content = 0;

                    if ($moisture_content_len > 1) {
                        foreach ($value['moisture_content'] as $val) {
                            $moisture_content += floatval($val);
                        }

                        $moisture_content = $moisture_content / $moisture_content_len;
                    } else {
                        $moisture_content = $value['moisture_content'][0];
                    }

                    $data[] = array(
                        'station' => $station,
                        'variety' => $variety,
                        'ecosystem' => $value['ecosystem'],
                        'maturity' => $value['maturity'],
                        'seed_class' => $seed_class,
                        'area' => number_format($value['area'], 2),
                        'harvest_date' => $value['date_harvest'],
                        'weight' => number_format($value['weight'], 2),
                        'moisture_content' => number_format($moisture_content, 2),
                        'remarks' => ''
                    );

                    $total_area += $value['area'];
                    $total_weight += $value['weight'];

                    switch ($seed_class) {
                        case "Nucleus":
                            $total_area_bs += $value['area'];
                            $total_weight_bs += $value['weight'];
                        case "Breeder":
                            $total_area_fs += $value['area'];
                            $total_weight_fs += $value['weight'];
                            break;
                        case "Foundation":
                            $total_area_rs += $value['area'];
                            $total_weight_rs += $value['weight'];
                            break;
                    }
                }
            }
        }

        // Name of philrice station
        $station = Station::select('name', 'station_code', 'philrice_station_id')
        ->where('philrice_station_id', '=', $stationID)
        ->first();

        if ($stationID == 0) {
            $station = "All PhilRice Branch and Satellite Stations";
        } else {
            // Name of philrice station
            $station = Station::select('name', 'station_code', 'philrice_station_id')
            ->where('philrice_station_id', '=', $stationID)
            ->first();
        }

        // Signatories
        if ($stationID == 0) {
            $prepared = "";
            $certified = "";
            $approved = "";
        } else if ($stationID == 4) {
            $prepared = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                                    ['designation', '=', 'SRS II'] // Update this when changed in database
                                ])
            ->first();

            $certified = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'Seed Production In-Charge']
            ])
            ->first();

            $approved = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'BDD Head']
            ])
            ->first();
        } else {
            $prepared = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'Seed Production In-Charge']
            ])
            ->first();

            $certified = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'BDD/U Coordinator']
            ])
            ->first();

            // For satellite stations
            if ($stationID == 15) {
                // CMU -> Agusan
                $stationID2 = 10;
            } else if ($stationID == 16) {
                // Zamboanga -> Midsayap
                $stationID2 = 8;
            } else if ($stationID == 17) {
                // Samar -> Bicol
                $stationID2 = 14;
            } else if ($stationID == 18) {
                // Mindoro -> LB
                $stationID2 = 9;
            } else {
                $stationID2 = $stationID;
            }

            $approved = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID2],
                ['designation', '=', 'Branch Director']
            ])
            ->first();
        }

        try {
            // Create excel
            Excel::create('Harvesting Report', function($excel) use (
                $data, 
                $total_area, 
                $total_weight,
                $total_area_bs, 
                $total_area_rs, 
                $total_area_fs,
                $total_weight_bs, 
                $total_weight_rs, 
                $total_weight_fs,
                $year,
                $sem,
                $station,
                $prepared,
                $certified,
                $approved
            ) {
                // Create sheet
                $excel->sheet('Sheet 1', function($sheet) use (
                    $data, 
                    $total_area, 
                    $total_weight,
                    $total_area_bs, 
                    $total_area_rs, 
                    $total_area_fs,
                    $total_weight_bs, 
                    $total_weight_rs, 
                    $total_weight_fs,
                    $year,
                    $sem,
                    $station,
                    $prepared,
                    $certified,
                    $approved
                ) {
                    // Load view for the sheet
                    $sheet->loadView('reports.harvesting_report.excel', array(
                        'data' => $data,
                        'total_area' => $total_area,
                        'total_weight' => $total_weight,
                        'total_area_bs' => $total_area_bs,
                        'total_area_rs' => $total_area_rs,
                        'total_area_fs' => $total_area_fs,
                        'total_weight_bs' => $total_weight_bs,
                        'total_weight_rs' => $total_weight_rs,
                        'total_weight_fs' => $total_weight_fs,
                        'year' => $year,
                        'sem' => $sem,
                        'station' => $station,
                        'prepared' => $prepared,
                        'certified' => $certified,
                        'approved' => $approved
                    ))
                    ->setColumnFormat(array(
                        'F' => '0.00', // Format area column
                        'H' => '0.00', // Format weight column
                        'I' => '0.00' // Format moisture content column
                    ))
                    ->protect('RS1S_@dm1n1str4t0r');
                });
            })
            ->download('xls');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function harvesting_report_data($stationID, $year, $sem, $seed_class) {
        // get processing codes 
        $processing_codes = DB::table('post_production.processing_codes as code')
        ->leftJoin('seed_trace_geotag.harvesting as harv', 'code.harvesting_id', '=', 'harv.harvesting_id')
        ->leftJoin('seed_planner.production_plot_codes as plot', 'harv.production_plot_code', '=', 'plot.production_plot_code')
        ->leftJoin('seed_planner.production_plans as plan', 'plot.production_plan_id', '=', 'plan.production_plan_id')
        ->select(
            'code.processing_code as proc_code',
            'harv.timestamp as date_harvest',
            'plan.variety as variety', 
            'plan.seed_class as seed_class',
            'plan.philrice_station_id as station'
        )
        ->when($stationID != 0, function($query) use ($stationID) {
            return $query->where('plan.philrice_station_id', '=', $stationID);
        })
        ->when($seed_class != "All", function($query) use ($seed_class) {
            return $query->where('plan.seed_class', '=', $seed_class);
        })
        ->where([
            ['plan.year', '=', $year],
            ['plan.sem', '=', $sem]
        ])
        ->orderBy('variety', 'ASC')
        ->get()
        ->unique('proc_code');

        $data = array();

        // get area of harvest data
        foreach ($processing_codes as $p) {
            // get harvesting ids of the processing code
            $plan = ProcessingCode::select('harvesting_id')
            ->where('processing_code', '=', $p->proc_code)
            ->get();

            if ($plan->count() > 0) {
                foreach ($plan as $pl) {
                    // harvested area
                    $harvest = Harvesting::select(DB::raw('SUM(CAST(harvested_area AS DECIMAL(10,4))) AS total_area'))
                    ->where('harvesting_id', '=', $pl->harvesting_id)
                    ->first();
                }
            }

            // seed characteristics
            $seed_char = Seed::select('ecosystem', 'maturity')
            ->where([
                ['variety', '=', $p->variety],
                ['variety_name', 'NOT LIKE', '%DWSR%']
            ])
            ->first();

            // get weight of harvest and moisture content in pre drying data
            $drying = DB::table('post_production.pre_drying as drying')
            ->leftJoin('post_production.harvest_weight as weight', 'drying.pre_drying_id', '=', 'weight.pre_drying_id')
            ->select(DB::raw('SUM(CAST(weight.fresh_weight AS DECIMAL(10,4))) AS total_weight'))
            ->where('drying.processing_code', '=', $p->proc_code)
            ->first();

            $moisture_content = PreDrying::select('moisture_content as value')
            ->where('processing_code', '=', $p->proc_code)
            ->get();

            $station = Station::select('station_code')->where('philrice_station_id', '=', $p->station)->first();

            if (array_key_exists($station->station_code, $data)) {
                if (array_key_exists($p->variety, $data[$station->station_code])) {
                    // check if seed class array exists in variety array in data array
                    if (array_key_exists($p->seed_class, $data[$station->station_code][$p->variety])) {
                        // set date of harvesting
                        $data[$station->station_code][$p->variety][$p->seed_class]['date_harvest'] = $this->date_earlier($data[$station->station_code][$p->variety][$p->seed_class]['date_harvest'], $p->date_harvest);

                        // add weight
                        $data[$station->station_code][$p->variety][$p->seed_class]['weight'] += floatval($drying->total_weight);

                        // add values to moisture content array
                        $data[$station->station_code][$p->variety][$p->seed_class]['moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['moisture_content'], $moisture_content);

                        // add area
                        $data[$station->station_code][$p->variety][$p->seed_class]['area'] += ($harvest != "") ? floatval($harvest->total_area) : 0;
                    } else {
                        // add seed class as key in variety array in data array
                        $data[$station->station_code][$p->variety][$p->seed_class] = array(
                            'ecosystem' => $seed_char->ecosystem,
                            'maturity' => $seed_char->maturity,
                            'area' => ($harvest != "") ? floatval($harvest->total_area) : 0,
                            'date_harvest' => ($p->date_harvest != "") ? date("M d, Y", strtotime($p->date_harvest)) : '-',
                            'weight' => floatval($drying->total_weight),
                            'moisture_content' => array()
                        );

                        // add values to moisture content array
                        $data[$station->station_code][$p->variety][$p->seed_class]['moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['moisture_content'], $moisture_content);
                    }
                } else {
                    // add variety as key in station array
                    $data[$station->station_code][$p->variety] = array();

                    // add seed class as key in variety array in station array
                    $data[$station->station_code][$p->variety][$p->seed_class] = array(
                        'ecosystem' => $seed_char->ecosystem,
                        'maturity' => $seed_char->maturity,
                        'area' => ($harvest != "") ? floatval($harvest->total_area) : 0,
                        'date_harvest' => ($p->date_harvest != "") ? date("M d, Y", strtotime($p->date_harvest)) : '-',
                        'weight' => floatval($drying->total_weight),
                        'moisture_content' => array()
                    );

                    // add values to moisture content array
                    $data[$station->station_code][$p->variety][$p->seed_class]['moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['moisture_content'], $moisture_content);
                }
            } else {
                    // add station as key in data array
                    $data[$station->station_code] = array();

                    // add variety as key in station array
                    $data[$station->station_code][$p->variety] = array();

                    // add seed class as key in variety array in station array
                    $data[$station->station_code][$p->variety][$p->seed_class] = array(
                        'ecosystem' => $seed_char->ecosystem,
                        'maturity' => $seed_char->maturity,
                        'area' => ($harvest != "") ? floatval($harvest->total_area) : 0,
                        'date_harvest' => ($p->date_harvest != "") ? date("M d, Y", strtotime($p->date_harvest)) : '-',
                        'weight' => floatval($drying->total_weight),
                        'moisture_content' => array()
                    );

                    // add values to moisture content array
                    $data[$station->station_code][$p->variety][$p->seed_class]['moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['moisture_content'], $moisture_content);
            }
        }

        ksort($data);

        return($data);
    }

    // StationID of logged in user
    public function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }

    // compares 2 dates and return the one that is earlier
    private function date_earlier($date1, $date2) {
        $date1 = new DateTime($date1);
        $date2 = new DateTime($date2);

        // compare dates
        if ($date1 < $date2) {
            return $date1->format("M d, Y");
        }

        if ($date1 > $date2) {
            return $date2->format("M d, Y");
        }

        if ($date1 == $date2) {
            return $date1->format("M d, Y");
        }
    }

    // checks if query result is not empty and pushes the mc to array
    private function mc_array_builder($array, $query_result) {
        if ($query_result->count() > 0) {
            foreach ($query_result as $m) {
                array_push($array, floatval($m->value));
            }
        }

        return $array;
    }
}
