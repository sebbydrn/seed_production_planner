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
			<td>
				<img src="public/images/Socotec-logo.png" alt="" height="80">
			</td>
		</tr>

		<tr>
			<td colspan="10" style="font-size: 24; text-align: center; font-weight: bold;">
				PLANTING PLAN
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
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 10;">Station</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 25;">Variety</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 35;">Ecosystem</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 20;">Maturity (DAS)</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 20;">Seed Class Planted</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 20;">Area, ha</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 30;">Expected Date of Sowing</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 30;">Expected Date of Transplanting</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 30;">Expected Date of Harvest</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 30;">Remarks</td>
		</tr>

		@php
			$breederTotalArea = 0; // total breeder seed production area
			$foundationTotalArea = 0; // total foundation seed production area
			$registeredTotalArea = 0; // total registered seed production area
			$totalArea = 0; // total seed production area
		@endphp

		@if(count($breederPlantingPlan) > 0)
			<tr>
				<td colspan="10" style="border: 1px solid #000; font-weight: bold; background-color: #C4D9F1;">BREEDER SEED PRODUCTION</td>
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

		<tr></tr>
		
		{{-- <tr>
			<td colspan="9" style="font-style: italic;">* Must be submitted to PhilRice CES within 2 weeks after transplanting</td>
		</tr> --}}

		{{-- <tr></tr>

		<tr>
			<td colspan="9" style="font-style: italic;">Note: Data on the first five columns should be consistent with the first 5 columns of the harvesting report</td>
		</tr> --}}

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