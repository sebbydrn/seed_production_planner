<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductionPlan;
use App\Station;
use App\Seed;
use App\ProductionPlot;
use App\ProductionPlotCode;
use App\Plot;
use App\PlannedActivity;
use App\SeedTraceGeotag\SeedlingManagement;
use App\SeedTraceGeotag\CropEstablishment;
use App\SeedTraceGeotag\SeedCertification;
use App\User;
use App\AffiliationUser;
use App\Signatory;
use App\ActualProductionPlot;
use App\SGForms;
use App\StationSerialNumber;
use Excel, Auth, PDF;

class PlantingReportController extends Controller {

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

		return view('reports.planting_report.index', compact(['role', 'years', 'stations', 'philriceStationID']));
	}

	public function generate(Request $request) {
		$stationID = $request->stationID;
		$year = $request->year;
		$sem = $request->sem;
		$seedClass = $request->seedClass;
		$plantingReport = array();

		$productionPlans = $this->productionPlan($stationID, $year, $sem, $seedClass);

		foreach ($productionPlans as $productionPlan) {
			$productionPlanID = $productionPlan->production_plan_id;

			$productionPlotCode = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();
			$productionPlotCode = $productionPlotCode->production_plot_code;

			// Query maturity and ecosystem of the selected variety in the production plan
			$variety = Seed::select('maturity', 'ecosystem', 'variety')
			->where('variety', '=', $productionPlan->variety)
			->where('variety_name', 'NOT LIKE', '%DWSR%')
			->first();

			$maturity = ($variety != null) ? $variety->maturity : 0;
			$ecosystem = ($variety != null) ? $variety->ecosystem : '';

			// Check if there is changes to actual plots used
			$hasActual = ActualProductionPlot::select('*')
			->where('production_plan_id', '=', $productionPlanID)
			->get()
			->count();

			if ($hasActual > 0) {
				// Get actual plots used
				$productionPlots = ActualProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();
			} else {
				// Get planned plots
				$productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();
			}

			// Calculate the total area of the selected lots
			$totalArea = 0;
			foreach ($productionPlots as $productionPlot) {
				// Query the area of the plot
				$plot = Plot::select('area')->where('plot_id', '=', $productionPlot->plot_id)->first();

				$totalArea += floatval($plot->area);
			}

			// // Query the date of sowing
			$sowing = SeedlingManagement::select('timestamp')
			->where('production_plot_code', '=', $productionPlotCode)
			->where('activity', '=', 'Seed Sowing')
			->first();

			// // Query the date of transplanting
			$transplanting = CropEstablishment::select('datetime_start')
			->where('production_plot_code', '=', $productionPlotCode)
			->where('activity', '=', 'Transplanting')
			->first();

			// // Query the expected date of harvesting
			$harvesting = PlannedActivity::select('date_start')->where('activity_id', '=', 23)->where('production_plan_id', '=', $productionPlanID)->first();

			// Compute expected harvesting date based on actual date of sowing
			if ($sowing) {
				if ($maturity == 0) {
					$harvestingDate = "NO DATA";
				} else {
					$harvestingDate = date('M d, Y', strtotime($sowing->timestamp . ' + ' . $maturity . ' days'));
				}
			} else {
				$harvestingDate = ($harvesting) ? date('M d, Y', strtotime($harvesting->date_start)) : 'NO DATA';
			}

			// Station where planting plan was created
			$station = Station::where('philrice_station_id', '=', $productionPlan->philrice_station_id)->first();

			// Get source lot no of seeds planted
			// Update this query if seed production app implemented new mode of saving to db
			$source_lot = SeedCertification::select('seedlot_no', 'seed_source', 'control_no')
			->where('production_plot_code', '=', $productionPlotCode)
			->first();

			$source = "NO DATA";
			$source_lotno = "NO DATA";
			$source_lab = "NO DATA";

			if ($source_lot) {
				$source = $source_lot->seed_source;
				$source_lotno = $source_lot->seedlot_no;
				$source_lab = $source_lot->control_no;
			} else {
				// get serial numbers of station
				$serials = StationSerialNumber::select('serial_number')
				->where('philrice_station_id', '=', $productionPlan->philrice_station_id)
				->get();

				// get seed source in growapp table
				if ($transplanting && $sowing) {
					foreach ($serials as $sn) {
						$growapp = SGForms::select('seedlotno', 'controlno', 'seedsource')
						->where([
							['variety', '=', $productionPlan->variety],
							['seedclass', '=', $productionPlan->seed_class],
							['dateplanted', '=', date('Y-m-d', strtotime($transplanting->datetime_start))],
							['sowingdate', '=', date('Y-m-d', strtotime($sowing->timestamp))],
							['serial_number', '=', $sn->serial_number]
						])
						->first();

						if ($growapp) {
							$source = $growapp->seedsource;
							$source_lotno = $growapp->seedlotno;
							$source_lab = $growapp->controlno;
							break;
						}
					}
				}
			}

			$plantingReport[] = array(
				'station' => $station->station_code,
				'variety' => $productionPlan->variety,
				'seedClass' => $productionPlan->seed_class,
				// 'ecosystem' => ($ecosystem) ? $ecosystem : "NO DATA",
				'source' => $source,
				'source_lot' => $source_lotno,
				'source_lab' => $source_lab,
				'maturity' => ($maturity) ? $maturity : "NO DATA",
				'area' => $totalArea,
				'sowingDate' => ($sowing) ? date('M d, Y', strtotime($sowing->timestamp)) : 'NO DATA',
				'transplantingDate' => ($transplanting) ? date('M d, Y', strtotime($transplanting->datetime_start)) : 'NO DATA',
				// 'harvestingDate' => ($harvesting) ? date('Y-M-d', strtotime($harvesting->date_start)) : ''
				'harvestingDate' => $harvestingDate,
				'remarks' => $productionPlan->remarks
			);
		}

		ksort($plantingReport);

		echo json_encode($plantingReport);
	}

	public function export(Request $request) {
		$stationID = $request->stationID;
		$year = $request->year;
		$sem = $request->sem;
		$seedClass = $request->seedClass;

		// Query the production plans
		$productionPlans = $this->productionPlan($stationID, $year, $sem, $seedClass);

		$productionPlans = collect($productionPlans);

		// Filter production plans results to nucleus
		$breeder = $productionPlans->filter(function($value, $key) {
			if ($value['seed_class'] == "Nucleus") {
				return $value;
			}
		});

		// Filter production plans results to BS
		$foundation = $productionPlans->filter(function($value, $key) {
			if ($value['seed_class'] == "Breeder") {
				return $value;
			}
		});

		// Filter production plans results to FS
		$registered = $productionPlans->filter(function($value, $key) {
			if ($value['seed_class'] == "Foundation") {
				return $value;
			}
		});

		$breederPlantingReport;
		if ($breeder) {
			$breederPlantingReport = $this->mapProductionPlan($breeder);
		}

		$foundationPlantingReport;
		if ($foundation) {
			$foundationPlantingReport = $this->mapProductionPlan($foundation);
		}

		$registeredPlantingReport;
		if ($registered) {
			$registeredPlantingReport = $this->mapProductionPlan($registered);
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
			Excel::create('Planting Report', function($excel) use (
				$breederPlantingReport,
				$foundationPlantingReport,
				$registeredPlantingReport,
				$year,
				$sem,
				$station,
				$prepared,
				$certified,
				$approved
			) {
				// Create sheet
				$excel->sheet('Sheet 1', function($sheet) use (
					$breederPlantingReport,
					$foundationPlantingReport,
					$registeredPlantingReport,
					$year,
					$sem,
					$station,
					$prepared,
					$certified,
					$approved
				) {
					// Load view for the sheet
					$sheet->loadView('reports.planting_report.excel', array(
						'breederPlantingReport' => $breederPlantingReport,
						'foundationPlantingReport' => $foundationPlantingReport,
						'registeredPlantingReport' => $registeredPlantingReport,
						'year' => $year,
						'sem' => $sem,
						'station' => $station,
						'prepared' => $prepared,
						'certified' => $certified,
						'approved' => $approved
					))
					->setColumnFormat(array(
						'E' => '0.000' // Format area column
					))
					->protect('RS1S_@dm1n1str4t0r');
				});
			})
			->download('xls');
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function exportToPDF(Request $request) {
		$stationID = $request->stationID;
		$year = $request->year;
		$sem = $request->sem;
		$seedClass = $request->seedClass;

		// Query the production plans
		$productionPlans = $this->productionPlan($stationID, $year, $sem, $seedClass);

		$productionPlans = collect($productionPlans);

		// Filter production plans results to nucleus
		$breeder = $productionPlans->filter(function($value, $key) {
			if ($value['seed_class'] == "Nucleus") {
				return $value;
			}
		});

		// Filter production plans results to BS
		$foundation = $productionPlans->filter(function($value, $key) {
			if ($value['seed_class'] == "Breeder") {
				return $value;
			}
		});

		// Filter production plans results to FS
		$registered = $productionPlans->filter(function($value, $key) {
			if ($value['seed_class'] == "Foundation") {
				return $value;
			}
		});

		$breederPlantingReport;
		if ($breeder) {
			$breederPlantingReport = $this->mapProductionPlan($breeder);
		}

		$foundationPlantingReport;
		if ($foundation) {
			$foundationPlantingReport = $this->mapProductionPlan($foundation);
		}

		$registeredPlantingReport;
		if ($registered) {
			$registeredPlantingReport = $this->mapProductionPlan($registered);
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
			$fileName = "Planting Report.pdf";
			$pdf = PDF::loadView('reports.planting_report.pdf', compact(['breederPlantingReport', 'foundationPlantingReport', 'registeredPlantingReport', 'year', 'sem', 'station', 'prepared', 'certified', 'approved']));
			$pdf->setPaper($custom_paper, 'landscape');
			return $pdf->stream();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function mapProductionPlan($productionPlan) {
		$plantingReport = $productionPlan->map(function($productionPlan) {
			$productionPlanID = $productionPlan->production_plan_id;

			$productionPlotCode = ProductionPlotCode::select('production_plot_code')->where('production_plan_id', '=', $productionPlanID)->first();
			$productionPlotCode = $productionPlotCode->production_plot_code;

			// Query maturity and ecosystem of the selected variety in the production plan
			$variety = Seed::select('maturity', 'ecosystem')
			->where('variety', '=', $productionPlan->variety)
			->where('variety_name', 'NOT LIKE', '%DWSR%')
			->first();

			// Check if there is changes to actual plots used
			$hasActual = ActualProductionPlot::select('*')
			->where('production_plan_id', '=', $productionPlanID)
			->get()
			->count();

			if ($hasActual > 0) {
				// Get actual plots used
				$productionPlots = ActualProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();
			} else {
				// Get planned plots
				$productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();
			}

			// Calculate the total area of the selected lots
			$totalArea = 0;
			foreach ($productionPlots as $productionPlot) {
				// Query the area of the plot
				$plot = Plot::select('area')->where('plot_id', '=', $productionPlot->plot_id)->first();

				$totalArea += $plot->area;
			}

			// Query the date of sowing
			$sowing = SeedlingManagement::select('timestamp')
			->where('production_plot_code', '=', $productionPlotCode)
			->where('activity', '=', 'Seed Sowing')
			->first();

			// Query the date of transplanting
			$transplanting = CropEstablishment::select('datetime_start')
			->where('production_plot_code', '=', $productionPlotCode)
			->where('activity', '=', 'Transplanting')
			->first();

			// Query the expected date of harvesting
			$harvesting = PlannedActivity::select('date_start')->where('activity_id', '=', 23)->where('production_plan_id', '=', $productionPlanID)->first();

			// Compute expected harvesting date based on actual date of sowing
			if ($sowing) {
				$maturity = ($variety) ? $variety->maturity : "";
				$harvestingDate = date('M d, Y', strtotime($sowing->timestamp . ' + ' . $maturity . ' days'));
			} else {
				$harvestingDate = ($harvesting) ? date('M d, Y', strtotime($harvesting->date_start)) : 'NO DATA';
			}

			// Station where planting plan was created
			$station = Station::where('philrice_station_id', '=', $productionPlan->philrice_station_id)->first();

			// Get source lot no of seeds planted
			// Update this query if seed production app implemented new mode of saving to db
			$source_lot = SeedCertification::select('seedlot_no', 'seed_source', 'control_no')
			->where('production_plot_code', '=', $productionPlotCode)
			->first();

			$source = "NO DATA";
			$source_lotno = "NO DATA";
			$source_lab = "NO DATA";

			if ($source_lot) {
				$source = $source_lot->seed_source;
				$source_lotno = $source_lot->seedlot_no;
				$source_lab = $source_lot->control_no;
			} else {
				// get serial numbers of station
				$serials = StationSerialNumber::select('serial_number')
				->where('philrice_station_id', '=', $productionPlan->philrice_station_id)
				->get();

				// get seed source in growapp table
				if ($transplanting && $sowing) {
					foreach ($serials as $sn) {
						$growapp = SGForms::select('seedlotno', 'controlno', 'seedsource')
						->where([
							['variety', '=', $productionPlan->variety],
							['seedclass', '=', $productionPlan->seed_class],
							['dateplanted', '=', date('Y-m-d', strtotime($transplanting->datetime_start))],
							['sowingdate', '=', date('Y-m-d', strtotime($sowing->timestamp))],
							['serial_number', '=', $sn->serial_number]
						])
						->first();

						if ($growapp) {
							$source = $growapp->seedsource;
							$source_lotno = $growapp->seedlotno;
							$source_lab = $growapp->controlno;
							break;
						}
					}
				}
			}

			return array(
				'station' => $station->station_code,
				'variety' => $productionPlan->variety,
				'seedClass' => $productionPlan->seed_class,
				// 'ecosystem' => ($variety->ecosystem != "") ? $variety->ecosystem : "NO DATA",
				'source' => $source,
				'source_lot' => $source_lotno,
				'source_lab' => $source_lab,
				'maturity' => ($variety->maturity != 0) ? $variety->maturity : "NO DATA",
				'area' => floatval($totalArea),
				'sowingDate' => ($sowing) ? date('M d, Y', strtotime($sowing->timestamp)) : 'NO DATA',
				'transplantingDate' => ($transplanting) ? date('M d, Y', strtotime($transplanting->datetime_start)) : 'NO DATA',
				// 'harvestingDate' => ($harvesting) ? date('Y-M-d', strtotime($harvesting->date_start)) : ''
				'harvestingDate' => $harvestingDate,
				'remarks' => $productionPlan->remarks
			);
		});

		return $plantingReport;
	}

	public function productionPlan($stationID, $year, $sem, $seedClass) {
		// Query the production plans
		$productionPlans = ProductionPlan::select('production_plan_id', 'variety', 'seed_class', 'philrice_station_id', 'remarks')
		->where([
			['year', '=', $year],
			['sem', '=', $sem],
			['is_finalized', '=', 1],
			['is_deleted', '=', 0]
		])
		->when($stationID != 0, function($query) use ($stationID) {
			return $query->where('philrice_station_id', '=', $stationID);
		})
		->when($seedClass != "All", function($query) use($seedClass) {
			return $query->where('seed_class', '=', $seedClass);
		})
		->orderBy('philrice_station_id', 'ASC')
		->orderBy('variety', 'ASC')
		->get();

		return $productionPlans;
	}

	// StationID of logged in user
	public function userStationID() {
		$userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
		$stationID = $userAffiliation->station->philrice_station_id;

		return $stationID;
	}

}
