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
				HARVESTING REPORT
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
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 30;">Date of Harvest</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 30;">Weight of Fresh Harvest, kg</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 30;">MC, %</td>
			<td style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #C4D69B; width: 30;">Remarks</td>
		</tr>

		@if(count($data) > 0)
			@foreach($data as $item)
				<tr>
					<td style="border: 1px solid #000; text-align: center;">{{$item['station']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['variety']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['ecosystem']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['maturity']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['seed_class']}}</td>
					<td style="border: 1px solid #000; text-align: right;">{{$item['area']}}</td>
					<td style="border: 1px solid #000; text-align: center;">{{$item['harvest_date']}}</td>
					<td style="border: 1px solid #000; text-align: right;">{{$item['weight']}}</td>
					<td style="border: 1px solid #000; text-align: right;">{{$item['moisture_content']}}</td>
					<td style="border: 1px solid #000;">{{$item['remarks']}}</td>
				</tr>
			@endforeach
		@endif

		@if(count($total_area_bs) > 0)
			<tr>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">Total Area Harvested for BS Production</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($total_area_bs, 2)}}</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">Total</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($total_weight_bs, 2)}}</td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
			</tr>
		@endif

		@if(count($total_area_fs) > 0)
			<tr>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">Total Area Harvested for FS Production</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($total_area_fs, 2)}}</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">Total</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($total_weight_fs, 2)}}</td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
			</tr>
		@endif

		@if(count($total_area_rs) > 0)
			<tr>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">Total Area Harvested for RS Production</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($total_area_rs, 2)}}</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">Total</td>
				<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($total_weight_rs, 2)}}</td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
				<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
			</tr>
		@endif

		<tr>
			<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
			<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
			<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
			<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
			<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">Total Area Harvested</td>
			<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($total_area, 2)}}</td>
			<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">Total</td>
			<td style="border: 1px solid #000; background-color: #C4D69B; text-align: right; font-weight: bold;">{{number_format($total_weight, 2)}}</td>
			<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
			<td style="border: 1px solid #000; background-color: #C4D69B;"></td>
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