<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Processing Report</title>

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
					PROCESSING REPORT
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
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 6%;" rowspan="2">Station</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 11%;" rowspan="2">Variety</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;" rowspan="2">Seed Class <br> Planted</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 16%;" colspan="2">Fresh</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 16%;" colspan="2">Dried</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 33%;" colspan="3">Weight After Cleaning</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;" rowspan="2">Remarks</th>
			</tr>
			<tr>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;">Wt., kg</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;">MC, %</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;">Wt., kg</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 8%;">MC, %</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 11%;">Filled, kg</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 11%;">Half-filled, kg</th>
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 11%;">Unfilled, kg</th>
			</tr>
		</thead>
		<tbody>
			@if(count($data) > 0)
				@foreach($data as $item)
					<tr>
						<td style="border: 1px solid #000; text-align: center;">{{$item['station']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['variety']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['seed_class']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['fresh_weight']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['fresh_moisture_content']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['dried_weight']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['dried_moisture_content']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['filled_weight']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['half_filled_weight']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['unfilled_weight']}}</td>
						<td style="border: 1px solid #000;">{{$item['remarks']}}</td>
					</tr>
				@endforeach
			@endif
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