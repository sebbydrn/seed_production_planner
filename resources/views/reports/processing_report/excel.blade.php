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
			<td>
				<img src="public/images/Socotec-logo.png" alt="" height="80">
			</td>
		</tr>

		<tr>
			<td colspan="11" style="font-size: 24; text-align: center; font-weight: bold;">
				PROCESSING REPORT
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
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 10;">Station</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 20;">Variety</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 20;">Seed Class Planted</td>
			<td colspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 30;">Fresh</td>
			<td colspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 30;">Dried</td>
			<td colspan="3" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 45;">Weight After Cleaning</td>
			<td rowspan="2" style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 25;">Remarks</td>
		</tr>
		<tr>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center;"></td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center;"></td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center;"></td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 15;">Wt., kg</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 15;">MC, %</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 15;">Wt., kg</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 15;">MC, %</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 15;">Filled, kg</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 15;">Half-filled, kg</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center; width: 15;">Unfilled, kg</td>
			<td style="border: 1px solid #000; font-weight: bold; background-color: #C4D69B; text-align: center;"></td>
		</tr>

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