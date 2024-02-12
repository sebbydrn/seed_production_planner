{{-- seed cleaning table --}}
<table class="table table-bordered service_contract_component" style="width: 100%;">
	{{-- service contractors --}}
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('service_contractors')">G. Service Contractors</th>
		<th class="text-center" onclick="toggle_element('service_contractors')">Monthly Rate (P)</th>
		<th class="text-center" onclick="toggle_element('service_contractors')">Monthly Cost (P)</th>
		<th class="text-center" onclick="toggle_element('service_contractors')">
			Amount (P)
			<span id="service_contractors_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="service_contract_s1">
		<tr class="service_contractors">
			<th colspan="5">Sem 1</th>
		</tr>
		<tr class="service_contractors months_hired_s1">
			<td>
				<input type="text" 
				class="form-control months"
				value="{{(isset($service_contracts)) ? number_format($service_contracts[0]['months_no']) : 6}}"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;"
				oninput="recompute_amount('s1')"
				>
			</td>
			<td><i>no. of months to be hired</i></td>
			<td></td>
			<td class="text-right">
				<button class="btn btn-danger btn-sm mb-xs remove_sc" style="display: none;" onclick="remove_service_contract_row('s1')">Remove Row</button>
				<button class="btn btn-primary btn-sm mb-xs" onclick="add_service_contract_row('s1')">Add Row</button>
			</td>
			<td class="text-right"></td>
		</tr>
		@if(isset($service_contracts))
			@php
				$monthly_cost_s1 = 0;
			@endphp

			@for($i = 0; $i < count($service_contracts[0]['positions']); $i++)
				@php
					$monthly_cost_s1 += $service_contracts[0]['positions'][$i]['monthly_cost'];
				@endphp

				<tr class="service_contractors positions_s1 sc_{{$i+1}}">
					<td>
						<input type="text" 
						class="form-control workers_no"  
						value="{{number_format($service_contracts[0]['positions'][$i]['contract_no'], 2, ".", "")}}" 
						onkeypress="return onlyNumKey(event)" 
						onpaste="return false;" 
						oninput="monthly_cost('positions_s1', 'sc_{{$i+1}}')">
					</td>
					<td>
						<div class="input-group">
							<span class="input-group-addon">no. of</span>
							<input type="text" 
							class="form-control position"  
							onpaste="return false;" 
							placeholder="Enter service contract position (ex.: Laborer II - Passed QS & PS)"
							value="{{$service_contracts[0]['positions'][$i]['position']}}">
						</div>
					</td>
					<td>
						<input type="text" 
						class="form-control monthly_rate"  
						value="{{number_format($service_contracts[0]['positions'][$i]['monthly_rate'], 2, ".", "")}}" 
						onkeypress="return onlyNumKey(event)" 
						onpaste="return false;" 
						oninput="monthly_cost('positions_s1', 'sc_{{$i+1}}')">
					</td>
					<td>
						<input type="text" 
						class="form-control monthly_cost" 
						value="{{number_format($service_contracts[0]['positions'][$i]['monthly_cost'], 2, ".", "")}}" 
						onchange="contract_amount('positions_s1', 'sc_{{$i+1}}', 's1')" 
						readonly="readonly">
					</td>
					<td>
						<input type="text" 
						class="form-control total" 
						value="{{number_format($service_contracts[0]['positions'][$i]['amount'], 2, ".", "")}}"
						onchange="total('service_contract_s1', 'total')" 
						readonly="readonly">
					</td>
				</tr>
			@endfor
		@else
			<tr class="service_contractors positions_s1 sc_1">
				<td>
					<input type="text" 
					class="form-control workers_no"  
					value="0" 
					onkeypress="return onlyNumKey(event)" 
					onpaste="return false;" 
					oninput="monthly_cost('positions_s1', 'sc_1')">
				</td>
				<td>
					<div class="input-group">
						<span class="input-group-addon">no. of</span>
						<input type="text" 
						class="form-control position"  
						onpaste="return false;" 
						placeholder="Enter service contract position (ex.: Laborer II - Passed QS & PS)">
					</div>
				</td>
				<td>
					<input type="text" 
					class="form-control monthly_rate"  
					value="0" 
					onkeypress="return onlyNumKey(event)" 
					onpaste="return false;" 
					oninput="monthly_cost('positions_s1', 'sc_1')">
				</td>
				<td>
					<input type="text" 
					class="form-control monthly_cost" 
					value="0" 
					onchange="contract_amount('positions_s1', 'sc_1', 's1')" 
					readonly="readonly">
				</td>
				<td>
					<input type="text" 
					class="form-control total" 
					value="0"
					onchange="total('service_contract_s1', 'total')" 
					readonly="readonly">
				</td>
			</tr>
		@endif

		<tr class="service_contractors">
			<th colspan="3" class="text-right"><h4>Sub Total Sem 1</h4></th>
			{{-- sub total of monthly cost --}}
			<td>
				<input type="text" 
				class="form-control monthly_cost_sub_total" 
				value="{{(isset($service_contracts)) ? number_format($monthly_cost_s1, 2, '.', '') : ''}}"
				readonly="readonly">
			</td>

			{{-- sub total --}}
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s1" 
				value="{{(isset($service_contracts)) ? number_format($service_contracts[0]['sub_total'], 2, '.', '') : ''}}"
				onchange="total('service_contract_component', 'sub_total')" 
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- sem 2 --}}
	<tbody class="service_contract_s2">
		<tr class="service_contractors">
			<th colspan="5">Sem 2</th>
		</tr>
		<tr class="service_contractors months_hired_s2">
			<td>
				<input type="text" 
				class="form-control months"
				value="{{(isset($service_contracts)) ? number_format($service_contracts[1]['months_no']) : 6}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;"
				oninput="recompute_amount('s2')">
			</td>
			<td><i>no. of months to be hired</i></td>
			<td></td>
			<td class="text-right">
				<button class="btn btn-danger btn-sm mb-xs remove_sc" style="display: none;" onclick="remove_service_contract_row('s2')">Remove Row</button>
				<button class="btn btn-primary btn-sm mb-xs" onclick="add_service_contract_row('s2')">Add Row</button>
			</td>
			<td class="text-right"></td>
		</tr>

		@if(isset($service_contracts))
			@php
				$monthly_cost_s2 = 0;
			@endphp

			@for($i = 0; $i < count($service_contracts[1]['positions']); $i++)
				@php
					$monthly_cost_s2 += $service_contracts[1]['positions'][$i]['monthly_cost'];
				@endphp

				<tr class="service_contractors positions_s2 sc_{{$i+1}}">
					<td>
						<input type="text" 
						class="form-control workers_no"  
						value="{{number_format($service_contracts[1]['positions'][$i]['contract_no'], 2, ".", "")}}" 
						onkeypress="return onlyNumKey(event)" 
						onpaste="return false;" 
						oninput="monthly_cost('positions_s2', 'sc_{{$i+1}}')">
					</td>
					<td>
						<div class="input-group">
							<span class="input-group-addon">no. of</span>
							<input type="text" 
							class="form-control position"  
							onpaste="return false;" 
							placeholder="Enter service contract position (ex.: Laborer II - Passed QS & PS)"
							value="{{$service_contracts[1]['positions'][$i]['position']}}">
						</div>
					</td>
					<td>
						<input type="text" 
						class="form-control monthly_rate"  
						value="{{number_format($service_contracts[1]['positions'][$i]['monthly_rate'], 2, ".", "")}}" 
						onkeypress="return onlyNumKey(event)" 
						onpaste="return false;" 
						oninput="monthly_cost('positions_s2', 'sc_{{$i+1}}')">
					</td>
					<td>
						<input type="text" 
						class="form-control monthly_cost" 
						value="{{number_format($service_contracts[1]['positions'][$i]['monthly_cost'], 2, ".", "")}}" 
						onchange="contract_amount('positions_s2', 'sc_{{$i+1}}', 's2')" 
						readonly="readonly">
					</td>
					<td>
						<input type="text" 
						class="form-control total" 
						value="{{number_format($service_contracts[1]['positions'][$i]['amount'], 2, ".", "")}}"
						onchange="total('service_contract_s2', 'total')" 
						readonly="readonly">
					</td>
				</tr>
			@endfor
		@else
			<tr class="service_contractors positions_s2 sc_1">
				<td>
					<input type="text" 
					class="form-control workers_no"  
					value="0" 
					onkeypress="return onlyNumKey(event)" 
					onpaste="return false;" 
					oninput="monthly_cost('positions_s2', 'sc_1')">
				</td>
				<td>
					<div class="input-group">
						<span class="input-group-addon">no. of</span>
						<input type="text" 
						class="form-control position"  
						onpaste="return false;" 
						placeholder="Enter service contract position (ex.: Laborer II - Passed QS & PS)">
					</div>
				</td>
				<td>
					<input type="text" 
					class="form-control monthly_rate"  
					value="0" 
					onkeypress="return onlyNumKey(event)" 
					onpaste="return false;" 
					oninput="monthly_cost('positions_s2', 'sc_1')">
				</td>
				<td>
					<input type="text" 
					class="form-control monthly_cost" 
					value="0" 
					onchange="contract_amount('positions_s2', 'sc_1', 's2');" 
					readonly="readonly">
				</td>
				<td>
					<input type="text" 
					class="form-control total" 
					value="0"
					onchange="total('service_contract_s2', 'total')" 
					readonly="readonly">
				</td>
			</tr>
		@endif

		<tr class="service_contractors">
			<th colspan="3" class="text-right"><h4>Sub Total Sem 2</h4></th>
			{{-- sub total of monthly cost --}}
			<td>
				<input type="text" 
				class="form-control monthly_cost_sub_total" 
				value="{{(isset($service_contracts)) ? number_format($monthly_cost_s2, 2, '.', '') : ''}}"
				readonly="readonly">
			</td>

			{{-- sub total --}}
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s2" 
				value="{{(isset($service_contracts)) ? number_format($service_contracts[1]['sub_total'], 2, '.', '') : ''}}"
				onchange="total('service_contract_component', 'sub_total')" 
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	<tr class="service_contractors">
		<th colspan="4" class="text-right"><h4>TOTAL</h4></th>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($service_contracts)) ? number_format($service_contracts[0]['sub_total'] + $service_contracts[1]['sub_total'], 2, '.', '') : ''}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of service contractors table --}}