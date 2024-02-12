{{-- harvesting table --}}
<table class="table table-bordered harvesting_component" style="width: 100%;">
	{{-- harvesting --}}
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('harvesting')">D. Harvesting</th>
		<th class="text-center" onclick="toggle_element('harvesting')">Quantity</th>
		<th class="text-center" onclick="toggle_element('harvesting')">Unit Cost (P)</th>
		<th class="text-center" onclick="toggle_element('harvesting')">
			Amount (P)
			<span id="harvesting_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="harvesting_s1">
		<tr class="harvesting">
			<th colspan="5">Sem 1</th>
		</tr>
		<tr class="harvesting">
			<td colspan="2"></td>
			<td class="text-center"><i>No. of ha</i></td>
			<td class="text-center"><i>Per ha</i></td>
			<td></td>
		</tr>
		<tr class="harvesting manual_s1">
			<td class="text-right">a.1</td>
			<td>Manual</td>
			<td>
				<input type="text" 
				class="form-control manual_area" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->manual_area, 2, ".", "") : ''}}" 
				oninput="combine_area('s1'); compute('mult', 'manual_s1', ['manual_area', 'cost']);">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->manual_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'manual_s1', ['manual_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->manual_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s1', 'total')"
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting combine_s1">
			<td class="text-right">a.2</td>
			<td>Mechanical (combine harvester)</td>
			<td>
				<input type="text" 
				class="form-control area"
				oninput="compute('mult', 'combine_s1', ['area', 'cost'])"
				readonly
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->mechanical_area, 2, ".", "") : ''}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->mechanical_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'combine_s1', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->mechanical_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting">
			<td class="text-right">b.</td>
			<td>Hauling</td>
			<td class="text-center"><i>No. of bags</i></td>
			<td class="text-center"><i>Per bag</i></td>
			<td class="text-right"></td>
		</tr>
		<tr class="harvesting hauling_s1">
			<td>
				<input type="text" 
				class="form-control ave_bags"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute_bags('s1', 'fresh'); compute_clean_ave('s1');"
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->hauling_ave_bags, 2, ".", "") : ''}}"
				>
			</td>
			<td><i>average 50-kg bags (fresh harvest) per ha</i></td>
			<td>
				<input type="text"
				class="form-control bags" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->hauling_bags_no, 2, ".", "") : ''}}" 
				readonly>
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->hauling_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'hauling_s1', ['bags', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->hauling_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting">
			<td colspan="2"></td>
			<td class="text-center"><i>No. of ha</i></td>
			<td class="text-center"><i>Per ha</i></td>
			<td></td>
		</tr>
		<tr class="harvesting threshing_s1">
			<td class="text-right">c.</td>
			<td>Threshing (manual harvest)</td>
			<td>
				<input type="text" 
				class="form-control manual_area" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->threshing_area, 2, ".", "") : ''}}"
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost"  
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->threshing_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'threshing_s1', ['manual_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->threshing_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting towing_s1">
			<td class="text-right">d.</td>
			<td>Towing of Thresher</td>
			<td>
				<input type="text" 
				class="form-control manual_area" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->towing_area, 2, ".", "") : ''}}" 
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->towing_cost, 2, ".", "") : ''}}" 
				onpaste="return false;" 
				onkeypress="return onlyNumKey(event)" 
				oninput="compute('mult', 'towing_s1', ['manual_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->towing_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting scatter_s1">
			<td class="text-right">e.</td>
			<td>Hay Scattering</td>
			<td>
				<input type="text" 
				class="form-control manual_area" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->scatter_area, 2, ".", "") : ''}}" 
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->scatter_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'scatter_s1', ['manual_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->scatter_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		<tr class="harvesting">
			<th colspan="4" class="text-right"><h4>Sub Total Sem 1</h4></th>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s1" 
				value="{{(isset($harvesting)) ? number_format($harvesting[0]->sub_total, 2, ".", "") : ''}}"
				onchange="total('harvesting_component', 'sub_total')" 
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- sem 2 --}}
	<tbody class="harvesting_s2">
		<tr class="harvesting">
			<th colspan="5">Sem 2</th>
		</tr>
		<tr class="harvesting">
			<td colspan="2"></td>
			<td class="text-center"><i>No. of ha</i></td>
			<td class="text-center"><i>Per ha</i></td>
			<td></td>
		</tr>
		<tr class="harvesting manual_s2">
			<td class="text-right">a.1</td>
			<td>Manual</td>
			<td>
				<input type="text" 
				class="form-control manual_area" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->manual_area, 2, ".", "") : ''}}" 
				oninput="combine_area('s2'); compute('mult', 'manual_s2', ['manual_area', 'cost']);">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->manual_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'manual_s2', ['manual_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->manual_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s2', 'total')"
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting combine_s2">
			<td class="text-right">a.2</td>
			<td>Mechanical (combine harvester)</td>
			<td>
				<input type="text" 
				class="form-control area"
				oninput="compute('mult', 'combine_s2', ['area', 'cost'])"
				readonly
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->mechanical_area, 2, ".", "") : ''}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->mechanical_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'combine_s2', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->mechanical_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting">
			<td class="text-right">b.</td>
			<td>Hauling</td>
			<td class="text-center"><i>No. of bags</i></td>
			<td class="text-center"><i>Per bag</i></td>
			<td class="text-right"></td>
		</tr>
		<tr class="harvesting hauling_s2">
			<td>
				<input type="text" 
				class="form-control ave_bags"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute_bags('s2', 'fresh'); compute_clean_ave('s2');"
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->hauling_ave_bags, 2, ".", "") : ''}}"
				>
			</td>
			<td><i>average 50-kg bags (fresh harvest) per ha</i></td>
			<td>
				<input type="text"
				class="form-control bags" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->hauling_bags_no, 2, ".", "") : ''}}" 
				readonly>
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->hauling_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'hauling_s2', ['bags', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->hauling_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting">
			<td colspan="2"></td>
			<td class="text-center"><i>No. of ha</i></td>
			<td class="text-center"><i>Per ha</i></td>
			<td></td>
		</tr>
		<tr class="harvesting threshing_s2">
			<td class="text-right">c.</td>
			<td>Threshing (manual harvest)</td>
			<td>
				<input type="text" 
				class="form-control manual_area" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->threshing_area, 2, ".", "") : ''}}"
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost"  
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->threshing_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'threshing_s2', ['manual_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->threshing_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting towing_s2">
			<td class="text-right">d.</td>
			<td>Towing of Thresher</td>
			<td>
				<input type="text" 
				class="form-control manual_area" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->towing_area, 2, ".", "") : ''}}" 
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->towing_cost, 2, ".", "") : ''}}" 
				onpaste="return false;" 
				onkeypress="return onlyNumKey(event)" 
				oninput="compute('mult', 'towing_s2', ['manual_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->towing_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="harvesting scatter_s2">
			<td class="text-right">e.</td>
			<td>Hay Scattering</td>
			<td>
				<input type="text" 
				class="form-control manual_area" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->scatter_area, 2, ".", "") : ''}}" 
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->scatter_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'scatter_s2', ['manual_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->scatter_amount, 2, ".", "") : ''}}"
				onchange="total('harvesting_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		<tr class="harvesting">
			<th colspan="4" class="text-right"><h4>Sub Total Sem 2</h4></th>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s2" 
				value="{{(isset($harvesting)) ? number_format($harvesting[1]->sub_total, 2, ".", "") : ''}}"
				onchange="total('harvesting_component', 'sub_total')" 
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	
	{{-- component total --}}
	<tr class="harvesting">
		<th colspan="4" class="text-right"><h4>TOTAL</h4></th>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($harvesting)) ? number_format($harvesting[0]->sub_total + $harvesting[1]->sub_total, 2, ".", "") : ''}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of harvesting table --}}