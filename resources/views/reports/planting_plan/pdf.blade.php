<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Planting Plan</title>

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
					PLANTING PLAN
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
				<th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 5%;">Station</th>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 15%;">Variety</td>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;">Ecosystem</td>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;">Maturity (DAS)</td>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;">Seed Class Planted</td>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;">Area, ha</td>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;">Expected Date of Sowing</td>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;">Expected Date of Transplanting</td>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;">Expected Date of Harvest</td>
				<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10%;">Remarks</td>
			</tr>
		</thead>
		<tbody>
			@php
				$breederTotalArea = 0; // total breeder seed production area
				$foundationTotalArea = 0; // total foundation seed production area
				$registeredTotalArea = 0; // total registered seed production area
				$totalArea = 0; // total seed production area
			@endphp

			@if(count($breederPlantingPlan) > 0)
				<tr>
					<td colspan="10" style="border: 1px solid #000; font-weight: bold;">BREEDER SEED PRODUCTION</td>
				</tr>

				@foreach($breederPlantingPlan as $item)
					<tr>
						<td style="border: 1px solid #000; text-align: center;">{{$item['station']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['variety']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['ecosystem']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['maturity']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['seedClass']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['area']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['sowingDate']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['transplantingDate']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['harvestingDate']}}</td>
						<td style="border: 1px solid #000;">{{$item['remarks']}}</td>
					</tr>

					@php
						$breederTotalArea = $breederTotalArea + $item['area'];
					@endphp
				@endforeach
			@endif

			@if(count($foundationPlantingPlan) > 0)
				<tr>
					<td colspan="10" style="border: 1px solid #000; font-weight: bold; background-color: #C4D9F1;">FOUNDATION SEED PRODUCTION</td>
				</tr>

				@foreach($foundationPlantingPlan as $item)
					<tr>
						<td style="border: 1px solid #000; text-align: center;">{{$item['station']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['variety']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['ecosystem']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['maturity']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['seedClass']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['area']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['sowingDate']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['transplantingDate']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['harvestingDate']}}</td>
						<td style="border: 1px solid #000;">{{$item['remarks']}}</td>
					</tr>

					@php
						$foundationTotalArea = $foundationTotalArea + $item['area'];
					@endphp
				@endforeach
			@endif

			@if(count($registeredPlantingPlan) > 0)
				<tr>
					<td colspan="10" style="border: 1px solid #000; font-weight: bold; background-color: #C4D9F1;">REGISTERED SEED PRODUCTION</td>
				</tr>

				@foreach($registeredPlantingPlan as $item)
					<tr>
						<td style="border: 1px solid #000; text-align: center;">{{$item['station']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['variety']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['ecosystem']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['maturity']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['seedClass']}}</td>
						<td style="border: 1px solid #000; text-align: right;">{{$item['area']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['sowingDate']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['transplantingDate']}}</td>
						<td style="border: 1px solid #000; text-align: center;">{{$item['harvestingDate']}}</td>
						<td style="border: 1px solid #000;">{{$item['remarks']}}</td>
					</tr>

					@php
						$registeredTotalArea = $registeredTotalArea + $item['area'];
					@endphp
				@endforeach
			@endif

			@if(count($foundationPlantingPlan) > 0)
				<tr>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;" colspan="2" >Total Area for FS</td>
					<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($foundationTotalArea, 5)}}</td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				</tr>
			@endif

			@if(count($breederPlantingPlan) > 0)
				<tr>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;" colspan="2" >Total Area for BS</td>
					<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($breederTotalArea, 5)}}</td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				</tr>
			@endif

			@if(count($registeredPlantingPlan) > 0)
				<tr>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;" colspan="2" >Total Area for RS</td>
					<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($registeredTotalArea, 5)}}</td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
					<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				</tr>
			@endif

			<tr>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D9F1;"></td>
				<td style="border: 1px solid #000; background-color: #C4D9F1;"></td>
				<td style="border: 1px solid #000; background-color: #C4D9F1; text-align: right; font-weight: bold;" colspan="2" >Total Area Planted</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($breederTotalArea + $foundationTotalArea + $registeredTotalArea, 5)}}</td>
				<td style="border: 1px solid #000; background-color: #C4D9F1;"></td>
				<td style="border: 1px solid #000; background-color: #C4D9F1;"></td>
				<td style="border: 1px solid #000; background-color: #C4D9F1;"></td>
				<td style="border: 1px solid #000; background-color: #C4D9F1;"></td>
			</tr>
		</tbody>
	</table>

	<table class="footer" style="width: 100%; margin-top: 40px;">
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