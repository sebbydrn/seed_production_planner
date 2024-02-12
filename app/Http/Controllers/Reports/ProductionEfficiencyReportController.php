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
use App\XMLData;
use App\StationSerialNumber;
use App\SGForms;
use App\PostProduction\BaggedSeeds;
use DB, Excel, Auth, PDF, DateTime;
use App\Helpers\DatabaseConnection;

class ProductionEfficiencyReportController extends Controller
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

        return view('reports.production_efficiency_report.index', compact(['role', 'years', 'stations', 'philriceStationID']));
    }

    public function generate(Request $request) {
        $stationID = $request->stationID;
        $year = $request->year;
        $sem = $request->sem;
        $seed_prod_eff_report = array();

        $seed_prod_eff_report = $this->seed_prod_eff_data($stationID, $year, $sem);

        echo json_encode($seed_prod_eff_report);
    }

    public function exportToPDF(Request $request) {
        $stationID = $request->stationID;
        $year = $request->year;
        $sem = $request->sem;

        $data = $this->seed_prod_eff_data($stationID, $year, $sem);

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
            $fileName = "Production Efficiency Report.pdf";
            $pdf = PDF::loadView('reports.production_efficiency_report.pdf', compact([
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

        $data = $this->seed_prod_eff_data($stationID, $year, $sem);

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
            Excel::create('Production Efficiency Report', function($excel) use (
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
                    $sheet->loadView('reports.production_efficiency_report.excel', array(
                        'data' => $data,
                        'year' => $year,
                        'sem' => $sem,
                        'station' => $station,
                        'prepared' => $prepared,
                        'certified' => $certified,
                        'approved' => $approved
                    ))
                    ->setColumnFormat(array(
                        'H' => '0.00',
                        'I' => '0.00',
                        'J' => '0.00',
                        'K' => '0.00',
                        'L' => '0.00',
                    ))
                    ->protect('RS1S_@dm1n1str4t0r');
                });
            })
            ->download('xls');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function seed_prod_eff_data($stationID, $year, $sem) {
        // check if pallet plan for year and sem exists
        $pallet_plan = DB::connection('warehouse')
        ->table('warehouses as w')
        ->leftJoin('pallet_plans as p', 'w.warehouse_id', '=', 'p.warehouse_id')
        ->when($stationID != 0, function($query) use ($stationID) {
            return $query->where('w.station_id', '=', $stationID);
        })
        ->where([
            ['p.year', '=', $year],
            ['p.semester', '=', $sem]
        ])
        ->select('w.station_id')
        ->groupBy('w.station_id')
        ->get();

        $data = array();

        if ($pallet_plan->count() > 0) {
            // seed sampling data xml from api
            $seed_sampling_data = $this->api_data_xml('APISEEDSAMPLINGDataList');

            foreach ($pallet_plan as $p) {
                // philrice station serial numbers
                $station_sn = StationSerialNumber::select('serial_number')->where('philrice_station_id', '=', $p->station_id)->get();

                $serial_numbers = array();

                foreach ($station_sn as $s) {
                    array_push($serial_numbers, $s->serial_number);
                }

                // stocks/inventory schema and table name
                $station = Station::select('station_code')->where('philrice_station_id', '=', $p->station_id)->first();

                $schema_name = strtolower($station->station_code);
                $stocks_table = "tbl_sem".$sem."_".$year."_stocks";

                // Set database connection
                $connection = DatabaseConnection::setDBConnection($schema_name);

                // On the fly database config name
                $dbConnection = "station_schema";

                $seeds = $connection->table($stocks_table)
                ->select('lot_no', 'variety', 'date_harvested')
                ->where([
                    ['year_harvested', '=', $year],
                    ['semester_harvested', '=', $sem]
                ])
                ->orderBy('variety', 'ASC')
                ->get();

                if ($seeds->count() > 0) {
                    foreach ($seeds as $s) {
                        $date_harvested = $s->date_harvested;
                        
                        // variety nsic code and name
                        $var = Seed::select('NSICCode', 'VarietyName')
                        ->where([
                            ['variety', '=', $s->variety],
                            ['variety_name', 'NOT LIKE', '%DWSR%']
                        ])
                        ->first();

                        $d = array(
                            'lot_no' => $s->lot_no,
                            'NSIC_code' => $var->NSICCode,
                            'variety_name' => $var->VarietyName,
                            'serial_numbers' => $serial_numbers
                        );

                        // get sampling and laboratory result of bagged seeds query result in the sampling data api
                        $sampling_data = $this->sampling_data($seed_sampling_data, $d);

                        $growapp = "-";
                        $fs = 0;
                        $rs = 0;
                        $cs = 0;
                        $reject = 0;
                        $total = 0;

                        $fs_weight_sampled = 0;
                        $rs_weight_sampled = 0;

                        if (!empty($sampling_data)) {
                            // get seed class planted in growapp data
                            $growapp = SGForms::select('seedclass')->where('trackingid', '=', $sampling_data['growapp_tracking_no'])->first();

                            if ($sampling_data['lab_res'] == "Passed") {
                                switch ($sampling_data['seed_class']) {
                                    case 'Foundation Seed':
                                        $fs = floatval($sampling_data['weight_passed']);
                                        $total = $fs;
                                        break;
                                    case 'Registered Seed':
                                        $rs = floatval($sampling_data['weight_passed']);
                                        $total = $rs;
                                        break;
                                    case 'Certified Seed':
                                        $cs = floatval($sampling_data['weight_passed']);
                                        $total = $cs;
                                        break;
                                }
                            }

                            $reject = floatval($sampling_data['weight_reject']);

                            $total = $total + $reject;

                            if ($sampling_data['date_released'] != "-") {
                                $date_released = date('M d, Y', strtotime($sampling_data['date_released']));
                            } else {
                                $date_released = "-";
                            }

                            if ($growapp) {
                                switch ($growapp->seedclass) {
                                    case 'Foundation':
                                        $fs_weight_sampled = floatval($sampling_data['weight_sampled']);
                                    case 'Registered':
                                        $rs_weight_sampled = floatval($sampling_data['weight_sampled']);
                                }
                            }
                        } else {
                            $date_released = "-";
                        }

                        $data[] = array(
                            'variety' => $s->variety,
                            'seed_class_planted' => ($growapp != "-") ? $growapp->seedclass : $growapp,
                            'lot_no' => $s->lot_no,
                            'date_harvested' => ($date_harvested != null) ? date('M d, Y', strtotime($date_harvested)) : '-',
                            'date_sampled' => (!empty($sampling_data)) ? date('M d, Y', strtotime($sampling_data['date_sampled'])) : "-",
                            'lab_no' => (!empty($sampling_data)) ? $sampling_data['lab_no'] : "-",
                            'produced_by' => $station->station_code,
                            'fs' => $fs,
                            'rs' => $rs,
                            'cs' => $cs,
                            'reject' => $reject,
                            'total' => $total,
                            'date_released' => $date_released,
                            'fs_weight_sampled' => $fs_weight_sampled,
                            'rs_weight_sampled' => $rs_weight_sampled
                        );
                    }
                }
            }
        }

        return $data;
    }

    private function api_data_xml($api) {
        $res = XMLData::select('xml')
        ->where('name', '=', $api)
        ->orderBy('timestamp', 'desc')
        ->first();

        $xml = $res->xml;
        $xml = simplexml_load_string($xml);
        $xml = json_encode($xml);
        $api_data = json_decode($xml, TRUE);

        return $api_data;
    }

    private function sampling_data($api_data, $data) {
        $result = array();

        // get lab test status result using tracking id
        foreach ($api_data['seedsampling'] as $s) {
            foreach ($data['serial_numbers'] as $serial) {
                if (!is_array($s['VarCode']) && !is_array($s['VarSrcID'])) { // added to fix error when variety is null in sampling api
                    if (strtolower(trim($s['SamplingLotNo'])) == strtolower(trim($data['lot_no'])) && 
                        strtolower(trim($s['VarCode'])) == strtolower(trim($data['NSIC_code'])) && 
                        strtolower(trim($s['VarSrcID'])) == strtolower(trim($data['variety_name'])) && 
                        strtolower(trim($s['SGSerialNum'])) == strtolower(trim($serial))) {
                        $weight_passed = floatval($s['NumBagPass']) * floatval($s['BagWeight']);

                        $weight_reject = floatval($s['NumBagReject']) * floatval($s['BagWeight']);

                        $weight_sampled = floatval($s['BagsRecived']) * floatval($s['BagWeight']);

                        $result = array(
                            'growapp_tracking_no' => $s['GrowTrackingNum'],
                            'date_sampled' => $s['DateSampled'],
                            'weight_passed' => $weight_passed,
                            'weight_reject' => $weight_reject,
                            'date_released' => $s['DateTestCompleted'],
                            'seed_class' => $s['SeedClassAfter'],
                            'lab_res' => $s['LaboratoryResult'],
                            'lab_no' => $s['SamplingLabNo'],
                            'weight_sampled' => $weight_sampled
                        );

                        break;
                    }
                }
            }
        }

        return $result;
    }

    // StationID of logged in user
    private function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }
}
