@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Production Cost Schedule</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('production_cost_schedule.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><a href="{{route('production_cost_schedule.index')}}">Production Cost Schedule</a></li>
			<li><span>View Production Cost Schedule</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<h3 class="text-center" style="margin-bottom: 5px;">PROJECTED SEED PRODUCTION COST</h3>
	<h3 class="text-center mb-xl" style="margin-top: 5px;"><i>{{$production_cost_schedule->year}} Semester 1 & Semester 2</i></h3>

	<h4 class="mb-xl">Seed Production Type: <strong>{{ $production_cost_schedule->seed_production_type }}</strong></h4>

	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
			</div>

			<h2 class="panel-title">I. PRODUCTION COST SCHEDULE</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered" style="width: 100%;">
				<thead>
					<tr class="success">
						<th colspan="2" style="width: 50%;">Cost Components/Activities</th>
						<th class="text-center" style="width: 15%;">Area (ha)</th>
						<th class="text-center" style="width: 15%;">Cost per ha (P)</th>
						<th class="text-center" style="width: 20%;">Amount (P)</th>
					</tr>
				</thead>
				<tbody>
					@php
						$land_preparation_component = array();
						$seed_pulling_component = array();
						$fertilizer_component = array();
						$harvesting_component = array();
						$drying_component = array();
						$seed_cleaning_component = array();
						$service_contract_component = array();
						$planting_material_component = array();
						$field_supplies_component = array();
						$fuel_component = array();
						$irrigation_fees_component = array();
						$seed_laboratory_component = array();
						$land_rental_component = array();
						$production_contracting_component = array();
					@endphp

					<tr class="warning">
						<th colspan="5">A. Land Preparation (3 Passing)</th>
					</tr>

					@foreach ($land_preparation as $item)
						<tr>
							<td colspan="5">Sem {{$item->sem}}</td>
						<tr>
						<tr>
							<td class="text-right" style="width: 10%;">a.</td>
							<td style="width: 40%;">Custom Services for Rotovation/ Plowing/ Harrowing</td>
							<td class="text-right">{{number_format($item->rotovate_area, 2)}}</td>
							<td class="text-right">{{number_format($item->rotovate_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->rotovate_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right">b.</td>
							<td>Field Levelling</td>
							<td class="text-right">{{number_format($item->levelling_area, 2)}}</td>
							<td class="text-right">{{number_format($item->levelling_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->levelling_amount, 2)}}</td>
						</tr>
						<tr>
							<td colspan="4" class="text-right"><strong>Sub Total Sem {{$item->sem}}</strong></td>
							<td class="text-right"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
						</tr>

						@php
							array_push($land_preparation_component, $item->sub_total);
						@endphp
					@endforeach

					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($land_preparation_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="5">B. Seed Pulling, Marking & Transplanting</th>
					</tr>

					@foreach ($seed_pulling as $item)
						<tr>
							<th colspan="5">Sem {{$item->sem}}</th>
						</tr>
						<tr>
							<td></td>
							<td>Seed Pulling, Marking & Transplanting</td>
							<td class="text-right">{{number_format($item->pulling_area, 2)}}</td>
							<td class="text-right">{{number_format($item->pulling_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->pulling_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right">{{number_format($item->replanting_labor_no)}}</td>
							<td>Emergency labor for replanting of missed hills, and repair of dikes</td>
							<td class="text-right">{{number_format($item->replanting_labor_area, 2)}}</td>
							<td class="text-right">{{number_format($item->replanting_labor_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->replanting_labor_amount, 2)}}</td>
						</tr>

						@php
							array_push($seed_pulling_component, ($item->pulling_amount + $item->replanting_labor_amount));
						@endphp
					@endforeach
					
					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($seed_pulling_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="5">C. Chemicals & Fertilizers</th>
					</tr>

					@foreach($fertilizers as $item)
						<tr>
							<td></td>
							<td>Sem {{$loop->iteration}}</td>
							<td class="text-right">{{number_format($item->area, 2)}}</td>
							<td class="text-right">{{number_format($item->cost, 2)}}</td>
							<td class="text-right">{{number_format($item->amount, 2)}}</td>
						</tr>

						@php
							array_push($fertilizer_component, $item->amount);
						@endphp
					@endforeach

					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($fertilizer_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">D. Harvesting</th>
						<th class="text-center">Quantity</th>
						<th class="text-center">Unit Cost (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@foreach($harvesting as $item)
						<tr>
							<th colspan="5">Sem {{$item->sem}}</th>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td class="text-center"><i>No. of ha</i></td>
							<td class="text-center"><i>Per ha</i></td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">a.1</td>
							<td>Manual</td>
							<td class="text-right">{{number_format($item->manual_area, 2)}}</td>
							<td class="text-right">{{number_format($item->manual_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->manual_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right">a.2</td>
							<td>Mechanical (combine harvester)</td>
							<td class="text-right">{{number_format($item->mechanical_area, 2)}}</td>
							<td class="text-right">{{number_format($item->mechanical_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->mechanical_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right">b.</td>
							<td>Hauling</td>
							<td class="text-center"><i>No. of bags</i></td>
							<td class="text-center"><i>Per bag</i></td>
							<td class="text-right"></td>
						</tr>
						<tr>
							<td class="text-right">{{number_format($item->hauling_ave_bags)}}</td>
							<td><i>average 50-kg bags (fresh harvest) per ha</i></td>
							<td class="text-right">{{number_format($item->hauling_bags_no)}}</td>
							<td class="text-right">{{number_format($item->hauling_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->hauling_amount, 2)}}</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td class="text-center"><i>No. of ha</i></td>
							<td class="text-center"><i>Per ha</i></td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">c.</td>
							<td>Threshing (manual harvest)</td>
							<td class="text-right">{{number_format($item->threshing_area, 2)}}</td>
							<td class="text-right">{{number_format($item->threshing_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->threshing_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right">d.</td>
							<td>Towing of Thresher</td>
							<td class="text-right">{{number_format($item->towing_area, 2)}}</td>
							<td class="text-right">{{number_format($item->towing_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->towing_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right">e.</td>
							<td>Hay Scattering</td>
							<td class="text-right">{{number_format($item->scatter_area, 2)}}</td>
							<td class="text-right">{{number_format($item->scatter_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->scatter_amount, 2)}}</td>
						</tr>
						<tr>
							<td colspan="4" class="text-right"><strong>Sub Total Sem {{$item->sem}}</strong></td>
							<td class="text-right">{{number_format($item->sub_total, 2)}}</td>
						</tr>

						@php
							array_push($harvesting_component, $item->sub_total);
						@endphp
					@endforeach
					
					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($harvesting_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">E. Drying</th>
						<th class="text-center">Quantity</th>
						<th class="text-center">Unit Cost (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@foreach($drying as $item)
						<tr>
							<th colspan="5">Sem {{$item->sem}}</th>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td class="text-center"><i>No. of bags</i></td>
							<td class="text-center"><i>Per bag</i></td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td>Drying fee</td>
							<td class="text-right">{{number_format($item->drying_bags_no, 2)}}</td>
							<td class="text-right">{{number_format($item->drying_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->drying_amount, 2)}}</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td class="text-center"><i>No. of days</i></td>
							<td class="text-center"><i>Per day</i></td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">{{number_format($item->emergency_labor_no)}}</td>
							<td>No. of emergency laborers, if any</td>
							<td class="text-right">{{number_format($item->emergency_labor_days)}}</td>
							<td class="text-right">{{number_format($item->emergency_labor_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->emergency_labor_amount, 2)}}</td>
						</tr>
						<tr>
							<td colspan="4" class="text-right"><strong>Sub Total Sem {{$item->sem}}</strong></td>
							<td class="text-right"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
						</tr>

						@php
							array_push($drying_component, $item->sub_total);
						@endphp
					@endforeach

					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($drying_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">F. Seed Cleaning</th>
						<th class="text-center">Quantity (bags)</th>
						<th class="text-center">Unit Cost (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@foreach($seed_cleaning as $item)
						<tr>
							<th colspan="5">Sem {{$item->sem}}</th>
						</tr>
						<tr>
							<td class="text-right">{{number_format($item->ave_bags)}}</td>
							<td><i>
								@if ($production_cost_schedule->seed_production_type === "Inbred")
									average 20-kg bags (clean seeds) per ha
								@elseif ($production_cost_schedule->seed_production_type === "Hybrid (AxR)")
									average 18-kg bags (clean seeds) per ha
								@elseif ($production_cost_schedule->seed_production_type === "Hybrid (P and R)")
									average 15-kg bags (clean seeds) per ha
								@elseif ($production_cost_schedule->seed_production_type === "Hybrid (S)")
									average 15-kg bags (clean seeds) per ha
								@elseif ($production_cost_schedule->seed_production_type === "Hybrid (A)")
									average 15-kg bags (clean seeds) per ha
								@endif
							</i></td>
							<td class="text-right">{{number_format($item->bags_no)}}</td>
							<td class="text-right">{{number_format($item->cost, 2)}}</td>
							<td class="text-right">{{number_format($item->amount, 2)}}</td>
						</tr>

						@php
							array_push($seed_cleaning_component, $item->amount);
						@endphp
					@endforeach

					<tr>
						<th colspan="4" class="text-right"><strong>TOTAL</strong></th>
						<th class="text-right"><strong>{{number_format(array_sum($seed_cleaning_component), 2)}}</strong></th>
					</tr>

					<tr class="warning">
						<th colspan="2">G. Service Contractors</th>
						<th class="text-center">Monthly Rate (P)</th>
						<th class="text-center">Monthly Cost (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@foreach($service_contracts as $item)
						<tr>
							<th colspan="5">Sem {{$item->sem}}</th>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td><i>no. of months to be hired</i></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>

						@php 
							$monthly_rate_total = 0; 
						@endphp

						@foreach($item->positions as $pos)
							<tr>
								<td class="text-right">{{number_format($pos->contract_no)}}</td>
								<td>no. of {{$pos->position}}</td>
								<td class="text-right">{{number_format($pos->monthly_rate, 2)}}</td>
								<td class="text-right">{{number_format($pos->monthly_cost, 2)}}</td>
								<td class="text-right">{{number_format($pos->amount, 2)}}</td>
							</tr>

							@php
								$monthly_rate_total += $pos->monthly_cost;
							@endphp
						@endforeach

						<tr>
							<td colspan="3" class="text-right"><strong>Sub Total Sem {{$item->sem}}</strong></td>
							<td class="text-right"><strong>{{number_format($monthly_rate_total, 2)}}</strong></td>
							<td class="text-right"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
						</tr>

						@php
							array_push($service_contract_component, $item->sub_total);
						@endphp
					@endforeach

					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($service_contract_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">H. Planting Materials</th>
						<th class="text-center">Seeds (kg)</th>
						<th class="text-center">Unit Cost (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					<tr>
						<td class="text-right">{{number_format($seeding_rate->seeding_rate)}}</td>
						<td><i>seeding rate (kg seeds per ha)</i></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					@php
						switch($production_cost_schedule->seed_production_type) {
							case "Inbred":
								$area1_label = "Area for RS Production";
								$area2_label = "Area for FS Production";
								break;
							case "Hybrid (AxR)":
								$area1_label = "Area for AxR Production";
								$area2_label = "Area for ___ Production";
								break;
							case "Hybrid (P and R)":
								$area1_label = "Planting Materials for P-line Production";
								$area2_label = "Planting Materials for R-line Production";
								break;
							case "Hybrid (S)":
								$area1_label = "Area for S-line Production";
								$area2_label = "Area for ___ Production";
								break;
							case "Hybrid (A)":
								$area1_label = "Area for AxB Production";
								$area2_label = "Area for ___ Production";
						}
					@endphp

					@foreach($planting_materials as $item)
						<tr>
							<th colspan="5">Sem {{$item->sem}}</th>
						</tr>
						<tr>
							<td class="text-right">{{number_format($item->area1, 2)}}</td>
							<td><i>{{$area1_label}}</i></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">{{number_format($item->area2, 2)}}</td>
							<td><i>{{$area2_label}}</i></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td>Planting Materials for RS Production</td>
							<td class="text-right">{{number_format($item->area1_seed_quantity, 2)}}</td>
							<td class="text-right">{{number_format($item->area1_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->area1_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td>Planting Materials for FS Production</td>
							<td class="text-right">{{number_format($item->area2_seed_quantity, 2)}}</td>
							<td class="text-right">{{number_format($item->area2_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->area2_amount, 2)}}</td>
						</tr>
						<tr>
							<th colspan="4" class="text-right"><strong>Sub Total Sem {{$item->sem}}</strong></th>
							<th class="text-right"><strong>{{number_format($item->sub_total, 2)}}</strong></th>
						</tr>

						@php
							array_push($planting_material_component, $item->sub_total);
						@endphp
					@endforeach
					
					<tr>
						<th colspan="4" class="text-right"><strong>TOTAL</strong></th>
						<th class="text-right"><strong>{{number_format(array_sum($planting_material_component), 2)}}</strong></th>
					</tr>

					<tr class="warning">
						<th colspan="2">I. Field Supplies</th>
						<th class="text-center">No. of Sacks</th>
						<th class="text-center">Cost per Sack (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@php
						switch($production_cost_schedule->seed_production_type) {
							case "Inbred":
								$sack1_label = "Plastic 20-kg laminated sack for clean seed";
								$sack2_label = "Plastic 10-kg laminated sack for clean seed";
								break;
							case "Hybrid (P and R)":
								$sack1_label = "Plastic 5-kg laminated sack for clean seed";
								$sack2_label = "Plastic 5-kg plastic sack for clean seed";
								break;
							default:
								$sack1_label = "Plastic 15-kg laminated sack for clean seed";
								$sack2_label = "Plastic 15-kg plastic sack for clean seed";
								break;
						}
					@endphp

					@foreach($field_supplies as $item)
						<tr>
							<th colspan="5">Sem {{$item->sem}}</th>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td>{{$sack1_label}}</td>
							<td class="text-right">{{number_format($item->sack1_no)}}</td>
							<td class="text-right">{{number_format($item->sack1_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->sack1_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td>{{$sack2_label}}</td>
							<td class="text-right">{{number_format($item->sack2_no)}}</td>
							<td class="text-right">{{number_format($item->sack2_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->sack2_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td>Ordinary 50-kg sacks for fresh harvest</td>
							<td class="text-right">{{number_format($item->sack3_no)}}</td>
							<td class="text-right">{{number_format($item->sack3_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->sack3_amount, 2)}}</td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td>Other Field Supplies</td>
							<td></td>
							<td></td>
							<td class="text-right">{{number_format($item->other_supplies_amount, 2)}}</td>
						</tr>
						<tr>
							<td colspan="4" class="text-right"><strong>Sub Total Sem {{$item->sem}}</strong></td>
							<td class="text-right"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
						</tr>

						@php
							array_push($field_supplies_component, $item->sub_total);
						@endphp
					@endforeach
				
					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($field_supplies_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">J. Fuel, Oil and Lubricants</th>
						<th class="text-center">Liters per ha</th>
						<th class="text-center">Cost per Liter (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@foreach($fuel as $item)
						{{-- @if($item->sem == 1)
							$area = $production_cost_schedule->area1_s1 + $production_cost_schedule->area2_s1;
						@else
							$area = $production_cost_schedule->area1_s2 + $production_cost_schedule->area2_s2;
						@endif --}}

						<tr>
							<th colspan="5">Sem {{$item->sem}}</th>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td><i>Total serviceable area</i></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td>Diesel consumption per ha</td>
							<td class="text-right">{{number_format($item->diesel_liters, 2)}}</td>
							<td class="text-right">{{number_format($item->diesel_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->diesel_amount, 2)}}</td>
						</tr>
						<tr>
							<td></td>
							<td>Gasoline consumption per ha</td>
							<td class="text-right">{{number_format($item->gas_liters, 2)}}</td>
							<td class="text-right">{{number_format($item->gas_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->gas_amount, 2)}}</td>
						</tr>
						<tr>
							<td></td>
							<td>Kerosene consumption per ha</td>
							<td class="text-right">{{number_format($item->kerosene_liters, 2)}}</td>
							<td class="text-right">{{number_format($item->kerosene_cost, 2)}}</td>
							<td class="text-right">{{number_format($item->kerosene_amount, 2)}}</td>
						</tr>
						<tr>
							<td colspan="4" class="text-right"><strong>Sub Total Sem {{$item->sem}}</strong></td>
							<td class="text-right"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
						</tr>

						@php
							array_push($fuel_component, $item->sub_total);
						@endphp
					@endforeach

					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($fuel_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">K. Irrigation Fees</th>
						<th class="text-center">Area (ha)</th>
						<th class="text-center">Cost per ha (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@foreach($irrigation as $item)
						<tr>
							<td></td>
							<td>Sem {{$item->sem}}</td>
							<td class="text-right">{{number_format($item->area, 2)}}</td>
							<td class="text-right">{{number_format($item->cost, 2)}}</td>
							<td class="text-right">{{number_format($item->amount, 2)}}</td>
						</tr>

						@php
							array_push($irrigation_fees_component, $item->amount);
						@endphp
					@endforeach
					
					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($irrigation_fees_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">L. Seed Laboratory Fees</th>
						<th class="text-center"></th>
						<th class="text-center"></th>
						<th class="text-center">Amount (P)</th>
					</tr>
					
					<tr>
						<td></td>
						<td>Sem 1</td>
						<td class="text-right"></td>
						<td class="text-right"></td>
						<td class="text-right">{{number_format($seed_laboratory->amount_s1, 2)}}</td>
					</tr>

					<tr>
						<td></td>
						<td>Sem 2</td>
						<td class="text-right"></td>
						<td class="text-right"></td>
						<td class="text-right">{{number_format($seed_laboratory->amount_s2, 2)}}</td>
					</tr>

					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</h4></td>
						<td class="text-right"><strong>{{number_format($seed_laboratory->amount_s1 + $seed_laboratory->amount_s2, 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">M. Land Rental</th>
						<th class="text-center">Area (ha)</th>
						<th class="text-center">Cost per ha (P)</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@foreach($land_rental as $item)
						<tr>
							<td></td>
							<td>Sem {{$item->sem}}</td>
							<td class="text-right">{{number_format($item->area, 2)}}</td>
							<td class="text-right">{{number_format($item->cost, 2)}}</td>
							<td class="text-right">{{number_format($item->amount, 2)}}</td>
						</tr>

						@php
							array_push($land_rental_component, $item->amount);
						@endphp
					@endforeach
					
					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($land_rental_component), 2)}}</strong></td>
					</tr>

					<tr class="warning">
						<th colspan="2">N. Seed Production Contracting (if any)</th>
						<th class="text-center">Est. Volume of Seeds (kg)</th>
						<th class="text-center">Buying Price per kg</th>
						<th class="text-center">Amount (P)</th>
					</tr>

					@foreach($production_contracting as $item)
						<tr>
							<td></td>
							<td>Sem {{$item->sem}}</td>
							<td class="text-right">{{number_format($item->seed_volume, 2)}}</td>
							<td class="text-right">{{number_format($item->buying_price, 2)}}</td>
							<td class="text-right">{{number_format($item->amount, 2)}}</td>
						</tr>

						@php
							array_push($production_contracting_component, $item->amount);
						@endphp
					@endforeach
					
					<tr>
						<td colspan="4" class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{number_format(array_sum($production_contracting_component), 2)}}</strong></td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>

	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
			</div>

			<h2 class="panel-title">II. PRODUCTION COST SUMMARY</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered" style="width: 100%;">
				<thead>
					<tr class="warning">
						<th colspan="2" class="text-center">COST COMPONENTS</th>
						<th class="text-center">Sem 1</th>
						<th class="text-center">Sem 2</th>
						<th class="text-center">Total (P)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="text-center" style="width: 5%;">A.</th>
						<td style="width: 35%">Land Preparation</td>
						<td class="text-right" style="width: 20%">{{number_format($land_preparation_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($land_preparation_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($land_preparation_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">B.</th>
						<td>Seed Pulling, Marking & Transplanting</td>
						<td class="text-right" style="width: 20%">{{number_format($seed_pulling_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($seed_pulling_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($seed_pulling_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">C.</th>
						<td>Chemicals & Fertilizers</td>
						<td class="text-right" style="width: 20%">{{number_format($fertilizer_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($fertilizer_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($fertilizer_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">D.</th>
						<td>Harvesting</td>
						<td class="text-right" style="width: 20%">{{number_format($harvesting_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($harvesting_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($harvesting_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">E.</th>
						<td>Drying</td>
						<td class="text-right" style="width: 20%">{{number_format($drying_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($drying_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($drying_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">F.</th>
						<td>Seed Cleaning</td>
						<td class="text-right" style="width: 20%">{{number_format($seed_cleaning_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($seed_cleaning_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($seed_cleaning_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">G.</th>
						<td>Service Contractors</td>
						<td class="text-right" style="width: 20%">{{number_format($service_contract_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($service_contract_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($service_contract_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">H.</th>
						<td>Planting Materials</td>
						<td class="text-right" style="width: 20%">{{number_format($planting_material_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($planting_material_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($planting_material_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">I.</th>
						<td>Field Supplies</td>
						<td class="text-right" style="width: 20%">{{number_format($field_supplies_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($field_supplies_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($field_supplies_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">J.</th>
						<td>Fuel, Oil and Lubricants</td>
						<td class="text-right" style="width: 20%">{{number_format($fuel_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($fuel_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($fuel_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">K.</th>
						<td>Irrigation Fee</td>
						<td class="text-right" style="width: 20%">{{number_format($irrigation_fees_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($irrigation_fees_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($irrigation_fees_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">L.</th>
						<td>Seed Laboratory Fee</td>
						<td class="text-right" style="width: 20%">{{number_format($seed_laboratory->amount_s1, 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($seed_laboratory->amount_s2, 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($seed_laboratory->amount_s1 + $seed_laboratory->amount_s2, 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">M.</th>
						<td>Land Rental</td>
						<td class="text-right" style="width: 20%">{{number_format($land_rental_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($land_rental_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($land_rental_component), 2)}}</td>
					</tr>
					<tr>
						<th class="text-center">N.</th>
						<td>Seed Production Contracting</td>
						<td class="text-right" style="width: 20%">{{number_format($production_contracting_component[0], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format($production_contracting_component[1], 2)}}</td>
						<td class="text-right" style="width: 20%">{{number_format(array_sum($production_contracting_component), 2)}}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="primary">
						<th colspan="2" class="text-right">TOTAL PRODUCTION COST (P)</th>
						<th class="text-right">{{number_format($production_cost_schedule->total_s1, 2)}}</th>
						<th class="text-right">{{number_format($production_cost_schedule->total_s2, 2)}}</th>
						<th class="text-right">{{number_format($production_cost_schedule->total_s1 + $production_cost_schedule->total_s2, 2)}}</th>
					</tr>
					<tr>
						<td></td>
						<td><i>
							@if ($production_cost_schedule->seed_production_type === "Inbred")
								Total FS-RS area (ha)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (AxR)")
								Total AxR area (ha)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (P and R)")
								Total P-line area (ha)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (S)")
								Total S-line area (ha)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (A)")
								Total AxB area (ha)
							@endif
						</i></td>
						<td class="text-right">{{number_format($production_cost_schedule->area1_s1, 2)}}</td>
						<td class="text-right">{{number_format($production_cost_schedule->area1_s2, 2)}}</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><i>
							@if ($production_cost_schedule->seed_production_type === "Inbred")
								Total BS-FS area (ha)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (AxR)")
								Total ___ area (ha)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (P and R)")
								Total R-line area (ha)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (S)")
								Total ___ area (ha)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (A)")
								Total ___ area (ha)
							@endif
						</i></td>
						<td class="text-right">{{number_format($production_cost_schedule->area2_s1, 2)}}</td>
						<td class="text-right">{{number_format($production_cost_schedule->area2_s2, 2)}}</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><i>
							@if ($production_cost_schedule->seed_production_type === "Inbred")
								Volume of clean seeds, FS-RS (kg)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (AxR)")
								Volume of clean seeds, F1 (kg)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (P and R)")
								Volume of clean seeds, P-line (kg)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (S)")
								Volume of clean seeds, S-line (kg)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (A)")
								Volume of clean seeds, A-line (kg)
							@endif
						</i></td>
						<td class="text-right"><i>{{number_format($production_cost_schedule->volume_clean1_s1, 2)}}</i></td>
						<td class="text-right"><i>{{number_format($production_cost_schedule->volume_clean1_s2, 2)}}</i></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><i>
							@if ($production_cost_schedule->seed_production_type === "Inbred")
								Volume of clean seeds, BS-FS (kg)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (AxR)")
								Volume of clean seeds, ___ (kg)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (P and R)")
								Volume of clean seeds, R-line (kg)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (S)")
								Volume of clean seeds, ___ (kg)
							@elseif ($production_cost_schedule->seed_production_type === "Hybrid (A)")
								Volume of clean seeds, ___ (kg)
							@endif
						</i></td>
						<td class="text-right"><i>{{number_format($production_cost_schedule->volume_clean2_s1, 2)}}</i></td>
						<td class="text-right"><i>{{number_format($production_cost_schedule->volume_clean2_s2, 2)}}</i></td>
						<td></td>
					</tr>
					<tr>
						<th class="primary"></th>
						<th class="text-right primary"><i>Total Clean Seeds Produced (kg)</i></th>
						<th class="text-right primary"><i>{{number_format($production_cost_schedule->volume_clean1_s1 + $production_cost_schedule->volume_clean2_s1, 2)}}</i></th>
						<th class="text-right primary"><i>{{number_format($production_cost_schedule->volume_clean1_s2 + $production_cost_schedule->volume_clean2_s2, 2)}}</i></th>
						<th></th>
					</tr>
					<tr>
						<th class="primary"></th>
						<th class="text-right primary"><i>Production Cost per Kilo (P/kg)</i></th>
						<th class="text-right primary"><i>{{number_format($production_cost_schedule->production_cost_kilo_s1, 2)}}</i></th>
						<th class="text-right primary"><i>{{number_format($production_cost_schedule->production_cost_kilo_s2, 2)}}</i></th>
						<th></th>
					</tr>
					<tr>
						<th class="primary"></th>
						<th class="text-right primary"><i>Production Cost per Hectare (P/ha)</i></th>
						<th class="text-right primary"><i>{{number_format($production_cost_schedule->production_cost_ha_s1, 2)}}</i></th>
						<th class="text-right primary"><i>{{number_format($production_cost_schedule->production_cost_ha_s2, 2)}}</i></th>
						<th></th>
					</tr>
				</tfoot>
			</table>

			<div class="row">
				<div class="col-lg-12 text-center mt-xl mb-xl">
					<a href="{{route('production_cost_schedule.exportToPDF', ['production_cost_id' => $production_cost_id])}}" class="btn btn-danger mr-md" target="_blank">Download as PDF</a>
					<a href="{{route('production_cost_schedule.exportToExcel', ['production_cost_id' => $production_cost_id])}}" class="btn btn-success">Download as Excel</a>
				</div>
			</div>
		</div>
	</section>
@endsection