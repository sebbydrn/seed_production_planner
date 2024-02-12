<table>
	<tbody>
		<tr>
			<td>
				<img src="public/images/PRRI-BDD.png" alt="" style="">
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td colspan="5" style="font-size: 16; text-align: center; font-weight: bold;">
				PROJECTED SEED PRODUCTION COST
			</td>
		</tr>

		<tr>
			<td colspan="5" style="font-size: 14; text-align: center;">
				{{$station->name}}<br>
				{{$production_cost_schedule->year}} Semester 1 & 2
			</td>
		</tr>

		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="5"><strong>I. PRODUCTION COST SCHEDULE</strong></td>
		</tr>
		<tr>
			<td colspan="2" style="width: 50%;"><strong>Cost Components/Activities</strong></td>
			<td style="width: 15%; text-align: center;"><strong>Area (ha)</strong></td>
			<td style="width: 15%; text-align: center;"><strong>Cost per ha (P)</strong></td>
			<td style="width: 20%; text-align: center;"><strong>Amount (P)</strong></td>
		</tr>

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

		<tr>
			<td colspan="2"><strong>A. Land Preparation (3 passing)</strong></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		@foreach ($land_preparation as $item)
			<tr>
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td colspan="2">a. Custom Services for Rotovation/ Plowing/ Harrowing</td>
				<td style="text-align: right;">{{number_format($item->rotovate_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->rotovate_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->rotovate_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="2">b. Field Levelling</td>
				<td style="text-align: right;">{{number_format($item->levelling_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->levelling_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->levelling_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: right;"><strong>Sub Total Sem {{$item->sem}}</strong></td>
				<td style="text-align: right;"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
			</tr>

			@php
				array_push($land_preparation_component, $item->sub_total);
			@endphp
		@endforeach

		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($land_preparation_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>B. Seed Pulling, Marking & Transplanting</strong></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		@foreach ($seed_pulling as $item)
			<tr>
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td colspan="2">Seed Pulling, Marking & Transplanting</td>
				<td style="text-align: right;">{{number_format($item->pulling_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->pulling_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->pulling_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;">{{number_format($item->replanting_labor_no)}}</td>
				<td>Emergency labor for replanting of missed hills, and repair of dikes</td>
				<td style="text-align: right;">{{number_format($item->replanting_labor_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->replanting_labor_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->replanting_labor_amount, 2)}}</td>
			</tr>

			@php
				array_push($seed_pulling_component, ($item->pulling_amount + $item->replanting_labor_amount));
			@endphp
		@endforeach
		
		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($seed_pulling_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>C. Chemicals & Fertilizers</strong></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		@foreach($fertilizers as $item)
			<tr>
				<td colspan="2">Sem {{$loop->iteration}}</td>
				<td style="text-align: right;">{{number_format($item->area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->amount, 2)}}</td>
			</tr>

			@php
				array_push($fertilizer_component, $item->amount);
			@endphp
		@endforeach

		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($fertilizer_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>D. Harvesting</strong></td>
			<td style="text-align: center;"><strong>Quantity</strong></td>
			<td style="text-align: center;"><strong>Unit Cost (P)</strong></td>
			<td style="text-align: center;"><strong>Amount (P)</strong></td>
		</tr>

		@foreach($harvesting as $item)
			<tr>
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td style="text-align: center;"><i>No. of ha</i></td>
				<td style="text-align: center;"><i>Per ha</i></td>
				<td></td>
			</tr>
			<tr>
				<td style="text-align: right;">a.1</td>
				<td>Manual</td>
				<td style="text-align: right;">{{number_format($item->manual_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->manual_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->manual_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;">a.2</td>
				<td>Mechanical (combine harvester)</td>
				<td style="text-align: right;">{{number_format($item->mechanical_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->mechanical_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->mechanical_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;">b.</td>
				<td>Hauling</td>
				<td style="text-align: center;"><i>No. of bags</i></td>
				<td style="text-align: center;"><i>Per bag</i></td>
				<td style="text-align: right;"></td>
			</tr>
			<tr>
				<td style="text-align: right;">{{number_format($item->hauling_ave_bags)}}</td>
				<td><i>average 50-kg bags (fresh harvest) per ha</i></td>
				<td style="text-align: right;">{{number_format($item->hauling_bags_no)}}</td>
				<td style="text-align: right;">{{number_format($item->hauling_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->hauling_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td style="text-align: center;"><i>No. of ha</i></td>
				<td style="text-align: center;"><i>Per ha</i></td>
				<td></td>
			</tr>
			<tr>
				<td style="text-align: right;">c.</td>
				<td>Threshing (manual harvest)</td>
				<td style="text-align: right;">{{number_format($item->threshing_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->threshing_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->threshing_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;">d.</td>
				<td>Towing of Thresher</td>
				<td style="text-align: right;">{{number_format($item->towing_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->towing_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->towing_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;">e.</td>
				<td>Hay Scattering</td>
				<td style="text-align: right;">{{number_format($item->scatter_area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->scatter_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->scatter_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: right;"><strong>Sub Total Sem {{$item->sem}}</strong></td>
				<td style="text-align: right;">{{number_format($item->sub_total, 2)}}</td>
			</tr>


			<tr>
				<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
				<td style="text-align: right;"><strong>{{number_format(array_sum($harvesting_component), 2)}}</strong></td>
			</tr>

			@php
				array_push($harvesting_component, $item->sub_total);
			@endphp
		@endforeach

		<tr>
			<td colspan="2"><strong>E. Drying</strong></td>
			<td style="text-align: center;"><strong>Quantity</strong></td>
			<td style="text-align: center;"><strong>Unit Cost (P)</strong></td>
			<td style="text-align: center;"><strong>Amount (P)</strong></td>
		</tr>

		@foreach($drying as $item)
			<tr>
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td style="text-align: center;"><i>No. of bags</i></td>
				<td style="text-align: center;"><i>Per bag</i></td>
				<td></td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
				<td>Drying fee</td>
				<td style="text-align: right;">{{number_format($item->drying_bags_no, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->drying_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->drying_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td style="text-align: center;"><i>No. of days</i></td>
				<td style="text-align: center;"><i>Per day</i></td>
				<td></td>
			</tr>
			<tr>
				<td style="text-align: right;">{{number_format($item->emergency_labor_no)}}</td>
				<td>No. of emergency laborers, if any</td>
				<td style="text-align: right;">{{number_format($item->emergency_labor_days)}}</td>
				<td style="text-align: right;">{{number_format($item->emergency_labor_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->emergency_labor_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: right;"><strong>Sub Total Sem {{$item->sem}}</strong></td>
				<td style="text-align: right;"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
			</tr>

			@php
				array_push($drying_component, $item->sub_total);
			@endphp
		@endforeach

		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($drying_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>F. Seed Cleaning</strong></td>
			<td style="text-align: center;"><strong>Quantity (bags)</strong></td>
			<td style="text-align: center;"><strong>Unit Cost (P)</strong></td>
			<td style="text-align: center;"><strong>Amount (P)</strong></td>
		</tr>

		@foreach($seed_cleaning as $item)
			<tr>
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td style="text-align: right;">{{number_format($item->ave_bags)}}</td>
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
				<td style="text-align: right;">{{number_format($item->bags_no)}}</td>
				<td style="text-align: right;">{{number_format($item->cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->amount, 2)}}</td>
			</tr>

			@php
				array_push($seed_cleaning_component, $item->amount);
			@endphp
		@endforeach

		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($seed_cleaning_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2">G. Service Contractors</td>
			<td style="text-align: center;">Monthly Rate (P)</td>
			<td style="text-align: center;">Monthly Cost (P)</td>
			<td style="text-align: center;">Amount (P)</td>
		</tr>

		@foreach($service_contracts as $item)
			<tr>
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
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
					<td style="text-align: right;">{{number_format($pos->contract_no)}}</td>
					<td>no. of {{$pos->position}}</td>
					<td style="text-align: right;">{{number_format($pos->monthly_rate, 2)}}</td>
					<td style="text-align: right;">{{number_format($pos->monthly_cost, 2)}}</td>
					<td style="text-align: right;">{{number_format($pos->amount, 2)}}</td>
				</tr>

				@php
					$monthly_rate_total += $pos->monthly_cost;
				@endphp
			@endforeach

			<tr>
				<td colspan="3" style="text-align: right;"><strong>Sub Total Sem {{$item->sem}}</strong></td>
				<td style="text-align: right;"><strong>{{number_format($monthly_rate_total, 2)}}</strong></td>
				<td style="text-align: right;"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
			</tr>

			@php
				array_push($service_contract_component, $item->sub_total);
			@endphp
		@endforeach

		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($service_contract_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>H. Planting Materials</strong></td>
			<td style="text-align: center;"><strong>Seeds (kg)</strong></td>
			<td style="text-align: center;"><strong>Unit Cost (P)</strong></td>
			<td style="text-align: center;"><strong>Amount (P)</strong></td>
		</tr>

		<tr>
			<td style="text-align: right;">{{number_format($seeding_rate->seeding_rate)}}</td>
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
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td style="text-align: right;">{{number_format($item->area1, 2)}}</td>
				<td><i>{{$area1_label}}</i></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="text-align: right;">{{number_format($item->area2, 2)}}</td>
				<td><i>{{$area2_label}}</i></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
				<td>Planting Materials for RS Production</td>
				<td style="text-align: right;">{{number_format($item->area1_seed_quantity, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->area1_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->area1_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
				<td>Planting Materials for FS Production</td>
				<td style="text-align: right;">{{number_format($item->area2_seed_quantity, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->area2_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->area2_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: right;"><strong>Sub Total Sem {{$item->sem}}</strong></td>
				<td style="text-align: right;"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
			</tr>

			@php
				array_push($planting_material_component, $item->sub_total);
			@endphp
		@endforeach
		
		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($planting_material_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>I. Field Supplies</strong></td>
			<td style="text-align: center;"><strong>No. of Sacks</strong></td>
			<td style="text-align: center;"><strong>Cost per Sack (P)</strong></td>
			<td style="text-align: center;"><strong>Amount (P)</strong></td>
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
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
				<td>{{$sack1_label}}</td>
				<td style="text-align: right;">{{number_format($item->sack1_no)}}</td>
				<td style="text-align: right;">{{number_format($item->sack1_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->sack1_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
				<td>{{$sack2_label}}</td>
				<td style="text-align: right;">{{number_format($item->sack2_no)}}</td>
				<td style="text-align: right;">{{number_format($item->sack2_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->sack2_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
				<td>Ordinary 50-kg sacks for fresh harvest</td>
				<td style="text-align: right;">{{number_format($item->sack3_no)}}</td>
				<td style="text-align: right;">{{number_format($item->sack3_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->sack3_amount, 2)}}</td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
				<td>Other Field Supplies</td>
				<td></td>
				<td></td>
				<td style="text-align: right;">{{number_format($item->other_supplies_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: right;"><strong>Sub Total Sem {{$item->sem}}</strong></td>
				<td style="text-align: right;"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
			</tr>

			@php
				array_push($field_supplies_component, $item->sub_total);
			@endphp
		@endforeach
	
		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($field_supplies_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>J. Fuel, Oil and Lubricants</strong></td>
			<td style="text-align: center;"><strong>Liters per ha</strong></td>
			<td style="text-align: center;"><strong>Cost per Liter (P)</strong></td>
			<td style="text-align: center;"><strong>Amount (P)</strong></td>
		</tr>

		@foreach($fuel as $item)
			<tr>
				<td colspan="5">Sem {{$item->sem}}</td>
			</tr>
			<tr>
				<td style="text-align: right;"></td>
				<td><i>Total serviceable area</i></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td>Diesel consumption per ha</td>
				<td style="text-align: right;">{{number_format($item->diesel_liters, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->diesel_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->diesel_amount, 2)}}</td>
			</tr>
			<tr>
				<td></td>
				<td>Gasoline consumption per ha</td>
				<td style="text-align: right;">{{number_format($item->gas_liters, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->gas_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->gas_amount, 2)}}</td>
			</tr>
			<tr>
				<td></td>
				<td>Kerosene consumption per ha</td>
				<td style="text-align: right;">{{number_format($item->kerosene_liters, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->kerosene_cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->kerosene_amount, 2)}}</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: right;"><strong>Sub Total Sem {{$item->sem}}</strong></td>
				<td style="text-align: right;"><strong>{{number_format($item->sub_total, 2)}}</strong></td>
			</tr>

			@php
				array_push($fuel_component, $item->sub_total);
			@endphp
		@endforeach

		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($fuel_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>K. Irrigation Fees</strong></td>
			<td style="text-align: center;"><strong>Area (ha)</strong></td>
			<td style="text-align: center;"><strong>Cost per ha (P)</strong></td>
			<td style="text-align: center;"><strong>Amount (P)</strong></td>
		</tr>

		@foreach($irrigation as $item)
			<tr>
				<td></td>
				<td>Sem {{$item->sem}}</td>
				<td style="text-align: right;">{{number_format($item->area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->amount, 2)}}</td>
			</tr>

			@php
				array_push($irrigation_fees_component, $item->amount);
			@endphp
		@endforeach
		
		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($irrigation_fees_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2">L. Seed Laboratory Fees</td>
			<td style="text-align: center;"></td>
			<td style="text-align: center;"></td>
			<td style="text-align: center;">Amount (P)</td>
		</tr>
		
		<tr>
			<td></td>
			<td>Sem 1</td>
			<td style="text-align: right;"></td>
			<td style="text-align: right;"></td>
			<td style="text-align: right;">{{number_format($seed_laboratory->amount_s1, 2)}}</td>
		</tr>

		<tr>
			<td></td>
			<td>Sem 2</td>
			<td style="text-align: right;"></td>
			<td style="text-align: right;"></td>
			<td style="text-align: right;">{{number_format($seed_laboratory->amount_s2, 2)}}</td>
		</tr>

		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</h4></td>
			<td style="text-align: right;"><strong>{{number_format($seed_laboratory->amount_s1 + $seed_laboratory->amount_s2, 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2">M. Land Rental</td>
			<td style="text-align: center;">Area (ha)</td>
			<td style="text-align: center;">Cost per ha (P)</td>
			<td style="text-align: center;">Amount (P)</td>
		</tr>

		@foreach($land_rental as $item)
			<tr>
				<td></td>
				<td>Sem {{$item->sem}}</td>
				<td style="text-align: right;">{{number_format($item->area, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->cost, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->amount, 2)}}</td>
			</tr>

			@php
				array_push($land_rental_component, $item->amount);
			@endphp
		@endforeach
		
		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($land_rental_component), 2)}}</strong></td>
		</tr>

		<tr>
			<td colspan="2"><strong>N. Seed Production Contracting (if any)</strong></td>
			<td style="text-align: center;"><strong>Est. Volume of Seeds (kg)</strong></td>
			<td style="text-align: center;"><strong>Buying Price per kg</strong></td>
			<td style="text-align: center;"><strong>Amount (P)</strong></td>
		</tr>

		@foreach($production_contracting as $item)
			<tr>
				<td></td>
				<td>Sem {{$item->sem}}</td>
				<td style="text-align: right;">{{number_format($item->seed_volume, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->buying_price, 2)}}</td>
				<td style="text-align: right;">{{number_format($item->amount, 2)}}</td>
			</tr>

			@php
				array_push($production_contracting_component, $item->amount);
			@endphp
		@endforeach
		
		<tr>
			<td colspan="4" style="text-align: right;"><strong>TOTAL</strong></td>
			<td style="text-align: right;"><strong>{{number_format(array_sum($production_contracting_component), 2)}}</strong></td>
		</tr>

		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="5"><strong>II. PRODUCTION COST SUMMARY</strong></td>
		</tr>

		<tr>
			<td colspan="2" style="text-align: center">COST COMPONENTS</td>
			<td style="text-align: center">Sem 1</td>
			<td style="text-align: center">Sem 2</td>
			<td style="text-align: center">Total (P)</td>
		</tr>

		<tr>
			<td style="text-align: center; width: 5%;">A.</td>
			<td style="width: 35%">Land Preparation</td>
			<td style="width: 20%; text-align: right;">{{number_format($land_preparation_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($land_preparation_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($land_preparation_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">B.</td>
			<td>Seed Pulling, Marking & Transplanting</td>
			<td style="width: 20%; text-align: right;">{{number_format($seed_pulling_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($seed_pulling_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($seed_pulling_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">C.</td>
			<td>Chemicals & Fertilizers</td>
			<td style="width: 20%; text-align: right;">{{number_format($fertilizer_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($fertilizer_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($fertilizer_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">D.</td>
			<td>Harvesting</td>
			<td style="width: 20%; text-align: right;">{{number_format($harvesting_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($harvesting_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($harvesting_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">E.</td>
			<td>Drying</td>
			<td style="width: 20%; text-align: right;">{{number_format($drying_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($drying_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($drying_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">F.</td>
			<td>Seed Cleaning</td>
			<td style="width: 20%; text-align: right;">{{number_format($seed_cleaning_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($seed_cleaning_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($seed_cleaning_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">G.</td>
			<td>Service Contractors</td>
			<td style="width: 20%; text-align: right;">{{number_format($service_contract_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($service_contract_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($service_contract_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">H.</td>
			<td>Planting Materials</td>
			<td style="width: 20%; text-align: right;">{{number_format($planting_material_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($planting_material_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($planting_material_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">I.</td>
			<td>Field Supplies</td>
			<td style="width: 20%; text-align: right;">{{number_format($field_supplies_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($field_supplies_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($field_supplies_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">J.</td>
			<td>Fuel, Oil and Lubricants</td>
			<td style="width: 20%; text-align: right;">{{number_format($fuel_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($fuel_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($fuel_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">K.</td>
			<td>Irrigation Fee</td>
			<td style="width: 20%; text-align: right;">{{number_format($irrigation_fees_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($irrigation_fees_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($irrigation_fees_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">L.</td>
			<td>Seed Laboratory Fee</td>
			<td style="width: 20%; text-align: right;">{{number_format($seed_laboratory->amount_s1, 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($seed_laboratory->amount_s2, 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($seed_laboratory->amount_s1 + $seed_laboratory->amount_s2, 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">M.</td>
			<td>Land Rental</td>
			<td style="width: 20%; text-align: right;">{{number_format($land_rental_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($land_rental_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($land_rental_component), 2)}}</td>
		</tr>
		<tr>
			<td style="text-align: center;">N.</td>
			<td>Seed Production Contracting</td>
			<td style="width: 20%; text-align: right;">{{number_format($production_contracting_component[0], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format($production_contracting_component[1], 2)}}</td>
			<td style="width: 20%; text-align: right;">{{number_format(array_sum($production_contracting_component), 2)}}</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;"><strong>TOTAL PRODUCTION COST (P)</strong></td>
			<td style="text-align: right;"><strong>{{number_format($production_cost_schedule->total_s1, 2)}}</strong></td>
			<td style="text-align: right;"><strong>{{number_format($production_cost_schedule->total_s2, 2)}}</strong></td>
			<td style="text-align: right;"><strong>{{number_format($production_cost_schedule->total_s1 + $production_cost_schedule->total_s2, 2)}}</strong></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: right;"><i>
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
			<td style="text-align: right;">{{number_format($production_cost_schedule->area1_s1, 2)}}</td>
			<td style="text-align: right;">{{number_format($production_cost_schedule->area1_s2, 2)}}</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: right;"><i>
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
			<td style="text-align: right;">{{number_format($production_cost_schedule->area2_s1, 2)}}</td>
			<td style="text-align: right;">{{number_format($production_cost_schedule->area2_s2, 2)}}</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: right;"><i>
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
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->volume_clean1_s1, 2)}}</i></td>
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->volume_clean1_s2, 2)}}</i></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: right;"><i>
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
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->volume_clean2_s1, 2)}}</i></td>
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->volume_clean2_s2, 2)}}</i></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: right;"><i>Total Clean Seeds Produced (kg)</i></td>
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->volume_clean1_s1 + $production_cost_schedule->volume_clean2_s1, 2)}}</i></td>
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->volume_clean1_s2 + $production_cost_schedule->volume_clean2_s2, 2)}}</i></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: right;"><i>Production Cost per Kilo (P/kg)</i></td>
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->production_cost_kilo_s1, 2)}}</i></td>
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->production_cost_kilo_s2, 2)}}</i></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: right;"><i>Production Cost per Hectare (P/ha)</i></td>
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->production_cost_ha_s1, 2)}}</i></td>
			<td style="text-align: right;"><i>{{number_format($production_cost_schedule->production_cost_ha_s2, 2)}}</i></td>
			<td></td>
		</tr>

		<tr></tr>
		<tr></tr>

		<tr>
			<td style="width: 32%; padding-bottom: 25px;">Prepared by:</td>
			<td style="width: 34%; padding-bottom: 25px;">Reviewed by:</td>
			<td style="width: 34%; padding-bottom: 25px;">Approved by:</td>
		</tr>
		<tr>
			@if ($station->philrice_station_id != 15 && $station->philrice_station_id != 16 && $station->philrice_station_id != 17 && $station->philrice_station_id != 18)
				@if ($prepared->full_name == $reviewed->full_name)
					<td style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
				@else
					<td style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
					<td style="font-weight: bold;">{{($reviewed) ? $reviewed->full_name : ""}}</td>
				@endif

			@else
				<td style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
			@endif
			<td style="font-weight: bold;">{{($approved) ? $approved->full_name : ""}}</td>
		</tr>

		<tr>
			@if ($station->philrice_station_id != 15 && $station->philrice_station_id != 16 && $station->philrice_station_id != 17 && $station->philrice_station_id != 18)
				@if ($prepared->full_name == $reviewed->full_name)
					<td style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
				@else
					<td style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
					<td style="font-style: italic;">{{($reviewed) ? $reviewed->designation : ""}}</td>
				@endif
			@else 
				<td style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
			@endif
			<td style="font-style: italic;">{{($approved) ? $approved->designation : ""}}</td>
		</tr>

		<tr>
			<td>Date:</td>
			<td>Date:</td>
			<td>Date:</td>
		</tr>

		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="10" style="font-style: italic; font-size: 9px;">Generated using Seed Production Planner by: {{Auth::user()->fullname}} ({{date('M d, Y g:i A')}})</td>
		</tr>
		<tr>
			<td colspan="10" style="font-style: italic; font-size: 9px;">Rice Seed Information System (RSIS)</td>
		</tr>

		<tr></tr>
	</tbody>
</table>