<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Production Efficiency Report</title>

	<style>
		body {
			font-family: sans-serif;
			font-size: 12px;
		}

		.content, .content th, .content td {
			border: 1px solid black; 
		}

		.content {
			border-collapse: collapse;
		}

		@page {
			margin-top: 195px;
			margin-bottom:  40px;
			margin-left: 25px;
			margin-right: 25px;
		}

		header {
			position: fixed;
            height: 180px;
            top: -170px;
            left: 0px;
            right: 0px;
		}

		footer {
			position: fixed; 
            bottom: -10px; 
            left: 0px; 
            right: 0px;
            height: 25px; 
		}
	</style>
</head>
<body>
	<header>
		<table class="logo" style="width: 100%;">
			<tr>
				<td>
					<img src="<?php echo $_SERVER['DOCUMENT_ROOT'] . '/seed_production_planner/public/images/PRRI-BDD.png' ?>" alt="" style="">
				</td>
				<td>
					<img src="<?php echo $_SERVER['DOCUMENT_ROOT'] . '/seed_production_planner/public/images/Socotec-logo.png' ?>" alt="" style="height: 75px; padding-left: 145px;">
				</td>
			</tr>
		</table>

		<table class="header" style="width: 100%;">
			<tr>
				<td colspan="10" style="font-size: 20; text-align: center; font-weight: bold; padding-bottom: 10px;">
					SEED PRODUCTION EFFICIENCY REPORT
				</td>
			</tr>

			<tr>
				<td>Branch:</td>
				<td>
					@if($station == "All PhilRice Branch and Satellite Stations")
						{{$station}}
					@else
						{{$station->name}}
					@endif
				</td>
			</tr>

			<tr>
				<td>Year/Semester:</td>
				<td>{{$year}} {{($sem == 1) ? "1st Sem" : "2nd Sem"}}</td>
				<td>Months Covered:</td>
				<td>
					@if ($sem == 1)
						1st Semester (Sept 16-Mar 15)
					@else
						2nd Semester (Mar 16-Sept 15)
					@endif
				</td>
			</tr>
		</table>
	</header>

	<footer>
		<hr>
		<table class="footer" style="width: 100%;">
			<tr>
				<td style="font-size: 10px; text-align: right;">
					Generated using Seed Production Planner by: {{Auth::user()->fullname}} ({{date('M d, Y g:i A')}})<br />
					Rice Seed Information System (RSIS)
				</td>
			</tr>
		</table>
	</footer>

	<table class="content" style="width: 100%;">
		<thead>
			<tr>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;" class="text-center" rowspan="2">Variety</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;" class="text-center" rowspan="2">Seed Class <br> Planted</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 6%;" class="text-center" rowspan="2">Lot No.</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 7%;" class="text-center" rowspan="2">Date of Harvest</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 7%;" class="text-center" rowspan="2">Date <br> Sampled</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 7%;" class="text-center" rowspan="2">RSO No. <br> by NSQCS</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 6%;" class="text-center" rowspan="2">Produced <br> by</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 40%;" class="text-center" colspan="5">RESULT, kg</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 7%;" class="text-center" rowspan="2">Date Released</th>
			</tr>
			<tr>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;" class="text-center">FS</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;" class="text-center">RS</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;" class="text-center">CS</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;" class="text-center">Reject</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;" class="text-center">Total</th>
			</tr>
		</thead>
		<tbody>
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
						<td style="border: 1px solid #000; text-align: right;">{{number_format($item['fs'], 2)}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{number_format($item['rs'], 2)}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{number_format($item['cs'], 2)}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{number_format($item['reject'], 2)}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{number_format($item['total'], 2)}}</td>
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
				<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="fs_total">{{number_format($fs_total, 2)}}</th>
				<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="rs_total">{{number_format($rs_total, 2)}}</th>
				<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="cs_total">{{number_format($cs_total, 2)}}</th>
				<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="reject_total">{{number_format($reject_total, 2)}}</th>
				<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" class="text-right" id="grand_total">{{number_format($grand_total, 2)}}</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			</tr>
			<tr>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
				<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" colspan="3">Seed production efficiency %</th>
				<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" id="fs_efficiency">{{number_format($fs_seed_eff, 2)}}</th>
				<th style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #C4D69B;" id="rs_efficiency">{{number_format($rs_seed_eff, 2)}}</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B;"></th>
			</tr>
		</tbody>
	</table>

	<table class="footer" style="width: 100%; margin-top: 40px; margin-bottom: 40px;">
		@if ($station != "All PhilRice Branch and Satellite Stations")
			<tr>
				@if ($station->philrice_station_id == 15 || $station->philrice_station_id == 16 || $station->philrice_station_id == 17 || $station->philrice_station_id == 18)
					<td style="width: 32%; padding-bottom: 25px;">Prepared by:</td>
				@elseif ($prepared->full_name == $certified->full_name)
					<td style="width: 32%; padding-bottom: 25px;">Prepared by:</td>
				@else
					<td style="width: 32%; padding-bottom: 25px;">Prepared by:</td>
					<td style="width: 34%; padding-bottom: 25px;">Certified by:</td>
				@endif		
				<td style="width: 34%; padding-bottom: 25px;">Approved by:</td>
			</tr>

			<tr>
				@if ($station->philrice_station_id != 15 && $station->philrice_station_id != 16 && $station->philrice_station_id != 17 && $station->philrice_station_id != 18)
					@if ($prepared->full_name == $certified->full_name)
						<td style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
					@else
						<td style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
						<td style="font-weight: bold;">{{($certified) ? $certified->full_name : ""}}</td>
					@endif

				@else
					<td style="font-weight: bold;">{{($prepared) ? $prepared->full_name : ""}}</td>
				@endif
				<td style="font-weight: bold;">{{($approved) ? $approved->full_name : ""}}</td>
			</tr>

			<tr>
				@if ($station->philrice_station_id != 15 && $station->philrice_station_id != 16 && $station->philrice_station_id != 17 && $station->philrice_station_id != 18)
					@if ($prepared->full_name == $certified->full_name)
						<td style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
					@else
						<td style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
						<td style="font-style: italic;">{{($certified) ? $certified->designation : ""}}</td>
					@endif
				@else 
					<td style="font-style: italic;">{{($prepared) ? $prepared->designation : ""}}</td>
				@endif
				<td style="font-style: italic;">{{($approved) ? $approved->designation : ""}}</td>
			</tr>
		@else
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		@endif
	</table>
</body>
</html>