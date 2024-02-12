<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Station;
use App\TargetVarieties;
use App\TargetVarietyActivities;
use App\AffiliationUser;
use App\Signatory;
use App\ProdCostSched\ProductionCostSchedule;
use App\ProdCostSched\ProductionCostScheduleActivities;
use App\ProdCostSched\CostCompoContracts;
use App\ProdCostSched\CostCompoDrying;
use App\ProdCostSched\CostCompoFertilizers;
use App\ProdCostSched\CostCompoFieldSupp;
use App\ProdCostSched\CostCompoFuel;
use App\ProdCostSched\CostCompoHarvesting;
use App\ProdCostSched\CostCompoIrrig;
use App\ProdCostSched\CostCompoLandPrep;
use App\ProdCostSched\CostCompoLandRental;
use App\ProdCostSched\CostCompoPlantingMat;
use App\ProdCostSched\CostCompoProdContract;
use App\ProdCostSched\CostCompoSeedLab;
use App\ProdCostSched\CostCompoSeedPull;
use App\ProdCostSched\CostCompoSeedCleaning;
use App\ProdCostSched\CostCompoContractPosition;
use App\ProdCostSched\CostCompoSeedingRate;
use Auth, DB, Entrust, Validator, PDF, Excel;
use Yajra\Datatables\Datatables;

class ProductionCostScheduleController extends Controller
{
    public function index() {
        $role = $this->role();

        return view('production_cost_schedule.index')->with(compact('role'));
    }

    public function datatable(Request $request) {
        $production_cost_schedule = ProductionCostSchedule::select('production_cost_id', 'philrice_station_id', 'year', 'is_approved');

        if (isset($request->philriceStation)) {
            $philriceStationID = $request->philriceStation;

            if ($philriceStationID != 0) {
                if ($philriceStationID == 1) {
                    $production_cost_schedule = $production_cost_schedule;
                } else {
                    $production_cost_schedule = $production_cost_schedule->where('philrice_station_id', '=', $philriceStationID);
                }
            }
        } else {
            if (Entrust::can('view_all_prod_cost_sched')) {
                $production_cost_schedule = $production_cost_schedule;
            } else {
                // Get station code of user's station
                $philriceStationID = $this->userStationID();
                $production_cost_schedule = $production_cost_schedule->where('philrice_station_id', '=', $philriceStationID);
            }
        }

        $production_cost_schedule = $production_cost_schedule->orderBy('philrice_station_id', 'asc')
        ->orderBy('year', 'desc')
        ->get();

        $data = collect($production_cost_schedule);

        return Datatables::of($data)
            ->addColumn('station', function($data) {
                $philrice_station_id = $data->philrice_station_id;

                $station = Station::select('name')->where('philrice_station_id', '=', $philrice_station_id)->first();

                return $station->name;
            })
            ->addColumn('year', function($data) {
                return $data->year;
            })
            ->addColumn('status', function($data) {
                if ($data->is_approved == 0)
                    return "<button class='btn btn-sm btn-warning active'>Pending approval</button>";
                if ($data->is_approved == 1)
                    return "<button class='btn btn-sm btn-success active'>Approved</button>";
                if ($data->is_approved == 2)
                    return "<button class='btn btn-sm btn-success active'>Reviewed</button>";
                if ($data->is_approved == 3)
                    return "<button class='btn btn-sm btn-danger active'>For Revision</button>";
            })
            ->addColumn('actions', function($data) {
                $actions = '<a href="'.route('production_cost_schedule.show', ['id' => $data->production_cost_id]).'" class="btn btn-sm btn-info mb-xs" title="View Production Cost Schedule"><i class="fa fa-eye"></i></a>';

                if (Entrust::can('manage_production_cost_schedule')) {
                    if ($data->is_approved === 0 &&  Entrust::hasRole('accountant')) {
                        $actions .= '<a href="'.route('production_cost_schedule.evaluate', ['id' => $data->production_cost_id]).'" class="btn btn-sm btn-primary ml-xs mb-xs" title="Evaluate Production Cost Schedule"><i class="fa fa-pencil-square-o"></i></a>';
                    } if ($data->is_approved === 2 && (Entrust::hasRole('bdd_head') || Entrust::hasRole('bdd_coordinator'))) {
                        $actions .= '<a href="'.route('production_cost_schedule.evaluate', ['id' => $data->production_cost_id]).'" class="btn btn-sm btn-primary ml-xs mb-xs" title="Evaluate Production Cost Schedule"><i class="fa fa-pencil-square-o"></i></a>';
                    }
                }

                if (Entrust::can('edit_production_cost_schedule')) {
                    if ($data->is_approved == 0 || $data->is_approved == 3)
                        $actions .= '<a href="'.route('production_cost_schedule.edit', ['id' => $data->production_cost_id]).'" class="btn btn-sm btn-warning ml-xs mb-xs" title="Edit Production Cost Schedule"><i class="fa fa-edit"></i></a>';
                }

                if (Entrust::can('delete_production_cost_schedule')) {
                    if ($data->is_approved == 0) {
                        $actions .= '<a href="#" class="btn btn-sm btn-danger ml-xs mb-xs" title="Delete Production Cost Schedule" onclick="delete_schedule('.$data->production_cost_id.')"><i class="fa fa-trash-o"></i></a>';
                    }
                }

                // $actions .= '<a href="#" class="btn btn-sm btn-danger ml-xs mb-xs" title="Generate PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                // $actions .= '<a href="#" class="btn btn-sm btn-success ml-xs mb-xs" title="Generate Excel" target="_blank"><i class="fa fa-file-excel-o"></i></a>';

                return $actions;
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function create() {
        $role = $this->role();

        return view('production_cost_schedule.create')->with(compact('role'));
    }

    public function store(Request $request) {
        $data = $request->data;

        DB::beginTransaction();
        try {
            // save production cost schedule
            $production_cost_schedule = new ProductionCostSchedule();
            $production_cost_schedule->total_s1 = str_replace(",", "", $data['total_s1']);
            $production_cost_schedule->total_s2 = str_replace(",", "", $data['total_s2']);
            $production_cost_schedule->remarks = $data['remarks'];
            $production_cost_schedule->philrice_station_id = $this->userStationID();
            $production_cost_schedule->year = $data['year'];
            $production_cost_schedule->area_station = str_replace(",", "", $data['area_station']);
            $production_cost_schedule->area_outside = str_replace(",", "", $data['area_outside']);
            $production_cost_schedule->area_contract = str_replace(",", "", $data['area_contract']);
            $production_cost_schedule->area1_s1 = str_replace(",", "", $data['area1_s1']);
            $production_cost_schedule->area1_s2 = str_replace(",", "", $data['area1_s2']);
            $production_cost_schedule->area2_s1 = str_replace(",", "", $data['area2_s1']);
            $production_cost_schedule->area2_s2 = str_replace(",", "", $data['area2_s2']);
            $production_cost_schedule->volume_clean1_s1 = str_replace(",", "", $data['clean_seed1_s1']);
            $production_cost_schedule->volume_clean1_s2 = str_replace(",", "", $data['clean_seed1_s2']);
            $production_cost_schedule->volume_clean2_s1 = str_replace(",", "", $data['clean_seed2_s1']);
            $production_cost_schedule->volume_clean2_s2 = str_replace(",", "", $data['clean_seed2_s2']);
            $production_cost_schedule->production_cost_kilo_s1 = str_replace(",", "", $data['production_cost_kilo_s1']);
            $production_cost_schedule->production_cost_kilo_s2 = str_replace(",", "", $data['production_cost_kilo_s2']);
            $production_cost_schedule->production_cost_ha_s1 = str_replace(",", "", $data['production_cost_ha_s1']);
            $production_cost_schedule->production_cost_ha_s2 = str_replace(",", "", $data['production_cost_ha_s2']);
            $production_cost_schedule->seed_production_type = $data['seed_production_type'];
            $production_cost_schedule->save();

            $production_cost_id = $production_cost_schedule->production_cost_id; // production cost id

            // save land preparation component
            foreach ($data['land_preparation'] as $item) {
                $land_preparation = new CostCompoLandPrep();
                $land_preparation->production_cost_id = $production_cost_id;
                $land_preparation->sem = $item['sem'];
                $land_preparation->rotovate_area = $item['rotovate_area'];
                $land_preparation->rotovate_cost = $item['rotovate_cost'];
                $land_preparation->rotovate_amount = $item['rotovate_amount'];
                $land_preparation->levelling_area = $item['levelling_area'];
                $land_preparation->levelling_cost = $item['levelling_cost'];
                $land_preparation->levelling_amount = $item['levelling_amount'];
                $land_preparation->sub_total = $item['sub_total'];
                $land_preparation->save();
            }

            // save seed pulling component
            foreach ($data['seed_pulling'] as $item) {
                $seed_pulling = new CostCompoSeedPull();
                $seed_pulling->production_cost_id = $production_cost_id;
                $seed_pulling->sem = $item['sem'];
                $seed_pulling->pulling_area = $item['pulling_area'];
                $seed_pulling->pulling_cost = $item['pulling_cost'];
                $seed_pulling->pulling_amount = $item['pulling_amount'];
                $seed_pulling->replanting_labor_no = $item['replanting_labor_no'];
                $seed_pulling->replanting_labor_area = $item['replanting_labor_area'];
                $seed_pulling->replanting_labor_cost = $item['replanting_labor_cost'];
                $seed_pulling->replanting_labor_amount = $item['replanting_labor_amount'];
                $seed_pulling->save();
            }

            // save fertilizers component
            foreach ($data['fertilizers'] as $item) {
                $fertilizer = new CostCompoFertilizers();
                $fertilizer->production_cost_id = $production_cost_id;
                $fertilizer->sem = $item['sem'];
                $fertilizer->area = $item['area'];
                $fertilizer->cost = $item['cost'];
                $fertilizer->amount = $item['amount'];
                $fertilizer->save();
            }

            // save harvesting component
            foreach ($data['harvesting'] as $item) {
                $harvesting = new CostCompoHarvesting();
                $harvesting->production_cost_id = $production_cost_id;
                $harvesting->sem = $item['sem'];
                $harvesting->manual_area = $item['manual_area'];
                $harvesting->manual_cost = $item['manual_cost'];
                $harvesting->manual_amount = $item['manual_amount'];
                $harvesting->mechanical_area = $item['mechanical_area'];
                $harvesting->mechanical_cost = $item['mechanical_cost'];
                $harvesting->mechanical_amount = $item['mechanical_amount'];
                $harvesting->hauling_ave_bags = $item['hauling_ave_bags'];
                $harvesting->hauling_bags_no = $item['hauling_bags_no'];
                $harvesting->hauling_cost = $item['hauling_cost'];
                $harvesting->hauling_amount = $item['hauling_amount'];
                $harvesting->threshing_area = $item['threshing_area'];
                $harvesting->threshing_cost = $item['threshing_cost'];
                $harvesting->threshing_amount = $item['threshing_amount'];
                $harvesting->towing_area = $item['towing_area'];
                $harvesting->towing_cost = $item['towing_cost'];
                $harvesting->towing_amount = $item['towing_amount'];
                $harvesting->scatter_area = $item['scatter_area'];
                $harvesting->scatter_cost = $item['scatter_cost'];
                $harvesting->scatter_amount = $item['scatter_amount'];
                $harvesting->sub_total = $item['sub_total'];
                $harvesting->save();
            }

            // save drying component
            foreach ($data['drying'] as $item) {
                $drying = new CostCompoDrying();
                $drying->production_cost_id = $production_cost_id;
                $drying->sem = $item['sem'];
                $drying->drying_bags_no = $item['drying_bags_no'];
                $drying->drying_cost = $item['drying_cost'];
                $drying->drying_amount = $item['drying_amount'];
                $drying->emergency_labor_no = $item['emergency_labor_no'];
                $drying->emergency_labor_days = $item['emergency_labor_days'];
                $drying->emergency_labor_cost = $item['emergency_labor_cost'];
                $drying->emergency_labor_amount = $item['emergency_labor_amount'];
                $drying->sub_total = $item['sub_total'];
                $drying->save();
            }

            // save seed cleaning component
            foreach ($data['seed_cleaning'] as $item) {
                $seed_cleaning = new CostCompoSeedCleaning();
                $seed_cleaning->production_cost_id = $production_cost_id;
                $seed_cleaning->sem = $item['sem'];
                $seed_cleaning->ave_bags = $item['ave_bags'];
                $seed_cleaning->bags_no = $item['bags_no'];
                $seed_cleaning->cost = $item['cost'];
                $seed_cleaning->amount = $item['amount'];
                $seed_cleaning->save();
            }
            
            // save service contractors component
            foreach ($data['service_contracts'] as $item) {
                $service_contract = new CostCompoContracts();
                $service_contract->production_cost_id = $production_cost_id;
                $service_contract->sem = $item['sem'];
                $service_contract->months_no = $item['months_no'];
                $service_contract->sub_total = $item['sub_total'];
                $service_contract->save();

                $contract_id = $service_contract->contract_id;

                $positions = ($item['sem'] == 1) ? $data['service_contract_positions'][0] : $data['service_contract_positions'][1];

                foreach ($positions as $pos) {
                    $position = new CostCompoContractPosition();
                    $position->contract_id = $contract_id;
                    $position->contract_no = $pos['contract_no'];
                    $position->position = $pos['position'];
                    $position->monthly_rate = $pos['monthly_rate'];
                    $position->monthly_cost = $pos['monthly_cost'];
                    $position->amount = $pos['amount'];
                    $position->save();
                }
            }

            // save planting materials
            foreach ($data['planting_materials'] as $item) {
                $planting_material = new CostCompoPlantingMat();
                $planting_material->production_cost_id = $production_cost_id;
                $planting_material->sem = $item['sem'];
                $planting_material->area1 = $item['area1'];
                $planting_material->area2 = $item['area2'];
                $planting_material->area1_seed_quantity = $item['area1_seed_quantity'];
                $planting_material->area1_cost = $item['area1_cost'];
                $planting_material->area1_amount = $item['area1_amount'];
                $planting_material->area2_seed_quantity = $item['area2_seed_quantity'];
                $planting_material->area2_cost = $item['area2_cost'];
                $planting_material->area2_amount = $item['area2_amount'];
                $planting_material->sub_total = $item['sub_total'];
                $planting_material->save();
            }

            // save planting material - seeding rate
            $seeding_rate = new CostCompoSeedingRate();
            $seeding_rate->production_cost_id = $production_cost_id;
            $seeding_rate->seeding_rate = $data['seeding_rate'];
            $seeding_rate->save();

            // save field supplies component
            foreach ($data['field_supplies'] as $item) {
                $field_supplies = new CostCompoFieldSupp();
                $field_supplies->production_cost_id = $production_cost_id;
                $field_supplies->sem = $item['sem'];
                $field_supplies->sack1_no = $item['sack1_no'];
                $field_supplies->sack1_cost = $item['sack1_cost'];
                $field_supplies->sack1_amount = $item['sack1_amount'];
                $field_supplies->sack2_no = $item['sack2_no'];
                $field_supplies->sack2_cost = $item['sack2_cost'];
                $field_supplies->sack2_amount = $item['sack2_amount'];
                $field_supplies->sack3_no = $item['sack3_no'];
                $field_supplies->sack3_cost = $item['sack3_cost'];
                $field_supplies->sack3_amount = $item['sack3_amount'];
                $field_supplies->other_supplies_amount = $item['other_supplies_amount'];
                $field_supplies->sub_total = $item['sub_total'];
                $field_supplies->save();
            }

            // save fuel component
            foreach ($data['fuel'] as $item) {
                $fuel = new CostCompoFuel();
                $fuel->production_cost_id = $production_cost_id;
                $fuel->sem = $item['sem'];
                $fuel->diesel_liters = $item['diesel_liters'];
                $fuel->diesel_cost = $item['diesel_cost'];
                $fuel->diesel_amount = $item['diesel_amount'];
                $fuel->gas_liters = $item['gas_liters'];
                $fuel->gas_cost = $item['gas_cost'];
                $fuel->gas_amount = $item['gas_amount'];
                $fuel->kerosene_liters = $item['kerosene_liters'];
                $fuel->kerosene_cost = $item['kerosene_cost'];
                $fuel->kerosene_amount = $item['kerosene_amount'];
                $fuel->sub_total = $item['sub_total'];
                $fuel->save();
            }

            // save irrigation fees component
            foreach ($data['irrigation'] as $item) {
                $irrigation = new CostCompoIrrig();
                $irrigation->production_cost_id = $production_cost_id;
                $irrigation->sem = $item['sem'];
                $irrigation->area = $item['area'];
                $irrigation->cost = $item['cost'];
                $irrigation->amount = $item['amount'];
                $irrigation->save();
            }

            // save seed laboratory fees component
            $lab_fee = new CostCompoSeedLab();
            $lab_fee->production_cost_id = $production_cost_id;
            $lab_fee->amount_s1 = $data['seed_lab_amount_s1'];
            $lab_fee->amount_s2 = $data['seed_lab_amount_s2'];
            $lab_fee->save();

            // save land rental component
            foreach ($data['land_rental'] as $item) {
                $land_rent = new CostCompoLandRental();
                $land_rent->production_cost_id = $production_cost_id;
                $land_rent->sem = $item['sem'];
                $land_rent->area = $item['area'];
                $land_rent->cost = $item['cost'];
                $land_rent->amount = $item['amount'];
                $land_rent->save();
            }
            
            // save production contracting component
            foreach ($data['production_contracting'] as $item) {
                $contract = new CostCompoProdContract();
                $contract->production_cost_id = $production_cost_id;
                $contract->sem = $item['sem'];
                $contract->seed_volume = $item['seed_volume'];
                $contract->buying_price = $item['buying_price'];
                $contract->amount = $item['amount'];
                $contract->save();
            }

            // save logs
            $activity = new ProductionCostScheduleActivities;
            $activity->production_cost_id = $production_cost_id;
            $activity->user_id = Auth::user()->user_id;
            $activity->browser = $this->browser();
            $activity->activity = "Added production cost schedule data";
            $activity->device = $this->device();
            $activity->ip_env_address = $request->ip();
            $activity->ip_server_address = $request->server('SERVER_ADDR');
            $activity->OS = $this->operating_system();
            $activity->save();

            DB::commit();
            echo json_encode("success");
        } catch (Exception $e) {
            DB::rollback();
            echo json_encode($e->getMessage());
        }
    }

    public function show($id) {
        $role = $this->role();

        // production cost schedule
        $production_cost_schedule = ProductionCostSchedule::find($id);

        $production_cost_id = $production_cost_schedule->production_cost_id; // production cost id

        // land preparation component
        $land_preparation = CostCompoLandPrep::where('production_cost_id', $production_cost_id)->get();

        // seed pulling component
        $seed_pulling = CostCompoSeedPull::where('production_cost_id', $production_cost_id)->get();

        // fertilizers component
        $fertilizers = CostCompoFertilizers::where('production_cost_id', $production_cost_id)->get();

        // harvesting component
        $harvesting = CostCompoHarvesting::where('production_cost_id', $production_cost_id)->get();

        // drying component
        $drying = CostCompoDrying::where('production_cost_id', $production_cost_id)->get();

        // seed cleaning component
        $seed_cleaning = CostCompoSeedCleaning::where('production_cost_id', $production_cost_id)->get();

        // service contracts component
        $service_contracts = CostCompoContracts::where('production_cost_id', $production_cost_id)
        ->with('positions')
        ->get();

        // planting materials component
        $planting_materials = CostCompoPlantingMat::where('production_cost_id', $production_cost_id)->get();

        // field supplies component
        $field_supplies = CostCompoFieldSupp::where('production_cost_id', $production_cost_id)->get();

        // fuel component
        $fuel = CostCompoFuel::where('production_cost_id', $production_cost_id)->get();

        // irrigation fees component
        $irrigation = CostCompoIrrig::where('production_cost_id', $production_cost_id)->get();

        // seed laboratory fees component
        $seed_laboratory = CostCompoSeedLab::where('production_cost_id', $production_cost_id)->first();

        // land rental component
        $land_rental = CostCompoLandRental::where('production_cost_id', $production_cost_id)->get();

        // seed production contracting component
        $production_contracting = CostCompoProdContract::where('production_cost_id', $production_cost_id)->get();

        // seeding rate
        $seeding_rate = CostCompoSeedingRate::where('production_cost_id', $production_cost_id)->first();

        return view('production_cost_schedule.show')->with(compact(
            'role',
            'production_cost_id',
            'production_cost_schedule',
            'land_preparation',
            'seed_pulling',
            'fertilizers',
            'harvesting',
            'drying',
            'seed_cleaning',
            'service_contracts',
            'planting_materials',
            'field_supplies',
            'fuel',
            'irrigation',
            'seed_laboratory',
            'land_rental',
            'production_contracting',
            'seeding_rate'
        ));
    }

    public function edit($id) {
        $role = $this->role();

         // production cost schedule
        $production_cost_schedule = ProductionCostSchedule::find($id);

        $production_cost_id = $production_cost_schedule->production_cost_id; // production cost id

        // land preparation component
        $land_preparation = CostCompoLandPrep::where('production_cost_id', $production_cost_id)->get();

        // seed pulling component
        $seed_pulling = CostCompoSeedPull::where('production_cost_id', $production_cost_id)->get();

        // fertilizers component
        $fertilizers = CostCompoFertilizers::where('production_cost_id', $production_cost_id)->get();

        // harvesting component
        $harvesting = CostCompoHarvesting::where('production_cost_id', $production_cost_id)->get();

        // drying component
        $drying = CostCompoDrying::where('production_cost_id', $production_cost_id)->get();

        // seed cleaning component
        $seed_cleaning = CostCompoSeedCleaning::where('production_cost_id', $production_cost_id)->get();

        // service contracts component
        $service_contracts = CostCompoContracts::where('production_cost_id', $production_cost_id)
        ->with('positions')
        ->get();

        // planting materials component
        $planting_materials = CostCompoPlantingMat::where('production_cost_id', $production_cost_id)->get();

        // field supplies component
        $field_supplies = CostCompoFieldSupp::where('production_cost_id', $production_cost_id)->get();

        // fuel component
        $fuel = CostCompoFuel::where('production_cost_id', $production_cost_id)->get();

        // irrigation fees component
        $irrigation = CostCompoIrrig::where('production_cost_id', $production_cost_id)->get();

        // seed laboratory fees component
        $seed_laboratory = CostCompoSeedLab::where('production_cost_id', $production_cost_id)->first();

        // land rental component
        $land_rental = CostCompoLandRental::where('production_cost_id', $production_cost_id)->get();

        // seed production contracting component
        $production_contracting = CostCompoProdContract::where('production_cost_id', $production_cost_id)->get();

        // seeding rate
        $seeding_rate = CostCompoSeedingRate::where('production_cost_id', $production_cost_id)->first();

        return view('production_cost_schedule.edit')->with(compact(
            'role',
            'production_cost_id',
            'production_cost_schedule',
            'land_preparation',
            'seed_pulling',
            'fertilizers',
            'harvesting',
            'drying',
            'seed_cleaning',
            'service_contracts',
            'planting_materials',
            'field_supplies',
            'fuel',
            'irrigation',
            'seed_laboratory',
            'land_rental',
            'production_contracting',
            'seeding_rate'
        ));
    }

    public function update($id, Request $request) {
        DB::beginTransaction();
        try {
            // update production cost schedule
            $prod_cost_sched = ProductionCostSchedule::where('prod_cost_sched_id', '=', $id)
            ->update([
                'prod_cost_stotal_s1' => $request->prod_cost_stotal_s1,
                'prod_cost_stotal_s2' => $request->prod_cost_stotal_s2,
                'prod_cost_total' => $request->prod_cost_stotal_s1 + $request->prod_cost_stotal_s2,
            ]);

            // save activity of production cost schedule
            $prod_cost_sched_act = new ProductionCostScheduleActivities;
            $prod_cost_sched_act->prod_cost_sched_id = $id;
            $prod_cost_sched_act->user_id = Auth::user()->user_id;
            $prod_cost_sched_act->browser = $this->browser();
            $prod_cost_sched_act->activity = "Updated production cost schedule";
            $prod_cost_sched_act->device = $this->device();
            $prod_cost_sched_act->ip_env_address = $request->ip();
            $prod_cost_sched_act->ip_server_address = $request->server('SERVER_ADDR');
            $prod_cost_sched_act->OS = $this->operating_system();
            $prod_cost_sched_act->save();

            // update cost components
            // land preparation
            // sem 1
            $cost_compo_land_prep = CostCompoLandPrep::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'roto_cost' => $request->roto_cost_s1,
                'level_cost' => $request->level_cost_s1
            ]);

            // sem 2
            $cost_compo_land_prep = CostCompoLandPrep::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'roto_cost' => $request->roto_cost_s1,
                'level_cost' => $request->level_cost_s1
            ]);

            // seed pulling, marking & transplanting
            // sem 1
            $cost_compo_seed_pull = CostCompoSeedPull::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'seed_pull_area' => $request->seed_pull_area_s1,
                'seed_pull_cost' => $request->seed_pull_cost_s1,
                'emergency_labor' => $request->emergency_labor_s1,
                'emergency_labor_area' => $request->emergency_labor_area_s1,
                'emergency_labor_cost' => $request->emergency_labor_cost_s1
            ]);

            // sem 2
            $cost_compo_seed_pull = CostCompoSeedPull::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'seed_pull_area' => $request->seed_pull_area_s2,
                'seed_pull_cost' => $request->seed_pull_cost_s2,
                'emergency_labor' => $request->emergency_labor_s2,
                'emergency_labor_area' => $request->emergency_labor_area_s2,
                'emergency_labor_cost' => $request->emergency_labor_cost_s2
            ]);

            // chemicals and fertilizers
            // sem 1
            $cost_compo_fertilizers = CostCompoFertilizers::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'area' => $request->fertilizer_area_s1,
                'cost' => $request->fertilizer_cost_s1
            ]);

            // sem 2
            $cost_compo_fertilizers = CostCompoFertilizers::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'area' => $request->fertilizer_area_s2,
                'cost' => $request->fertilizer_cost_s2
            ]);

            // harvesting
            // sem 1
            $cost_compo_harvesting = CostCompoHarvesting::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'manual_area' => $request->manual_area_s1,
                'manual_cost' => $request->manual_cost_s1,
                'mech_area' => $request->mech_area_s1,
                'mech_cost' => $request->mech_cost_s1,
                'ave_bags' => $request->ave_bags_s1,
                'cost_bag' => $request->cost_bag_s1,
                'threshing_cost' => $request->threshing_cost_s1,
                'towing_cost' => $request->towing_cost_s1,
                'hay_scatter_cost' => $request->hay_scatter_cost_s1
            ]);

            // sem 2
            $cost_compo_harvesting = CostCompoHarvesting::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'manual_area' => $request->manual_area_s2,
                'manual_cost' => $request->manual_cost_s2,
                'mech_area' => $request->mech_area_s2,
                'mech_cost' => $request->mech_cost_s2,
                'ave_bags' => $request->ave_bags_s2,
                'cost_bag' => $request->cost_bag_s2,
                'threshing_cost' => $request->threshing_cost_s2,
                'towing_cost' => $request->towing_cost_s2,
                'hay_scatter_cost' => $request->hay_scatter_cost_s2
            ]);

            // drying
            // sem 1
            $cost_compo_drying = CostCompoDrying::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'drying_bags' => $request->drying_bags_s1,
                'bag_cost' => $request->bag_cost_s1,
                'emergency_laborers' => $request->emergency_laborers_s1,
                'labor_days' => $request->labor_days_s1,
                'labor_cost' => $request->labor_cost_s1
            ]);

            // sem 2
            $cost_compo_drying = CostCompoDrying::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'drying_bags' => $request->drying_bags_s2,
                'bag_cost' => $request->bag_cost_s2,
                'emergency_laborers' => $request->emergency_laborers_s2,
                'labor_days' => $request->labor_days_s2,
                'labor_cost' => $request->labor_cost_s2
            ]);

            // service contractors
            // delete old service contractors data in the table
            $delete_cost_compo_contracts = CostCompoContracts::where('prod_cost_sched_id', '=', $id)
            ->delete();

            // add new/updated service contractors data
            // sem 1
            $service_contracts_s1 = $request->service_contracts_s1;

            for ($i=1; $i<count($service_contracts_s1); $i++) {
                $cost_compo_contracts = new CostCompoContracts;
                $cost_compo_contracts->prod_cost_sched_id = $id;
                $cost_compo_contracts->sem = 1;
                $cost_compo_contracts->months_hired = $request->months_hired_s1;
                $cost_compo_contracts->position = $service_contracts_s1[$i]['position'];
                $cost_compo_contracts->count = intval($service_contracts_s1[$i]['count']);
                $cost_compo_contracts->rate = $service_contracts_s1[$i]['rate'];
                $cost_compo_contracts->save();
            }

            // sem 2
            $service_contracts_s2 = $request->service_contracts_s2;
            
            for ($i=1; $i<count($service_contracts_s2); $i++) {
                $cost_compo_contracts = new CostCompoContracts;
                $cost_compo_contracts->prod_cost_sched_id = $id;
                $cost_compo_contracts->sem = 2;
                $cost_compo_contracts->months_hired = $request->months_hired_s2;
                $cost_compo_contracts->position = $service_contracts_s2[$i]['position'];
                $cost_compo_contracts->count = intval($service_contracts_s2[$i]['count']);
                $cost_compo_contracts->rate = $service_contracts_s2[$i]['rate'];
                $cost_compo_contracts->save();
            }

            // planting materials
            // sem 1
            $cost_compo_planting_mat = CostCompoPlantingMat::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'seeding_rate' => $request->seeding_rate,
                'rs_cost' => $request->rs_cost_s1,
                'fs_cost' => $request->fs_cost_s1
            ]);

            // sem 2
            $cost_compo_planting_mat = CostCompoPlantingMat::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'seeding_rate' => $request->seeding_rate,
                'rs_cost' => $request->rs_cost_s2,
                'fs_cost' => $request->fs_cost_s2
            ]);

            // field supplies
            // sem 1
            $cost_compo_field_supp = CostCompoFieldSupp::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'sack_cost_20kg' => $request->sack_cost_20kg_s1,
                'sack_cost_10kg' => $request->sack_cost_10kg_s1,
                'sack_cost_50kg' => $request->sack_cost_50kg_s1,
                'other_field_supp' => $request->other_field_supp_s1
            ]);

            // sem 2
            $cost_compo_field_supp = CostCompoFieldSupp::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'sack_cost_20kg' => $request->sack_cost_20kg_s2,
                'sack_cost_10kg' => $request->sack_cost_10kg_s2,
                'sack_cost_50kg' => $request->sack_cost_50kg_s2,
                'other_field_supp' => $request->other_field_supp_s2
            ]);


            // fuel, oil lubricants
            // sem 1
            $cost_compo_fuel = CostCompoFuel::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'diesel_liters' => $request->diesel_liters_s1,
                'diesel_cost' => $request->diesel_cost_s1,
                'gas_liters' => $request->gas_liters_s1,
                'gas_cost' => $request->gas_cost_s1,
                'kerosene_liters' => $request->kerosene_liters_s1,
                'kerosene_cost' => $request->kerosene_cost_s1
            ]);

            // sem 2
            $cost_compo_fuel = CostCompoFuel::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'diesel_liters' => $request->diesel_liters_s2,
                'diesel_cost' => $request->diesel_cost_s2,
                'gas_liters' => $request->gas_liters_s2,
                'gas_cost' => $request->gas_cost_s2,
                'kerosene_liters' => $request->kerosene_liters_s2,
                'kerosene_cost' => $request->kerosene_cost_s2
            ]);

            // irrigation fees
            // sem 1
            $cost_compo_irrig = CostCompoIrrig::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update(['cost' => $request->irrig_cost_s1]);

            // sem 2
            $cost_compo_irrig = CostCompoIrrig::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update(['cost' => $request->irrig_cost_s2]);

            // seed laboratory fees
            // sem 1
            $cost_compo_seed_lab = CostCompoSeedLab::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update(['amount' => $request->seed_lab_amt_s1]);

            // sem 2
            $cost_compo_seed_lab = CostCompoSeedLab::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update(['amount' => $request->seed_lab_amt_s2]);

            // land rental
            // sem 1
            $cost_compo_land_rental = CostCompoLandRental::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'area' => $request->land_rental_area_s1,
                'cost' => $request->land_rental_cost_s1
            ]);

            // sem 2
            $cost_compo_land_rental = CostCompoLandRental::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'area' => $request->land_rental_area_s2,
                'cost' => $request->land_rental_cost_s2
            ]);

            // seed production contracting
            // sem 1
            $cost_compo_prod_contract = CostCompoProdContract::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 1]
            ])
            ->update([
                'seed_volume' => $request->seed_volume_s1,
                'buying_price' => $request->buying_price_s1
            ]);

            // sem 2
            $cost_compo_prod_contract = CostCompoProdContract::where([
                ['prod_cost_sched_id', '=', $id],
                ['sem', '=', 2]
            ])
            ->update([
                'seed_volume' => $request->seed_volume_s2,
                'buying_price' => $request->buying_price_s2
            ]);

            DB::commit();

            echo json_encode("success");
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            // echo json_encode($e->getMessage());

            echo json_encode("error");
        }
    }

    public function evaluate($id) {
        $role = $this->role();

        // production cost schedule
        $production_cost_schedule = ProductionCostSchedule::find($id);

        $production_cost_id = $production_cost_schedule->production_cost_id; // production cost id

        // land preparation component
        $land_preparation = CostCompoLandPrep::where('production_cost_id', $production_cost_id)->get();

        // seed pulling component
        $seed_pulling = CostCompoSeedPull::where('production_cost_id', $production_cost_id)->get();

        // fertilizers component
        $fertilizers = CostCompoFertilizers::where('production_cost_id', $production_cost_id)->get();

        // harvesting component
        $harvesting = CostCompoHarvesting::where('production_cost_id', $production_cost_id)->get();

        // drying component
        $drying = CostCompoDrying::where('production_cost_id', $production_cost_id)->get();

        // seed cleaning component
        $seed_cleaning = CostCompoSeedCleaning::where('production_cost_id', $production_cost_id)->get();

        // service contracts component
        $service_contracts = CostCompoContracts::where('production_cost_id', $production_cost_id)
        ->with('positions')
        ->get();

        // planting materials component
        $planting_materials = CostCompoPlantingMat::where('production_cost_id', $production_cost_id)->get();

        // field supplies component
        $field_supplies = CostCompoFieldSupp::where('production_cost_id', $production_cost_id)->get();

        // fuel component
        $fuel = CostCompoFuel::where('production_cost_id', $production_cost_id)->get();

        // irrigation fees component
        $irrigation = CostCompoIrrig::where('production_cost_id', $production_cost_id)->get();

        // seed laboratory fees component
        $seed_laboratory = CostCompoSeedLab::where('production_cost_id', $production_cost_id)->first();

        // land rental component
        $land_rental = CostCompoLandRental::where('production_cost_id', $production_cost_id)->get();

        // seed production contracting component
        $production_contracting = CostCompoProdContract::where('production_cost_id', $production_cost_id)->get();

        // seeding rate
        $seeding_rate = CostCompoSeedingRate::where('production_cost_id', $production_cost_id)->first();

        // check if accountant or bdd head or bdd coordinator
        if (Entrust::hasRole('accountant')) {
            $action = "Reviewing";
        } elseif (Entrust::hasRole('bdd_head') || Entrust::hasRole('bdd_coordinator')) {
            $action = "Approving";
        } else {
            $action = "None";
        }

        return view('production_cost_schedule.evaluate')->with(compact(
            'role',
            'production_cost_id',
            'production_cost_schedule',
            'land_preparation',
            'seed_pulling',
            'fertilizers',
            'harvesting',
            'drying',
            'seed_cleaning',
            'service_contracts',
            'planting_materials',
            'field_supplies',
            'fuel',
            'irrigation',
            'seed_laboratory',
            'land_rental',
            'production_contracting',
            'seeding_rate',
            'action'
        ));
    }

    public function submit_evaluation(Request $request) {
        DB::beginTransaction();
        try {
            $production_cost_schedule = ProductionCostSchedule::find($request->production_cost_id);
            $production_cost_schedule->is_approved = $request->is_approved;
            $production_cost_schedule->remarks = $production_cost_schedule->remarks . '\n' . $request->remarks;
            $production_cost_schedule->save();

            if ($request->is_approved == 1) {
                $activity = "Approved Production Cost Schedule";
            } elseif ($request->is_approved == 2) {
                $activity = "Reviewed Production Cost Schedule";
            } elseif ($request->is_approved == 3) {
                $activity = "Production Cost Schedule For Revision";
            }

             // add activity log
            $prod_cost_sched_act = new ProductionCostScheduleActivities;
            $prod_cost_sched_act->production_cost_id = $request->production_cost_id;
            $prod_cost_sched_act->user_id = Auth::user()->user_id;
            $prod_cost_sched_act->browser = $this->browser();
            $prod_cost_sched_act->activity = $activity;
            $prod_cost_sched_act->device = $this->device();
            $prod_cost_sched_act->ip_env_address = $request->ip();
            $prod_cost_sched_act->ip_server_address = $request->server('SERVER_ADDR');
            $prod_cost_sched_act->OS = $this->operating_system();
            $prod_cost_sched_act->save();

            DB::commit();

            return redirect()->route('production_cost_schedule.index');
        } catch (Exception $e) {
            DB::rollback();

            // For debugging purposes uncomment the next line
            echo $e->getMessage();
        }
    }

    public function delete(Request $request, $id) {
        try {
            ProductionCostSchedule::find($id)->delete();

            CostCompoContracts::where('production_cost_id', '=', $id)->delete();
            CostCompoDrying::where('production_cost_id', '=', $id)->delete();
            CostCompoFertilizers::where('production_cost_id', '=', $id)->delete();
            CostCompoFieldSupp::where('production_cost_id', '=', $id)->delete();
            CostCompoFuel::where('production_cost_id', '=', $id)->delete();
            CostCompoHarvesting::where('production_cost_id', '=', $id)->delete();
            CostCompoIrrig::where('production_cost_id', '=', $id)->delete();
            CostCompoLandPrep::where('production_cost_id', '=', $id)->delete();
            CostCompoLandRental::where('production_cost_id', '=', $id)->delete();
            CostCompoPlantingMat::where('production_cost_id', '=', $id)->delete();
            CostCompoProdContract::where('production_cost_id', '=', $id)->delete();
            CostCompoSeedLab::where('production_cost_id', '=', $id)->delete();
            CostCompoSeedPull::where('production_cost_id', '=', $id)->delete();
            CostCompoSeedCleaning::where('production_cost_id', '=', $id)->delete();
            CostCompoContractPosition::where('production_cost_id', '=', $id)->delete();
            CostCompoSeedingRate::where('production_cost_id', '=', $id)->delete();

            // save logs
            $activity = new ProductionCostScheduleActivities;
            $activity->production_cost_id = $id;
            $activity->user_id = Auth::user()->user_id;
            $activity->browser = $this->browser();
            $activity->activity = "Deleted production cost schedule data";
            $activity->device = $this->device();
            $activity->ip_env_address = $request->ip();
            $activity->ip_server_address = $request->server('SERVER_ADDR');
            $activity->OS = $this->operating_system();
            $activity->save();

            DB::commit();

            echo json_encode("success");
        } catch (Exception $e) {
            DB::rollback();
            echo json_encode($e->getMessage());
        }
    }

    public function exportToPDF(Request $request, $id) {
        $stationID = $this->userStationID();

        // production cost schedule
        $production_cost_schedule = ProductionCostSchedule::find($id);

        $production_cost_id = $production_cost_schedule->production_cost_id; // production cost id

        // land preparation component
        $land_preparation = CostCompoLandPrep::where('production_cost_id', $production_cost_id)->get();

        // seed pulling component
        $seed_pulling = CostCompoSeedPull::where('production_cost_id', $production_cost_id)->get();

        // fertilizers component
        $fertilizers = CostCompoFertilizers::where('production_cost_id', $production_cost_id)->get();

        // harvesting component
        $harvesting = CostCompoHarvesting::where('production_cost_id', $production_cost_id)->get();

        // drying component
        $drying = CostCompoDrying::where('production_cost_id', $production_cost_id)->get();

        // seed cleaning component
        $seed_cleaning = CostCompoSeedCleaning::where('production_cost_id', $production_cost_id)->get();

        // service contracts component
        $service_contracts = CostCompoContracts::where('production_cost_id', $production_cost_id)
        ->with('positions')
        ->get();

        // planting materials component
        $planting_materials = CostCompoPlantingMat::where('production_cost_id', $production_cost_id)->get();

        // field supplies component
        $field_supplies = CostCompoFieldSupp::where('production_cost_id', $production_cost_id)->get();

        // fuel component
        $fuel = CostCompoFuel::where('production_cost_id', $production_cost_id)->get();

        // irrigation fees component
        $irrigation = CostCompoIrrig::where('production_cost_id', $production_cost_id)->get();

        // seed laboratory fees component
        $seed_laboratory = CostCompoSeedLab::where('production_cost_id', $production_cost_id)->first();

        // land rental component
        $land_rental = CostCompoLandRental::where('production_cost_id', $production_cost_id)->get();

        // seed production contracting component
        $production_contracting = CostCompoProdContract::where('production_cost_id', $production_cost_id)->get();

        // seeding rate
        $seeding_rate = CostCompoSeedingRate::where('production_cost_id', $production_cost_id)->first();

        // Signatories
        if ($stationID == 4) {
            $prepared = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'SPS III'] // Update this when changed in database
            ])
            ->first();

            $reviewed = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'BDD Accountant']
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
                ['designation', '=', 'BDD/U Coordinator']
            ])
            ->first();

            $reviewed = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'Station Accountant']
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

        $station = Station::select('name')->where('philrice_station_id', '=', $stationID)->first();

        try {
            $custom_paper = array(0, 0, 612.00, 936.00);
            $fileName = "Production Cost.pdf";
            $pdf = PDF::loadView('production_cost_schedule.pdf', compact([
                'production_cost_id',
                'production_cost_schedule',
                'land_preparation',
                'seed_pulling',
                'fertilizers',
                'harvesting',
                'drying',
                'seed_cleaning',
                'service_contracts',
                'planting_materials',
                'field_supplies',
                'fuel',
                'irrigation',
                'seed_laboratory',
                'land_rental',
                'production_contracting',
                'seeding_rate',
                'station',
                'prepared',
                'reviewed',
                'approved'
            ]));
            $pdf->setPaper($custom_paper, 'portrait');
            return $pdf->stream();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function exportToExcel(Request $request, $id) {
        $stationID = $this->userStationID();

        // production cost schedule
        $production_cost_schedule = ProductionCostSchedule::find($id);

        $production_cost_id = $production_cost_schedule->production_cost_id; // production cost id

        // land preparation component
        $land_preparation = CostCompoLandPrep::where('production_cost_id', $production_cost_id)->get();

        // seed pulling component
        $seed_pulling = CostCompoSeedPull::where('production_cost_id', $production_cost_id)->get();

        // fertilizers component
        $fertilizers = CostCompoFertilizers::where('production_cost_id', $production_cost_id)->get();

        // harvesting component
        $harvesting = CostCompoHarvesting::where('production_cost_id', $production_cost_id)->get();

        // drying component
        $drying = CostCompoDrying::where('production_cost_id', $production_cost_id)->get();

        // seed cleaning component
        $seed_cleaning = CostCompoSeedCleaning::where('production_cost_id', $production_cost_id)->get();

        // service contracts component
        $service_contracts = CostCompoContracts::where('production_cost_id', $production_cost_id)
        ->with('positions')
        ->get();

        // planting materials component
        $planting_materials = CostCompoPlantingMat::where('production_cost_id', $production_cost_id)->get();

        // field supplies component
        $field_supplies = CostCompoFieldSupp::where('production_cost_id', $production_cost_id)->get();

        // fuel component
        $fuel = CostCompoFuel::where('production_cost_id', $production_cost_id)->get();

        // irrigation fees component
        $irrigation = CostCompoIrrig::where('production_cost_id', $production_cost_id)->get();

        // seed laboratory fees component
        $seed_laboratory = CostCompoSeedLab::where('production_cost_id', $production_cost_id)->first();

        // land rental component
        $land_rental = CostCompoLandRental::where('production_cost_id', $production_cost_id)->get();

        // seed production contracting component
        $production_contracting = CostCompoProdContract::where('production_cost_id', $production_cost_id)->get();

        // seeding rate
        $seeding_rate = CostCompoSeedingRate::where('production_cost_id', $production_cost_id)->first();

        // Signatories
        if ($stationID == 4) {
            $prepared = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'SPS III'] // Update this when changed in database
            ])
            ->first();

            $reviewed = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'BDD Accountant']
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
                ['designation', '=', 'BDD/U Coordinator']
            ])
            ->first();

            $reviewed = Signatory::select('full_name', 'designation')
            ->where([
                ['philrice_station_id', '=', $stationID],
                ['designation', '=', 'Station Accountant']
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

        $station = Station::select('name')->where('philrice_station_id', '=', $stationID)->first();

        try {
            // Create excel
            Excel::create('Processing Report', function($excel) use (
                $production_cost_id,
                $production_cost_schedule,
                $land_preparation,
                $seed_pulling,
                $fertilizers,
                $harvesting,
                $drying,
                $seed_cleaning,
                $service_contracts,
                $planting_materials,
                $field_supplies,
                $fuel,
                $irrigation,
                $seed_laboratory,
                $land_rental,
                $production_contracting,
                $seeding_rate,
                $station,
                $prepared,
                $reviewed,
                $approved
            ) {
                // Create sheet
                $excel->sheet('Sheet 1', function($sheet) use (
                    $production_cost_id,
                    $production_cost_schedule,
                    $land_preparation,
                    $seed_pulling,
                    $fertilizers,
                    $harvesting,
                    $drying,
                    $seed_cleaning,
                    $service_contracts,
                    $planting_materials,
                    $field_supplies,
                    $fuel,
                    $irrigation,
                    $seed_laboratory,
                    $land_rental,
                    $production_contracting,
                    $seeding_rate,
                    $station,
                    $prepared,
                    $reviewed,
                    $approved
                ) {
                    // Load view for the sheet
                    $sheet->loadView('production_cost_schedule.excel', array(
                        'production_cost_id' => $production_cost_id,
                        'production_cost_schedule' => $production_cost_schedule,
                        'land_preparation' => $land_preparation,
                        'seed_pulling' => $seed_pulling,
                        'fertilizers' => $fertilizers,
                        'harvesting' => $harvesting,
                        'drying' => $drying,
                        'seed_cleaning' => $seed_cleaning,
                        'service_contracts' => $service_contracts,
                        'planting_materials' => $planting_materials,
                        'field_supplies' => $field_supplies,
                        'fuel' => $fuel,
                        'irrigation' => $irrigation,
                        'seed_laboratory' => $seed_laboratory,
                        'land_rental' => $land_rental,
                        'production_contracting' => $production_contracting,
                        'seeding_rate' => $seeding_rate,
                        'station' => $station,
                        'prepared' => $prepared,
                        'reviewed' => $reviewed,
                        'approved' => $approved
                    ))
                    ->protect('RS1S_@dm1n1str4t0r');
                });
            })
            ->download('xls');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function query_area($data) {
        $area = TargetVarieties::where([
            ['philrice_station_id', '=', $data['philrice_station_id']],
            ['year', '=', $data['year']],
            ['sem', '=', $data['sem']],
            ['is_deleted', '=', 0]
        ]);

        if (isset($data['seed_class'])) {
            $area = $area->where('seed_class', '=', $data['seed_class']);
        }

        $area = $area->select(DB::raw('SUM(CAST(area AS DECIMAL (10, 4))) AS total'))
        ->first();

        return $area->total;
    }

    private function query_cost_compo_land_prep($data) {
        $result = CostCompoLandPrep::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('roto_cost', 'level_cost')
        ->first();

        $cost_compo_land_prep = array();
        $cost_compo_land_prep['roto_cost'] = $result->roto_cost;
        $cost_compo_land_prep['level_cost'] = $result->level_cost;
        $cost_compo_land_prep['roto_amount'] = $data['area'] * $cost_compo_land_prep['roto_cost'];
        $cost_compo_land_prep['level_amount'] = $data['area'] * $cost_compo_land_prep['level_cost'];
        $cost_compo_land_prep['stotal'] = $cost_compo_land_prep['roto_amount'] + $cost_compo_land_prep['level_amount'];

        return $cost_compo_land_prep;
    }

    private function query_cost_compo_seed_pull($data) {
        $result = CostCompoSeedPull::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('seed_pull_area', 'seed_pull_cost', 'emergency_labor', 'emergency_labor_area', 'emergency_labor_cost')
        ->first();

        $cost_compo_seed_pull = array();
        $cost_compo_seed_pull['seed_pull_area'] = $result->seed_pull_area;
        $cost_compo_seed_pull['seed_pull_cost'] = $result->seed_pull_cost;
        $cost_compo_seed_pull['emergency_labor'] = $result->emergency_labor;
        $cost_compo_seed_pull['emergency_labor_area'] = $result->emergency_labor_area;
        $cost_compo_seed_pull['emergency_labor_cost'] = $result->emergency_labor_cost;
        $cost_compo_seed_pull['seed_pull_amount'] = $cost_compo_seed_pull['seed_pull_area'] * $cost_compo_seed_pull['seed_pull_cost'];
        $cost_compo_seed_pull['emergency_labor_amount'] = ($cost_compo_seed_pull['emergency_labor_area'] * $cost_compo_seed_pull['emergency_labor_cost']) * $cost_compo_seed_pull['emergency_labor'];
        $cost_compo_seed_pull['stotal'] = $cost_compo_seed_pull['seed_pull_amount'] + $cost_compo_seed_pull['emergency_labor_amount'];

        return $cost_compo_seed_pull;
    }

    private function query_cost_compo_fertilizers($data) {
        $result = CostCompoFertilizers::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('area', 'cost')
        ->first();

        $cost_compo_fertilizers = array();
        $cost_compo_fertilizers['area'] = $result->area;
        $cost_compo_fertilizers['cost'] = $result->cost;
        $cost_compo_fertilizers['amount'] = $cost_compo_fertilizers['area'] * $cost_compo_fertilizers['cost'];

        return $cost_compo_fertilizers;
    }

    private function query_cost_compo_harvesting($data) {
        $result = CostCompoHarvesting::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('manual_area', 'manual_cost', 'mech_area', 'mech_cost', 'ave_bags', 'cost_bag', 'threshing_cost', 'towing_cost', 'hay_scatter_cost')
        ->first();

        $cost_compo_harvesting = array();
        $cost_compo_harvesting['manual_area'] = $result->manual_area;
        $cost_compo_harvesting['manual_cost'] = $result->manual_cost;
        $cost_compo_harvesting['mech_area'] = $result->mech_area;
        $cost_compo_harvesting['mech_cost'] = $result->mech_cost;
        $cost_compo_harvesting['ave_bags'] = $result->ave_bags;
        $cost_compo_harvesting['cost_bag'] = $result->cost_bag;
        $cost_compo_harvesting['threshing_cost'] = $result->threshing_cost;
        $cost_compo_harvesting['towing_cost'] = $result->towing_cost;
        $cost_compo_harvesting['hay_scatter_cost'] = $result->hay_scatter_cost;
        $cost_compo_harvesting['manual_amount'] = $cost_compo_harvesting['manual_area'] * $cost_compo_harvesting['manual_cost'];
        $cost_compo_harvesting['mech_amount'] = $cost_compo_harvesting['mech_area'] * $cost_compo_harvesting['mech_cost'];
        $cost_compo_harvesting['hauling_bags'] = $cost_compo_harvesting['ave_bags'] * $data['area'];
        $cost_compo_harvesting['hauling_amount'] = $cost_compo_harvesting['hauling_bags'] * $cost_compo_harvesting['cost_bag'];
        $cost_compo_harvesting['threshing_amount'] = $cost_compo_harvesting['manual_area'] * $cost_compo_harvesting['threshing_cost'];
        $cost_compo_harvesting['towing_amount'] = $cost_compo_harvesting['manual_area'] * $cost_compo_harvesting['towing_cost'];
        $cost_compo_harvesting['hay_scatter_amount'] = $cost_compo_harvesting['manual_area'] * $cost_compo_harvesting['hay_scatter_cost'];
        $cost_compo_harvesting['stotal'] = $cost_compo_harvesting['manual_amount'] + $cost_compo_harvesting['mech_amount'] + $cost_compo_harvesting['hauling_amount'] + $cost_compo_harvesting['threshing_amount'] +  $cost_compo_harvesting['towing_amount'] + $cost_compo_harvesting['hay_scatter_amount'];

        return $cost_compo_harvesting;
    }

    private function query_cost_compo_drying($data) {
        $result = CostCompoDrying::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('drying_bags', 'bag_cost', 'emergency_laborers', 'labor_days', 'labor_cost')
        ->first();

        $cost_compo_drying = array();
        $cost_compo_drying['drying_bags'] = $result->drying_bags;
        $cost_compo_drying['bag_cost'] = $result->bag_cost;
        $cost_compo_drying['emergency_laborers'] = $result->emergency_laborers;
        $cost_compo_drying['labor_days'] = $result->labor_days;
        $cost_compo_drying['labor_cost'] = $result->labor_cost;
        $cost_compo_drying['drying_fee_amount'] = $cost_compo_drying['drying_bags'] * $cost_compo_drying['bag_cost'];
        $cost_compo_drying['labor_amount'] = ($cost_compo_drying['labor_days'] * $cost_compo_drying['labor_cost']) * $cost_compo_drying['emergency_laborers'];
        $cost_compo_drying['stotal'] = $cost_compo_drying['drying_fee_amount'] + $cost_compo_drying['labor_amount'];

        return $cost_compo_drying;
    }

    private function query_cost_compo_contracts($data) {
        $results = CostCompoContracts::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('months_hired', 'position', 'count', 'rate')
        ->get();

        $cost_compo_contracts = array();
        $cost_compo_contracts['monthly_stotal'] = 0;
        $cost_compo_contracts['stotal'] = 0;
        $service_contracts = array();

        foreach ($results as $res) {
            $monthly_cost = $res->rate * $res->count;
            $total = $monthly_cost * $res->months_hired;

            $service_contracts[] = array(
                'months_hired' => $res->months_hired,
                'position' => $res->position,
                'count' => $res->count,
                'rate' => $res->rate,
                'monthly_cost' => $monthly_cost,
                'total' => $total
            );

            $cost_compo_contracts['monthly_stotal'] += $monthly_cost;
            $cost_compo_contracts['stotal'] += $total;
        }

        $cost_compo_contracts['service_contracts'] = $service_contracts;

        return $cost_compo_contracts;
    }

    private function query_cost_compo_planting_mat($data) {
        $result = CostCompoPlantingMat::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('sem', 'seeding_rate', 'rs_cost', 'fs_cost')
        ->first();

        $cost_compo_planting_mat = array();
        $cost_compo_planting_mat['seeding_rate'] = $result->seeding_rate;
        $cost_compo_planting_mat['rs_cost'] = $result->rs_cost;
        $cost_compo_planting_mat['fs_cost'] = $result->fs_cost;
        $cost_compo_planting_mat['seeds_rs'] = $data['area_rs'] * $cost_compo_planting_mat['seeding_rate'];
        $cost_compo_planting_mat['seeds_rs_amount'] = $cost_compo_planting_mat['seeds_rs'] * $cost_compo_planting_mat['rs_cost'];
        $cost_compo_planting_mat['seeds_fs'] = $data['area_fs'] * $cost_compo_planting_mat['seeding_rate'];
        $cost_compo_planting_mat['seeds_fs_amount'] = $cost_compo_planting_mat['seeds_fs'] * $cost_compo_planting_mat['fs_cost'];
        $cost_compo_planting_mat['stotal'] = $cost_compo_planting_mat['seeds_rs_amount'] + $cost_compo_planting_mat['seeds_fs_amount'];

        return $cost_compo_planting_mat;
    }

    private function query_cost_compo_field_supp($data) {
        $result = CostCompoFieldSupp::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('sack_cost_20kg', 'sack_cost_10kg', 'sack_cost_50kg', 'other_field_supp')
        ->first();

        $cost_compo_field_supp = array();
        $cost_compo_field_supp['sack_cost_20kg'] = $result->sack_cost_20kg;
        $cost_compo_field_supp['sack_cost_10kg'] = $result->sack_cost_10kg;
        $cost_compo_field_supp['sack_cost_50kg'] = $result->sack_cost_50kg;
        $cost_compo_field_supp['other_field_supp'] = $result->other_field_supp;
        $cost_compo_field_supp['sacks_20kg'] = ($data['area_rs'] * $data['ave_bags']) * 1.15;
        $cost_compo_field_supp['sacks_10kg'] = ($data['area_fs'] * $data['ave_bags']) * 1.15;
        $cost_compo_field_supp['sacks_50kg'] = $data['hauling_bags'] * 1.1;
        $cost_compo_field_supp['amount_20kg'] = $cost_compo_field_supp['sacks_20kg'] * $cost_compo_field_supp['sack_cost_20kg'];
        $cost_compo_field_supp['amount_10kg'] = $cost_compo_field_supp['sacks_10kg'] * $cost_compo_field_supp['sack_cost_10kg'];
        $cost_compo_field_supp['amount_50kg'] = $cost_compo_field_supp['sacks_50kg'] * $cost_compo_field_supp['sack_cost_50kg'];
        $cost_compo_field_supp['stotal'] = $cost_compo_field_supp['amount_20kg'] + $cost_compo_field_supp['amount_10kg'] + $cost_compo_field_supp['amount_50kg'] + $cost_compo_field_supp['other_field_supp'];

        return $cost_compo_field_supp;
    }

    private function query_cost_compo_fuel($data) {
        $result = CostCompoFuel::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('diesel_liters', 'diesel_cost', 'gas_liters', 'gas_cost', 'kerosene_liters', 'kerosene_cost')
        ->first();

        $cost_compo_fuel = array();
        $cost_compo_fuel['diesel_liters'] = $result->diesel_liters;
        $cost_compo_fuel['diesel_cost'] = $result->diesel_cost;
        $cost_compo_fuel['gas_liters'] = $result->gas_liters;
        $cost_compo_fuel['gas_cost'] = $result->gas_cost;
        $cost_compo_fuel['kerosene_liters'] = $result->kerosene_liters;
        $cost_compo_fuel['kerosene_cost'] = $result->kerosene_cost;
        $cost_compo_fuel['diesel_amount'] = ($cost_compo_fuel['diesel_liters'] * $cost_compo_fuel['diesel_cost']) * $data['area'];
        $cost_compo_fuel['gas_amount'] = ($cost_compo_fuel['gas_liters'] * $cost_compo_fuel['gas_cost']) * $data['area'];
        $cost_compo_fuel['kerosene_amount'] = ($cost_compo_fuel['kerosene_liters'] * $cost_compo_fuel['kerosene_cost']) * $data['area'];
        $cost_compo_fuel['stotal'] = $cost_compo_fuel['diesel_amount'] + $cost_compo_fuel['gas_amount'] + $cost_compo_fuel['kerosene_amount'];

        return $cost_compo_fuel;
    }

    private function query_cost_compo_irrig($data) {
        $result = CostCompoIrrig::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('cost')
        ->first();

        $cost_compo_irrig = array();
        $cost_compo_irrig['cost'] = $result->cost;
        $cost_compo_irrig['amount'] = $data['area'] * $result->cost;

        return $cost_compo_irrig;
    }

    private function query_cost_compo_seed_lab($data) {
        $result = CostCompoSeedLab::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('amount')
        ->first();

        $cost_compo_seed_lab = array();
        $cost_compo_seed_lab['amount'] = $result->amount;

        return $cost_compo_seed_lab;
    }

    private function query_cost_compo_land_rental($data) {
        $result = CostCompoLandRental::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('area', 'cost')
        ->first();

        $cost_compo_land_rental = array();
        $cost_compo_land_rental['area'] = $result->area;
        $cost_compo_land_rental['cost'] = $result->cost;
        $cost_compo_land_rental['amount'] = $cost_compo_land_rental['area'] * $cost_compo_land_rental['cost'];

        return $cost_compo_land_rental;
    }

    private function query_cost_compo_prod_contract($data) {
        $result = CostCompoProdContract::where([
            ['prod_cost_sched_id', '=', $data['prod_cost_sched_id']],
            ['sem', '=', $data['sem']]
        ])
        ->select('seed_volume', 'buying_price')
        ->first();

        $cost_compo_prod_contract = array();
        $cost_compo_prod_contract['seed_volume'] = $result->seed_volume;
        $cost_compo_prod_contract['buying_price'] = $result->buying_price;
        $cost_compo_prod_contract['amount'] = $cost_compo_prod_contract['seed_volume'] * $cost_compo_prod_contract['buying_price'];

        return $cost_compo_prod_contract;
    }

    // StationID of logged in user
    private function userStationID() {
        $userAffiliation = AffiliationUser::where('user_id', Auth::user()->user_id)->with('station')->first();
        $stationID = $userAffiliation->station->philrice_station_id;

        return $stationID;
    }
}
