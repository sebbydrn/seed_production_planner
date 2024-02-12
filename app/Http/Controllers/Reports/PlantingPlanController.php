<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductionPlan;
use App\Station;
use App\Seed;
use App\ProductionPlot;
use App\Plot;
use App\PlannedActivity;
use App\User;
use App\AffiliationUser;
use App\Signatory;
use Excel, Auth, PDF;

class PlantingPlanController extends Controller {

	public function __construct() {
		$this->middleware('permission:view_planting_plans')->only(['index']);
	}

	public function index() {
		$role = $this->role();

		// PhilRice stations
		$stations = Station::select('philrice_station_id', 'name')->orderBy('philrice_station_id', 'ASC')->get();

		// Production plan years
		$years = ProductionPlan::select('year')->groupBy('year')->get();

		// Get station code of user's station
		$philriceStationID = $this->userStationID();

		return view('reports.planting_plan.index', compact(['role', 'years', 'stations', 'philriceStationID']));
	}

	public function generate(Request $request) {
		$stationID = $request->stationID;
		$year = $request->year;
		$sem = $request->sem;
		$seedClass = $request->seedClass;
		$plantingPlan = array();

		// Query the production plans
		$productionPlans = $this->productionPlan($stationID, $year, $sem, $seedClass);

		foreach ($productionPlans as $productionPlan) {
			$productionPlanID = $productionPlan->production_plan_id;

			// Query maturity and ecosystem of the selected variety in the production plan
			$variety = Seed::select('maturity', 'ecosystem')
			->where('variety', '=', $productionPlan->variety)
			->where('variety_name', 'NOT LIKE', '%DWSR%')
			->first();

			// Query the lots selected in the production plan
			$productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();

			// Calculate the total area of the selected lots
			$totalArea = 0;
			foreach ($productionPlots as $productionPlot) {
				// Query the area of the plot
				$plot = Plot::select('area')->where('plot_id', '=', $productionPlot->plot_id)->first();

				$totalArea += $plot->area;
			}

			// Query the expected date of sowing
			$seedSowing = PlannedActivity::select('date_start')->where('activity_id', '=', 5)->where('production_plan_id', '=', $productionPlanID)->first();

			// Query the expected date of transplanting
			$transplanting = PlannedActivity::select('date_start')->where('activity_id', '=', 13)->where('production_plan_id', '=', $productionPlanID)->first();

			// Query the expected date of harvesting
			$harvesting = PlannedActivity::select('date_start')->where('activity_id', '=', 23)->where('production_plan_id', '=', $productionPlanID)->first();

			// Station where planting plan was created
			$station = Station::where('philrice_station_id', '=', $productionPlan->philrice_station_id)->first();

			$plantingPlan[] = array(
				'station' => $station->station_code,
				'variety' => $productionPlan->variety,
				'seedClass' => $productionPlan->seed_class,
				'ecosystem' => ($variety->ecosystem) ? $variety->ecosystem : "NO DATA",
				'maturity' => ($variety->maturity) ? $variety->maturity : "NO DATA",
				'area' => $totalArea,
				'sowingDate' => date('M d, Y', strtotime($seedSowing->date_start)),
				'transplantingDate' => date('M d, Y', strtotime($transplanting->date_start)),
				'harvestingDate' => date('M d, Y', strtotime($harvesting->date_start)),
				'remarks' => $productionPlan->remarks
			);
		}

		echo json_encode($plantingPlan);
	}

	public function export(Request $request) {
		$stationID = $request->stationID;
		$year = $request->year;
		$sem = $request->sem;
		$seedClass = $request->seedClass;

		// Query the production plans
		$productionPlans = $this->productionPlan($stationID, $year, $sem, $seedClass);

		$productionPlans = collect($productionPlans);

		// filter production plans results to nucleus
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

		$breederPlantingPlan;
		if ($breeder) {
			$breederPlantingPlan = $this->mapProductionPlan($breeder);
		}

		$foundationPlantingPlan;
		if ($foundation) {
			$foundationPlantingPlan = $this->mapProductionPlan($foundation);
		}

		$registeredPlantingPlan;
		if ($registered) {
			$registeredPlantingPlan = $this->mapProductionPlan($registered);
		}

		// Name of philrice station
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
			Excel::create('Planting Plan', function($excel) use (
				$breederPlantingPlan,
				$foundationPlantingPlan,
				$registeredPlantingPlan,
				$year,
				$sem,
				$station,
				$prepared,
				$certified,
				$approved
			) {
				// Create sheet
				$excel->sheet('Sheet 1', function($sheet) use (
					$breederPlantingPlan,
					$foundationPlantingPlan,
					$registeredPlantingPlan,
					$year,
					$sem,
					$station,
					$prepared,
					$certified,
					$approved
				) {
					// Load view for the sheet
					$sheet->loadView('reports.planting_plan.excel', array(
						'breederPlantingPlan' => $breederPlantingPlan,
						'foundationPlantingPlan' => $foundationPlantingPlan,
						'registeredPlantingPlan' => $registeredPlantingPlan,
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
					->protect('RS1S_@dm1n1str4t0r');;
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

		// filter production plans results to nucleus
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

		$breederPlantingPlan;
		if ($breeder) {
			$breederPlantingPlan = $this->mapProductionPlan($breeder);
		}

		$foundationPlantingPlan;
		if ($foundation) {
			$foundationPlantingPlan = $this->mapProductionPlan($foundation);
		}

		$registeredPlantingPlan;
		if ($registered) {
			$registeredPlantingPlan = $this->mapProductionPlan($registered);
		}

		// Name of philrice station
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
			$fileName = "Planting Plan.pdf";
			$pdf = PDF::loadView('reports.planting_plan.pdf', compact(['breederPlantingPlan', 'foundationPlantingPlan', 'registeredPlantingPlan', 'year', 'sem', 'station', 'prepared', 'certified', 'approved']));
			$pdf->setPaper($custom_paper, 'landscape');
			return $pdf->stream();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function mapProductionPlan($productionPlan) {
		$plantingPlan = $productionPlan->map(function($productionPlan) {
			$productionPlanID = $productionPlan->production_plan_id;

			// Query maturity and ecosystem of the selected variety in the production plan
			$variety = Seed::select('maturity', 'ecosystem')
			->where('variety', '=', $productionPlan->variety)
			->where('variety_name', 'NOT LIKE', '%DWSR%')
			->first();

			// Query the lots selected in the production plan
			$productionPlots = ProductionPlot::select('plot_id')->where('production_plan_id', '=', $productionPlanID)->get();

			// Calculate the total area of the selected lots
			$totalArea = 0;
			foreach ($productionPlots as $productionPlot) {
				// Query the area of the plot
				$plot = Plot::select('area')->where('plot_id', '=', $productionPlot->plot_id)->first();

				$totalArea += $plot->area;
			}

			// Query the expected date of sowing
			$seedSowing = PlannedActivity::select('date_start')->where('activity_id', '=', 5)->where('production_plan_id', '=', $productionPlanID)->first();

			// Query the expected date of transplanting
			$transplanting = PlannedActivity::select('date_start')->where('activity_id', '=', 13)->where('production_plan_id', '=', $productionPlanID)->first();

			// Query the expected date of harvesting
			$harvesting = PlannedActivity::select('date_start')->where('activity_id', '=', 23)->where('production_plan_id', '=', $productionPlanID)->first();

			// Station where planting plan was created
			$station = Station::where('philrice_station_id', '=', $productionPlan->philrice_station_id)->first();

			return array(
				'station' => $station->station_code,
				'variety' => $productionPlan->variety,
				'seedClass' => $productionPlan->seed_class,
				'ecosystem' => ($variety->ecosystem) ? $variety->ecosystem : "NO DATA",
				'maturity' => ($variety->maturity) ? $variety->maturity : "NO DATA",
				'area' => $totalArea,
				'sowingDate' => date('M d, Y', strtotime($seedSowing->date_start)),
				'transplantingDate' => date('M d, Y', strtotime($transplanting->date_start)),
				'harvestingDate' => date('M d, Y', strtotime($harvesting->date_start)),
				'remarks' => $productionPlan->remarks
			);
		});

		return $plantingPlan;
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
