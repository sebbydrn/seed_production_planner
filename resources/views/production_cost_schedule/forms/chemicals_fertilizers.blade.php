{{-- chemicals and fertilizers table --}}
<table class="table table-bordered fertilizer_component" style="width: 100%;">
	{{-- chemicals and fertilizers --}}
	<tr class="warning">
		<th colspan="4" onclick="toggle_element('chemicals_fertilizers')">
			C. Chemicals & Fertilizers
			<span id="chemicals_fertilizers_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	<tbody>
		<tr class="chemicals_fertilizers">
			<th style="width: 50%;"></th>
			<th class="text-center" style="width: 15%;">Area (ha)</th>
			<th class="text-center" style="width: 15%;">Cost per ha (P)</th>
			<th class="text-center" style="width: 20%;">Amount (P)</th>
		</tr>
	</tbody>

	{{-- sem 1 --}}
	<tbody class="fertilizers_s1">
		<tr class="chemicals_fertilizers">
			<td class="text-right">Sem 1</td>
			<td>
				<input type="text" 
				class="form-control area" 
				value="{{(isset($fertilizers)) ? number_format($fertilizers[0]->area, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'fertilizers_s1', ['area', 'cost'])"
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost"
				value="{{(isset($fertilizers)) ? number_format($fertilizers[0]->cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'fertilizers_s1', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($fertilizers)) ? number_format($fertilizers[0]->amount, 2, ".", "") : ''}}"
				onchange="total('fertilizers_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s1" value="{{(isset($fertilizers)) ? number_format($fertilizers[0]->amount, 2, ".", "") : ''}}" onchange="total('fertilizer_component', 'sub_total')">
	</tbody>

	{{-- sem 2 --}}
	<tbody class="fertilizers_s2">
		<tr class="chemicals_fertilizers">
			<td class="text-right">Sem 2</td>
			<td>
				<input type="text" 
				class="form-control area" 
				value="{{(isset($fertilizers)) ? number_format($fertilizers[1]->area, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'fertilizers_s2', ['area', 'cost'])"
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost"
				value="{{(isset($fertilizers)) ? number_format($fertilizers[1]->cost, 2, ".", "") : ''}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'fertilizers_s2', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($fertilizers)) ? number_format($fertilizers[1]->amount, 2, ".", "") : ''}}"
				onchange="total('fertilizers_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s2" value="{{(isset($fertilizers)) ? number_format($fertilizers[1]->amount, 2, ".", "") : ''}}" onchange="total('fertilizer_component', 'sub_total')">
	</tbody>

	{{-- component total --}}
	<tr class="chemicals_fertilizers">
		<th colspan="3" class="text-right"><h4>TOTAL</h4></th>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($fertilizers)) ? number_format($fertilizers[0]->amount + $fertilizers[1]->amount, 2, ".", "") : ''}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of chemicals and fertilizers table --}}