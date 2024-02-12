{{-- fuel table --}}
<table class="table table-bordered fuel_component" style="width: 100%;">
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('fuel')">J. Fuel, Oil and Lubricants</th>
		<th class="text-center" onclick="toggle_element('fuel')">Liters per ha</th>
		<th class="text-center" onclick="toggle_element('fuel')">Cost per Liter (P)</th>
		<th class="text-center" onclick="toggle_element('fuel')">
			Amount (P)
			<span id="fuel_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="fuel_s1">
		<tr class="fuel">
			<th colspan="5">Sem 1</th>
		</tr>
		<tr class="fuel">
			<td>
				<input type="text" 
				class="form-control area" 
				readonly="readonly"
				value="{{(isset($production_cost_schedule)) ? number_format($production_cost_schedule->area1_s1 + $production_cost_schedule->area2_s1, 2, ".", "") : 0}}">
			</td>
			<td><i>Total serviceable area</i></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class="fuel diesel_s1">
			{{-- area hidden field --}}
			<input type="hidden" class="area" value="{{(isset($production_cost_schedule)) ? number_format($production_cost_schedule->area1_s1 + $production_cost_schedule->area2_s1, 2, ".", "") : 0}}">

			<td></td>
			<td>Diesel consumption per ha</td>
			<td>
				<input type="text" 
				class="form-control liters" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->diesel_liters, 2, ".", "") : 0}}"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'diesel_s1', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->diesel_cost, 2, ".", "") : 0}}"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'diesel_s1', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->diesel_amount, 2, ".", "") : 0}}"
				onchange="total('fuel_s1', 'total')"
				readonly="readonly">
			</td>
		</tr>
		<tr class="fuel gasoline_s1">
			{{-- area hidden field --}}
			<input type="hidden" class="area" value="{{(isset($production_cost_schedule)) ? number_format($production_cost_schedule->area1_s1 + $production_cost_schedule->area2_s1, 2, ".", "") : 0}}">

			<td></td>
			<td>Gasoline consumption per ha</td>
			<td>
				<input type="text" 
				class="form-control liters" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->gas_liters, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'gasoline_s1', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->gas_cost, 2, ".", "") : 0}}"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'gasoline_s1', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->gas_amount, 2, ".", "") : 0}}"
				onchange="total('fuel_s1', 'total')"
				readonly="readonly">
			</td>
		</tr>
		<tr class="fuel kerosene_s1">
			{{-- area hidden field --}}
			<input type="hidden" class="area" value="{{(isset($production_cost_schedule)) ? number_format($production_cost_schedule->area1_s1 + $production_cost_schedule->area2_s1, 2, ".", "") : 0}}">

			<td></td>
			<td>Kerosene consumption per ha</td>
			<td>
				<input type="text" 
				class="form-control liters" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->kerosene_liters, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'kerosene_s1', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->kerosene_cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'kerosene_s1', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->kerosene_amount, 2, ".", "") : 0}}"
				onchange="total('fuel_s1', 'total')"
				readonly="readonly">
			</td>
		</tr>
		<tr class="fuel">
			<td colspan="4" class="text-right"><h4>Sub Total Sem 1</h4></td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s1" 
				value="{{(isset($fuel)) ? number_format($fuel[0]->sub_total, 2, ".", "") : 0}}"
				onchange="total('fuel_component', 'sub_total')" 
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- sem 2 --}}
	<tbody class="fuel_s2">
		<tr class="fuel">
			<th colspan="5">Sem 2</th>
		</tr>
		<tr class="fuel">
			<td class="text-right">
				<input type="text" 
				class="form-control area" 
				readonly="readonly"
				value="{{(isset($production_cost_schedule)) ? number_format($production_cost_schedule->area1_s2 + $production_cost_schedule->area2_s2, 2, ".", "") : 0}}">
			</td>
			<td><i>Total serviceable area</i></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class="fuel diesel_s2">
			{{-- area hidden field --}}
			<input type="hidden" class="area" value="{{(isset($production_cost_schedule)) ? number_format($production_cost_schedule->area1_s2 + $production_cost_schedule->area2_s2, 2, ".", "") : 0}}">

			<td></td>
			<td>Diesel consumption per ha</td>
			<td>
				<input type="text" 
				class="form-control liters" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->diesel_liters, 2, ".", "") : 0}}"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'diesel_s2', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->diesel_cost, 2, ".", "") : 0}}"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'diesel_s2', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->diesel_amount, 2, ".", "") : 0}}"
				onchange="total('fuel_s2', 'total')"
				readonly="readonly">
			</td>
		</tr>
		<tr class="fuel gasoline_s2">
			{{-- area hidden field --}}
			<input type="hidden" class="area" value="{{(isset($production_cost_schedule)) ? number_format($production_cost_schedule->area1_s2 + $production_cost_schedule->area2_s2, 2, ".", "") : 0}}">

			<td></td>
			<td>Gasoline consumption per ha</td>
			<td>
				<input type="text" 
				class="form-control liters" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->gas_liters, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'gasoline_s2', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->gas_cost, 2, ".", "") : 0}}"
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'gasoline_s2', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->gas_amount, 2, ".", "") : 0}}"
				onchange="total('fuel_s2', 'total')"
				readonly="readonly">
			</td>
		</tr>
		<tr class="fuel kerosene_s2">
			{{-- area hidden field --}}
			<input type="hidden" class="area" value="{{(isset($production_cost_schedule)) ? number_format($production_cost_schedule->area1_s2 + $production_cost_schedule->area2_s2, 2, ".", "") : 0}}">
			`
			<td></td>
			<td>Kerosene consumption per ha</td>
			<td>
				<input type="text" 
				class="form-control liters" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->kerosene_liters, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'kerosene_s2', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->kerosene_cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'kerosene_s2', ['area', 'liters', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->kerosene_amount, 2, ".", "") : 0}}"
				onchange="total('fuel_s2', 'total')"
				readonly="readonly">
			</td>
		</tr>
		<tr class="fuel">
			<td colspan="4" class="text-right"><h4>Sub Total Sem 2</h4></td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s2" 
				value="{{(isset($fuel)) ? number_format($fuel[1]->sub_total, 2, ".", "") : 0}}"
				onchange="total('fuel_component', 'sub_total')" 
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	<tr class="fuel">
		<td colspan="4" class="text-right"><h4>TOTAL</h4></td>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($fuel)) ? number_format($fuel[0]->sub_total + $fuel[1]->sub_total, 2, ".", "") : 0}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of fuel table --}}