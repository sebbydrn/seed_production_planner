{{-- drying table --}}
<table class="table table-bordered drying_component" style="width: 100%;">
	{{-- drying --}}
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('drying')">E. Drying</th>
		<th class="text-center" onclick="toggle_element('drying')">Quantity</th>
		<th class="text-center" onclick="toggle_element('drying')">Unit Cost (P)</th>
		<th class="text-center" onclick="toggle_element('drying')">
			Amount (P)
			<span id="drying_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="drying_s1">
		<tr class="drying">
			<th colspan="5">Sem 1</th>
		</tr>
		<tr class="drying">
			<td colspan="2"></td>
			<td class="text-center"><i>No. of bags</i></td>
			<td class="text-center"><i>Per bag</i></td>
			<td></td>
		</tr>
		<tr class="drying drying_fee_s1">
			<td class="text-right"></td>
			<td>Drying fee</td>
			<td>
				<input type="text" 
				class="form-control bags" 
				value="{{(isset($drying)) ? number_format($drying[0]->drying_bags_no, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'drying_fee_s1', ['bags', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($drying)) ? number_format($drying[0]->drying_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'drying_fee_s1', ['bags', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($drying)) ? number_format($drying[0]->drying_amount, 2, ".", "") : ''}}"
				onchange="total('drying_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="drying">
			<td colspan="2"></td>
			<td class="text-center"><i>No. of days</i></td>
			<td class="text-center"><i>Per day</i></td>
			<td></td>
		</tr>
		<tr class="drying labor_s1">
			<td>
				<input type="text" 
				class="form-control laborer_no" 
				value="{{(isset($drying)) ? number_format($drying[0]->emergency_labor_no, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'labor_s1', ['laborer_no', 'days', 'cost'])">
			</td>
			<td>No. of emergency laborers, if any</td>
			<td>
				<input type="text" 
				class="form-control days"  
				value="{{(isset($drying)) ? number_format($drying[0]->emergency_labor_days, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'labor_s1', ['laborer_no', 'days', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($drying)) ? number_format($drying[0]->emergency_labor_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'labor_s1', ['laborer_no', 'days', 'cost'])">
			</td>
			<td class="text-right">
				<input type="text" 
				class="form-control total" 
				value="{{(isset($drying)) ? number_format($drying[0]->emergency_labor_amount, 2, ".", "") : ''}}"
				onchange="total('drying_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="drying">
			<th colspan="4" class="text-right"><h4>Sub Total Sem 1</h4></th>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s1" 
				value="{{(isset($drying)) ? number_format($drying[0]->sub_total, 2, ".", "") : ''}}"
				onchange="total('drying_component', 'sub_total')"
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- sem 2 --}}
	<tbody class="drying_s2">
		<tr class="drying">
			<th colspan="5">Sem 2</th>
		</tr>
		<tr class="drying">
			<td colspan="2"></td>
			<td class="text-center"><i>No. of bags</i></td>
			<td class="text-center"><i>Per bag</i></td>
			<td></td>
		</tr>
		<tr class="drying drying_fee_s2">
			<td class="text-right"></td>
			<td>Drying fee</td>
			<td>
				<input type="text" 
				class="form-control bags" 
				value="{{(isset($drying)) ? number_format($drying[1]->drying_bags_no, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'drying_fee_s2', ['bags', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($drying)) ? number_format($drying[1]->drying_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'drying_fee_s2', ['bags', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($drying)) ? number_format($drying[1]->drying_amount, 2, ".", "") : ''}}"
				onchange="total('drying_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="drying">
			<td colspan="2"></td>
			<td class="text-center"><i>No. of days</i></td>
			<td class="text-center"><i>Per day</i></td>
			<td></td>
		</tr>
		<tr class="drying labor_s2">
			<td>
				<input type="text" 
				class="form-control laborer_no" 
				value="{{(isset($drying)) ? number_format($drying[1]->emergency_labor_no, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'labor_s2', ['laborer_no', 'days', 'cost'])">
			</td>
			<td>No. of emergency laborers, if any</td>
			<td>
				<input type="text" 
				class="form-control days"  
				value="{{(isset($drying)) ? number_format($drying[1]->emergency_labor_days, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'labor_s2', ['laborer_no', 'days', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($drying)) ? number_format($drying[1]->emergency_labor_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'labor_s2', ['laborer_no', 'days', 'cost'])">
			</td>
			<td class="text-right">
				<input type="text" 
				class="form-control total" 
				value="{{(isset($drying)) ? number_format($drying[1]->emergency_labor_amount, 2, ".", "") : ''}}"
				onchange="total('drying_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="drying">
			<th colspan="4" class="text-right"><h4>Sub Total Sem 2</h4></th>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s2" 
				value="{{(isset($drying)) ? number_format($drying[1]->sub_total, 2, ".", "") : ''}}"
				onchange="total('drying_component', 'sub_total')"
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- component total --}}
	<tr class="drying">
		<th colspan="4" class="text-right"><h4>TOTAL</h4></th>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($drying)) ? number_format($drying[0]->sub_total + $drying[1]->sub_total, 2, ".", "") : ''}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of drying table --}}