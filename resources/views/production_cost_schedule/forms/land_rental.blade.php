{{-- land rental table --}}
<table class="table table-bordered land_rental_component" style="width: 100%;">
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('land_rental')">M. Land Rental</th>
		<th class="text-center" onclick="toggle_element('land_rental')">Area (ha)</th>
		<th class="text-center" onclick="toggle_element('land_rental')">Cost per ha (P)</th>
		<th class="text-center" onclick="toggle_element('land_rental')">
			Amount (P)
			<span id="land_rental_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="land_rental_s1">
		<tr class="land_rental">
			<td></td>
			<td>Sem 1</td>
			<td>
				<input type="text" 
				class="form-control area" 
				value="{{(isset($land_rental)) ? number_format($land_rental[0]->area, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'land_rental_s1', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($land_rental)) ? number_format($land_rental[0]->cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'land_rental_s1', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($land_rental)) ? number_format($land_rental[0]->amount, 2, ".", "") : 0}}"
				onchange="total('land_rental_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s1" value="{{(isset($land_rental)) ? number_format($land_rental[0]->amount, 2, ".", "") : 0}}" onchange="total('land_rental_component', 'sub_total')">
	</tbody>

	{{-- sem 2 --}}
	<tbody class="land_rental_s2">
		<tr class="land_rental">
			<td></td>
			<td>Sem 2</td>
			<td>
				<input type="text" 
				class="form-control area" 
				value="{{(isset($land_rental)) ? number_format($land_rental[1]->area, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'land_rental_s2', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($land_rental)) ? number_format($land_rental[1]->cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'land_rental_s2', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($land_rental)) ? number_format($land_rental[1]->amount, 2, ".", "") : 0}}"
				onchange="total('land_rental_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s2" value="{{(isset($land_rental)) ? number_format($land_rental[1]->amount, 2, ".", "") : 0}}" onchange="total('land_rental_component', 'sub_total')">
	</tbody>

	{{-- component total --}}
	<tr class="land_rental">
		<td colspan="4" class="text-right"><h4>TOTAL</h4></td>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($land_rental)) ? number_format($land_rental[0]->amount + $land_rental[1]->amount, 2, ".", "") : 0}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of land rental table --}}