<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Seed;
use App\SGForms;
use App\XMLData;
use DB;

class CertificationTrackerController extends Controller
{   
    public function __construct() {
        $this->middleware('permission:view_seed_certification_tracker')->only(['index']);
    }

    public function index() {
        $role = $this->role();

        // varieties
        $varieties = Seed::select('variety')->where('variety_name', 'NOT LIKE', '%DWSR%')->orderBy('variety', 'asc')->get();

        return view('reports.certification_tracker.index', compact(['role', 'varieties']));
    }

    public function track(Request $request) {
        $variety = $request->variety;
        $serial_number = trim($request->serial_number);
        $lot_no = trim($request->lot_no);
        $lab_no = trim($request->lab_no);

        $applications = SGForms::select('seedsource', 'otherseedsource', 'seedclass', 'dateplanted', 'seedlotno', 'controlno', 'trackingid', 'serial_number')
        ->where('variety', '=', $variety)
        ->where('is_test_data', '=', 0);

        if ($serial_number != "") {
            $applications = $applications->where('serial_number', '=', $serial_number);
        }

        $applications = $applications->orderBy('date_received', 'DESC')->get();

        $data = array();

        if ($applications->count() > 0) {
            // prelim inspection data xml from api
            $prelim_inspect_data = $this->api_data_xml('APISPIDataList');

            // final inspection data xml from api
            $final_inspect_data = $this->api_data_xml('APISPFIDataList');

            // seed sampling data xml from api
            $seed_sampling_data = $this->api_data_xml('APISEEDSAMPLINGDataList');

            foreach ($applications as $a) {
                // Prelim inspection status
                $prelim_inspect_status = $this->prelim_inspect_status($prelim_inspect_data, $a->trackingid);

                // Final inspection status
                $final_inspect_status = $this->final_inspect_status($final_inspect_data, $a->trackingid);

                // Lab test status
                $lab_test_status = $this->lab_test_status($seed_sampling_data, $a->trackingid);

                $data[] = array(
                    'variety' => $variety,
                    'seed_class_planted' => $a->seedclass,
                    'seed_class_after' => $lab_test_status['seed_class'],
                    'lot_no' => $lab_test_status['lot_no'],
                    'lab_no' => $lab_test_status['lab_no'],
                    'growapp_tracking_no' => $a->trackingid,
                    'serial_number' => $a->serial_number,
                    'date_planted' => date('M d, Y', strtotime($a->dateplanted)),
                    'seed_source' => ($a->seedsource == "Others") ? $a->otherseedsource : $a->seedsource,
                    'source_lot_no' => $a->seedlotno,
                    'source_lab_no' => $a->controlno,
                    'prelim_inspect_status' => $prelim_inspect_status,
                    'final_inspect_status' => $final_inspect_status,
                    'lab_test_status' => $lab_test_status['result']
                );
            }
        }

        echo json_encode($data);
    }

    private function prelim_inspect_status($api_data, $tracking_id) {
        $result = "No data";

        // get prelim inspection result using tracking id
        foreach ($api_data['seedpreinspection'] as $p) {
            if (strtolower(trim($p['TrackingID'])) == strtolower(trim($tracking_id))) {
                $result = $p['InspStatus'];
                break;
            }
        }

        return $result;
    }

    private function final_inspect_status($api_data, $tracking_id) {
        $result = "No data";

        // get final inspection result using tracking id
        foreach ($api_data['seedfinalinspection'] as $f) {
            if (strtolower(trim($f['TrackingID'])) == strtolower(trim($tracking_id))) {
                $result = $f['InspStatus'];
                break;
            }
        }

        return $result;
    }

    private function lab_test_status($api_data, $tracking_id) {
        $result = "No data";
        $lot_numbers = array();
        $lab_no = "No data";
        $seed_class = "No data";

        // get lab test status result using tracking id
        foreach ($api_data['seedsampling'] as $s) {
            if (strtolower(trim($s['GrowTrackingNum'])) == strtolower(trim($tracking_id))) {
                $result = $s['LaboratoryResult'];
                array_push($lot_numbers, $s['SamplingLotNo']);
                $lab_no = $s['SamplingLabNo'];
                $seed_class = $s['SeedClassAfter'];
            }
        }

        $data = array(
            'result' => $result,
            'lot_no' => $lot_numbers,
            'lab_no' => $lab_no,
            'seed_class' => trim(str_replace("Seed", "", $seed_class))
        );

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
}
