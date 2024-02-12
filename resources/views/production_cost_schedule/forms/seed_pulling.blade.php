{{-- seed pulling table --}}
<table class="table table-bordered seed_pulling_component" style="width: 100%;">
	{{-- seed pulling --}}
	<tr class="warning">
		<th colspan="5" onclick="toggle_element('seed_pulling')">
			B. Seed Pulling, Marking & Transplanting
			<span id="seed_pulling_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	<tbody>
		<tr class="seed_pulling">
			<th colspan="2" style="width: 50%;"></th>
			<th class="text-center" style="width: 15%;">Area (ha)</th>
			<th class="text-center" style="width: 15%;">Cost per ha (P)</th>
			<th class="text-center" style="width: 20%;">Amount (P)</th>
		</tr>
	</tbody>

	{{-- sem 1 --}}
	<tbody class="seed_pulling_s1">
		<tr class="seed_pulling">
			<td colspan="5">Sem 1</td>
		</tr>
		<tr class="seed_pulling pulling_s1">
			<td></td>
			<td>Seed Pulling, Marking & Transplanting</td>
			<td>
				<input type="text" 
				class="form-control area" 
				onpaste="return false;" 
				oninput="compute('mult', 'pulling_s1', ['area', 'cost'])" 
				readonly="readonly"
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->pulling_area, 2, ".", "") : ''}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->pulling_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'pulling_s1', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->pulling_amount, 2, ".", "") : ''}}"
				onchange="total('seed_pulling_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="seed_pulling replanting_s1">
			<td>
				<input type="text" 
				class="form-control labor" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->replanting_labor_no, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'replanting_s1', ['labor', 'replanting_area', 'cost'])">
			</td>
			<td>Emergency labor for replanting of missed hills, and repair of dikes</td>
			<td>
				<input type="text" 
				class="form-control replanting_area" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->replanting_labor_area, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'replanting_s1', ['labor', 'replanting_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->replanting_labor_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'replanting_s1', ['labor', 'replanting_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->replanting_labor_amount, 2, ".", "") : ''}}"
				onchange="total('seed_pulling_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s1" value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->pulling_amount + $seed_pulling[0]->replanting_labor_amount, 2, ".", "") : ''}}" onchange="total('seed_pulling_component', 'sub_total')">
	</tbody>

	{{-- sem 2 --}}
	<tbody class="seed_pulling_s2">
		<tr class="seed_pulling">
			<td colspan="5">Sem 2</td>
		</tr>
		<tr class="seed_pulling pulling_s2">
			<td></td>
			<td>Seed Pulling, Marking & Transplanting</td>
			<td>
				<input type="text" 
				class="form-control area" 
				onpaste="return false;" 
				oninput="compute('mult', 'pulling_s2', ['area', 'cost'])" 
				readonly="readonly"
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[1]->pulling_area, 2, ".", "") : ''}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[1]->pulling_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'pulling_s2', ['area', 'cost'])"
				>
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[1]->pulling_amount, 2, ".", "") : ''}}"
				onchange="total('seed_pulling_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="seed_pulling replanting_s2">
			<td>
				<input type="text" 
				class="form-control labor" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[1]->replanting_labor_no, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'replanting_s2', ['labor', 'replanting_area', 'cost'])">
			</td>
			<td>Emergency labor for replanting of missed hills, and repair of dikes</td>
			<td>
				<input type="text" 
				class="form-control replanting_area" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[1]->replanting_labor_area, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'replanting_s2', ['labor', 'replanting_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[1]->replanting_labor_cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'replanting_s2', ['labor', 'replanting_area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($seed_pulling)) ? number_format($seed_pulling[1]->replanting_labor_amount, 2, ".", "") : ''}}"
				onchange="total('seed_pulling_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s2" value="{{(isset($seed_pulling)) ? number_format($seed_pulling[1]->pulling_amount + $seed_pulling[1]->replanting_labor_amount, 2, ".", "") : ''}}" onchange="total('seed_pulling_component', 'sub_total')">
	</tbody>

	{{-- component total --}}
	<tr class="seed_pulling">
		<th colspan="4" class="text-right"><h4>TOTAL</h4></th>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($seed_pulling)) ? number_format($seed_pulling[0]->pulling_amount + $seed_pulling[0]->replanting_labor_amount + $seed_pulling[1]->pulling_amount + $seed_pulling[1]->replanting_labor_amount, 2, ".", "") : ''}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of seed pulling table --}}