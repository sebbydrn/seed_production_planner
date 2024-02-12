<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Station;
use App\User;
use App\AffiliationUser;
use App\ProductionPlan;
use App\ProductionPlotCode;
use App\Signatory;
use App\PostProduction\PreDrying;
use App\PostProduction\PostDrying;
use App\PostProduction\Cleaning;
use DB, Excel, Auth, PDF, DateTime;

class ProcessingReportController extends Controller
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

        return view('reports.processing_report.index', compact(['role', 'years', 'stations', 'philriceStationID']));
    }

    public function generate(Request $request) {
        $stationID = $request->stationID;
        $year = $request->year;
        $sem = $request->sem;
        $seed_class = $request->seedClass;
        $processing_report = array();

        $processing_report = $this->processing_report_data($stationID, $year, $sem, $seed_class);

        echo json_encode($processing_report);
    }

    public function exportToPDF(Request $request) {
        $stationID = $request->stationID;
        $year = $request->year;
        $sem = $request->sem;
        $seed_class = $request->seedClass;

        $processing_report_data = $this->processing_report_data($stationID, $year, $sem, $seed_class);

        $processing_report_data = collect($processing_report_data);

        $data = array();

        foreach ($processing_report_data as $key => $value) {
            $station = $key;
            $variety_array = $value;

            foreach ($variety_array as $key => $value) {
                $variety = $key;
                $seed_class_array = $value;

                foreach ($seed_class_array as $key => $value) {
                    $seed_class = $key;

                    $fresh_moisture_content = $this->moisture_content_value($value['fresh_moisture_content']);
                    $dried_moisture_content = $this->moisture_content_value($value['dried_moisture_content']);

                    $data[] = array(
                        'station' => $station,
                        'variety' => $variety,
                        'seed_class' => $seed_class,
                        'fresh_weight' => number_format($value['fresh_weight'], 2),
                        'fresh_moisture_content' => number_format($fresh_moisture_content, 2),
                        'dried_weight' => number_format($value['dried_weight'], 2),
                        'dried_moisture_content' => number_format($dried_moisture_content, 2),
                        'filled_weight' => number_format($value['filled_weight'], 2),
                        'half_filled_weight' => number_format($value['half_filled_weight'], 2),
                        'unfilled_weight' => number_format($value['unfilled_weight'], 2),
                        'remarks' => ''
                    );
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
            $fileName = "Processing Report.pdf";
            $pdf = PDF::loadView('reports.processing_report.pdf', compact([
                'data',
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

        $processing_report_data = $this->processing_report_data($stationID, $year, $sem, $seed_class);

        $processing_report_data = collect($processing_report_data);

        $data = array();

        foreach ($processing_report_data as $key => $value) {
            $station = $key;
            $variety_array = $value;

            foreach ($variety_array as $key => $value) {
                $variety = $key;
                $seed_class_array = $value;

                foreach ($seed_class_array as $key => $value) {
                    $seed_class = $key;

                    $fresh_moisture_content = $this->moisture_content_value($value['fresh_moisture_content']);
                    $dried_moisture_content = $this->moisture_content_value($value['dried_moisture_content']);

                    $data[] = array(
                        'station' => $station,
                        'variety' => $variety,
                        'seed_class' => $seed_class,
                        'fresh_weight' => number_format($value['fresh_weight'], 2),
                        'fresh_moisture_content' => number_format($fresh_moisture_content, 2),
                        'dried_weight' => number_format($value['dried_weight'], 2),
                        'dried_moisture_content' => number_format($dried_moisture_content, 2),
                        'filled_weight' => number_format($value['filled_weight'], 2),
                        'half_filled_weight' => number_format($value['half_filled_weight'], 2),
                        'unfilled_weight' => number_format($value['unfilled_weight'], 2),
                        'remarks' => ''
                    );
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
            Excel::create('Processing Report', function($excel) use (
                $data,
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
                    $year,
                    $sem,
                    $station,
                    $prepared,
                    $certified,
                    $approved
                ) {
                    // Load view for the sheet
                    $sheet->loadView('reports.processing_report.excel', array(
                        'data' => $data,
                        'year' => $year,
                        'sem' => $sem,
                        'station' => $station,
                        'prepared' => $prepared,
                        'certified' => $certified,
                        'approved' => $approved
                    ))
                    ->setColumnFormat(array(
                        'D' => '0.00', // Format fresh weight column
                        'E' => '0.00', // Format fresh mc column
                        'F' => '0.00', // Format dried weight column
                        'G' => '0.00', // Format dried mc column
                        'H' => '0.00', // Format filled weight column
                        'I' => '0.00', // Format half filled column
                        'J' => '0.00', // Format unfilled column
                    ))
                    ->protect('RS1S_@dm1n1str4t0r');
                });
            })
            ->download('xls');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function processing_report_data($stationID, $year, $sem, $seed_class) {
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
            // get weight of harvest and moisture content in pre drying data
            $pre_drying = DB::table('post_production.pre_drying as drying')
            ->leftJoin('post_production.harvest_weight as weight', 'drying.pre_drying_id', '=', 'weight.pre_drying_id')
            ->select(DB::raw('SUM(CAST(weight.fresh_weight AS DECIMAL(10,4))) AS total_weight'))
            ->where('drying.processing_code', '=', $p->proc_code)
            ->first();

            $pre_moisture_content = PreDrying::select('moisture_content as value')
            ->where('processing_code', '=', $p->proc_code)
            ->get();

            // get weight and moisture content in post drying data
            $post_drying = PostDrying::select(DB::raw('SUM(CAST(dried_weight AS DECIMAL(10,4))) AS total_weight'))
            ->where('processing_code', '=', $p->proc_code)
            ->first();

            $post_moisture_content = PostDrying::select('moisture_content as value')
            ->where('processing_code', '=', $p->proc_code)
            ->get();

            // get weight in seed cleaning data
            $seed_clean = Cleaning::select('filled_weight', 'half_filled_weight', 'unfilled_weight')
            ->where('processing_code', '=', $p->proc_code)
            ->first();
 
            $station = Station::select('station_code')->where('philrice_station_id', '=', $p->station)->first();

            if (array_key_exists($station->station_code, $data)) {
                if (array_key_exists($p->variety, $data[$station->station_code])) {
                    // check if seed class array exists in variety array in data array
                    if (array_key_exists($p->seed_class, $data[$station->station_code][$p->variety])) {
                        // add weight
                        $data[$station->station_code][$p->variety][$p->seed_class]['fresh_weight'] += ($pre_drying != null) ? floatval($pre_drying->total_weight) : 0;
                        $data[$station->station_code][$p->variety][$p->seed_class]['dried_weight'] += ($post_drying != null) ? floatval($post_drying->total_weight) : 0;
                        $data[$station->station_code][$p->variety][$p->seed_class]['filled_weight'] += ($seed_clean != null) ? floatval($seed_clean->filled_weight) : 0;
                        $data[$station->station_code][$p->variety][$p->seed_class]['half_filled_weight'] += ($seed_clean != null) ? floatval($seed_clean->half_filled_weight) : 0;
                        $data[$station->station_code][$p->variety][$p->seed_class]['unfilled_weight'] += ($seed_clean != null) ? floatval($seed_clean->unfilled_weight) : 0;

                        // add values to moisture content array
                        $data[$station->station_code][$p->variety][$p->seed_class]['fresh_moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['fresh_moisture_content'], $pre_moisture_content);
                        $data[$station->station_code][$p->variety][$p->seed_class]['dried_moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['dried_moisture_content'], $post_moisture_content);
                    } else {
                        // add seed class as key in variety array in data array
                        $data[$station->station_code][$p->variety][$p->seed_class] = array(
                            'fresh_weight' => ($pre_drying != null) ? floatval($pre_drying->total_weight) : 0,
                            'fresh_moisture_content' => array(),
                            'dried_weight' => ($post_drying != null) ? floatval($post_drying->total_weight) : 0,
                            'dried_moisture_content' => array(),
                            'filled_weight' => ($seed_clean != null) ? $seed_clean->filled_weight : 0,
                            'half_filled_weight' => ($seed_clean != null) ? $seed_clean->half_filled_weight : 0,
                            'unfilled_weight' => ($seed_clean != null) ? $seed_clean->unfilled_weight : 0
                        );

                        // add values to moisture content array
                        $data[$station->station_code][$p->variety][$p->seed_class]['fresh_moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['fresh_moisture_content'], $pre_moisture_content);
                        $data[$station->station_code][$p->variety][$p->seed_class]['dried_moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['dried_moisture_content'], $post_moisture_content);
                    }
                } else {
                    // add variety as key in station array
                    $data[$station->station_code][$p->variety] = array();

                    // add seed class as key in variety array in station array
                    $data[$station->station_code][$p->variety][$p->seed_class] = array(
                        'fresh_weight' => ($pre_drying != null) ? floatval($pre_drying->total_weight) : 0,
                        'fresh_moisture_content' => array(),
                        'dried_weight' => ($post_drying != null) ? floatval($post_drying->total_weight) : 0,
                        'dried_moisture_content' => array(),
                        'filled_weight' => ($seed_clean != null) ? $seed_clean->filled_weight : 0,
                        'half_filled_weight' => ($seed_clean != null) ? $seed_clean->half_filled_weight : 0,
                        'unfilled_weight' => ($seed_clean != null) ? $seed_clean->unfilled_weight : 0
                    );

                    // add values to moisture content array
                    $data[$station->station_code][$p->variety][$p->seed_class]['fresh_moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['fresh_moisture_content'], $pre_moisture_content);
                    $data[$station->station_code][$p->variety][$p->seed_class]['dried_moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['dried_moisture_content'], $post_moisture_content);
                }
            } else {
                    // add station as key in data array
                    $data[$station->station_code] = array();

                    // add variety as key in station array
                    $data[$station->station_code][$p->variety] = array();

                    // add seed class as key in variety array in station array
                    $data[$station->station_code][$p->variety][$p->seed_class] = array(
                        'fresh_weight' => ($pre_drying != null) ? floatval($pre_drying->total_weight) : 0,
                        'fresh_moisture_content' => array(),
                        'dried_weight' => ($post_drying != null) ? floatval($post_drying->total_weight) : 0,
                        'dried_moisture_content' => array(),
                        'filled_weight' => ($seed_clean != null) ? $seed_clean->filled_weight : 0,
                        'half_filled_weight' => ($seed_clean != null) ? $seed_clean->half_filled_weight : 0,
                        'unfilled_weight' => ($seed_clean != null) ? $seed_clean->unfilled_weight : 0
                    );

                    // add values to moisture content array
                    $data[$station->station_code][$p->variety][$p->seed_class]['fresh_moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['fresh_moisture_content'], $pre_moisture_content);
                    $data[$station->station_code][$p->variety][$p->seed_class]['dried_moisture_content'] = $this->mc_array_builder($data[$station->station_code][$p->variety][$p->seed_class]['dried_moisture_content'], $post_moisture_content);
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

    // checks if query result is not empty and pushes the mc to array
    private function mc_array_builder($array, $query_result) {
        if ($query_result->count() > 0) {
            foreach ($query_result as $m) {
                array_push($array, floatval($m->value));
            }
        }

        return $array;
    }

    public function moisture_content_value($array) {
        // get the average of moisture content if values are more than 1
        $moisture_content_len = count($array);
        $moisture_content = 0;

        if ($moisture_content_len > 1) {
            foreach ($array as $val) {
                $moisture_content += floatval($val);
            }

            $moisture_content = $moisture_content / $moisture_content_len;
        } else {
            $moisture_content = $array[0];
        }

        return $moisture_content;
    }
}
