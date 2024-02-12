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
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				<img src="public/images/Socotec-logo.png" alt="" height="80">
			</td>
		</tr>

		<tr>
			<td colspan="13" style="font-size: 24; text-align: center; font-weight: bold;">
				PRODUCTION EFFICIENCY REPORT
			</td>
		</tr>

		<tr>
			<td colspan="2">Branch:</td>
			<td colspan="2">
				@if($station == "All PhilRice Branch and Satellite Stations")
					{{$station}}
				@else
					{{$station->name}}
				@endif
			</td>
		</tr>

		<tr>
			<td colspan="2">Year/Semester:</td>
			<td colspan="2">{{$year}} {{($sem == 1) ? "1st Sem" : "2nd Sem"}}</td>
			<td colspan="2">Months Covered:</td>
			<td colspan="2">
				@if ($sem == 1)
					1st Semester (Sept 16-Mar 15)
				@else
					2nd Semester (Mar 16-Sept 15)
				@endif
			</td>
		</tr>

		<tr></tr>

		<tr>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 25; text-align: center;">Variety</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 25; text-align: center;">Seed Class Planted</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">Lot No.</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">Date of Harvest</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">Date Sampled</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">RSO No. by NSQCS</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 15; text-align: center;">Produced by</td>
			<td colspan="5" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center;">RESULT, kg</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">Date Released</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">FS</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">RS</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">CS</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">Reject</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; width: 20; text-align: center;">Total</td>
			<td></td>
		</tr>
		<?php 
			$fs_total = 0;
			$rs_total = 0;
			$cs_total = 0;
			$reject_total = 0;
			$grand_total = 0;
			$fs_weight_sampled_total = 0;
			$rs_weight_sampled_total = 0;
		?>

		@if(count($data) > 0)
			@foreach($data as $item)
				<tr>
					<td style="border: 1px solid #000; text-align: center;">{{$item['variety']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['seed_class_planted']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['lot_no']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['date_harvested']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['date_sampled']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['lab_no']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['produced_by']}}</td>
					<td style="border: 1px solid #000; text-align: right;">{{$item['fs']}}</td>
					<td style="border: 1px solid #000; text-align: right;">{{$item['rs']}}</td>
					<td style="border: 1px solid #000; text-align: right;">{{$item['cs']}}</td>
					<td style="border: 1px solid #000; text-align: right;">{{$item['reject']}}</td>
					<td style="border: 1px solid #000; text-align: right;">{{$item['total']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['date_released']}}</td>
				</tr>

				<?php 
					$fs_total += $item['fs'];
					$rs_total += $item['rs'];
					$cs_total += $item['cs'];
					$reject_total += $item['reject'];
					$grand_total += $item['total'];
					$fs_weight_sampled_total += $item['fs_weight_sampled'];
					$rs_weight_sampled_total += $item['rs_weight_sampled'];
				?>
			@endforeach
		@endif

		<?php 
			$fs_seed_eff = ($fs_total / $fs_weight_sampled_total) * 100;
			$rs_seed_eff = ($rs_total / $rs_weight_sampled_total) * 100;
		?>
			
		<tr>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;" class="text-right">Total</th>
			<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="fs_total">{{$fs_total}}</th>
			<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="rs_total">{{$rs_total}}</th>
			<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="cs_total">{{$cs_total}}</th>
			<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="reject_total">{{$reject_total}}</th>
			<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="grand_total">{{$grand_total}}</th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
		</tr>
		<tr>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;">Seed production efficiency %</th>
			<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="fs_efficiency">{{$fs_seed_eff}}</th>
			<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="rs_efficiency">{{$rs_seed_eff}}</th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
		</tr>

		<tr></tr>

		<tr></tr>

		<tr></tr>

		@if ($station != "All PhilRice Branch and Satellite Stations")
			<tr>
				@if ($station->philrice_station_id == 15 || $station->philrice_station_id == 16 || $station->philrice_station_id == 17 || $station->philrice_station_id == 18)
					<td colspan="6">Prepared by:</td>
				@elseif ($prepared->full_name == $certified->full_name)
					<td colspan="6">Prepared by:</td>
				@else
					<td colspan="2">Prepared by:</td>
					<td colspan="4">Certified by:</td>
				@endif		
				<td colspan="3">Approved by:</td>
			</tr>

			<tr></tr>

			<tr>
				@if ($station->philrice_station_id != 15 && $station->philrice_station_id != 16 && $station->philrice_station_id != 17 && $station->philrice_station_id != 18)
					@if ($prepared->full_name == $certified->full_name)
						<td colspan="6" style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
					@else
						<td colspan="2" style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
						<td colspan="4" style="font-weight: bold;">{{($certified) ? $certified->full_name : ""}}</td>
					@endif

				@else
					<td colspan="6" style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
				@endif
				<td colspan="3" style="font-weight: bold;">{{($approved) ? $approved->full_name : ""}}</td>
			</tr>

			<tr>
				@if ($station->philrice_station_id != 15 && $station->philrice_station_id != 16 && $station->philrice_station_id != 17 && $station->philrice_station_id != 18)
					@if ($prepared->full_name == $certified->full_name)
						<td colspan="6" style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
					@else
						<td colspan="2" style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
						<td colspan="4" style="font-style: italic;">{{($certified) ? $certified->designation : ""}}</td>
					@endif
				@else 
					<td colspan="6" style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
				@endif
				<td colspan="3" style="font-style: italic;">{{($approved) ? $approved->designation : ""}}</td>
			</tr>
		@else
			<tr>
				<td colspan="2">Prepared by:</td>
				<td colspan="4">Certified by:</td>
				<td colspan="3">Approved by:</td>
			</tr>

			<tr></tr>

			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		@endif

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