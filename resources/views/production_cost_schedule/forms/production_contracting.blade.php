{{-- seed production contracting table --}}
<table class="table table-bordered production_contracting_component" style="width: 100%;">
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('production_contracting')">N. Seed Production Contracting (if any)</th>
		<th class="text-center" onclick="toggle_element('production_contracting')">Est. Volume of Seeds (kg)</th>
		<th class="text-center" onclick="toggle_element('production_contracting')">Buying Price per kg</th>
		<th class="text-center" onclick="toggle_element('production_contracting')">
			Amount (P)
			<span id="production_contracting_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="production_contracting_s1">
		<tr class="production_contracting">
			<td></td>
			<td>Sem 1</td>
			<td>
				<input type="text" 
				class="form-control volume" 
				value="{{(isset($production_contracting)) ? number_format($production_contracting[0]->seed_volume, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'production_contracting_s1', ['volume', 'price'])">
			</td>
			<td>
				<input type="text" 
				class="form-control price" 
				value="{{(isset($production_contracting)) ? number_format($production_contracting[0]->buying_price, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'production_contracting_s1', ['volume', 'price'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($production_contracting)) ? number_format($production_contracting[0]->amount, 2, ".", "") : 0}}"
				onchange="total('production_contracting_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s1" value="{{(isset($production_contracting)) ? number_format($production_contracting[0]->amount, 2, ".", "") : 0}}" onchange="total('production_contracting_component', 'sub_total')">
	</tbody>

	{{-- sem 2 --}}
	<tbody class="production_contracting_s2">
		<tr class="production_contracting">
			<td></td>
			<td>Sem 2</td>
			<td>
				<input type="text" 
				class="form-control volume" 
				value="{{(isset($production_contracting)) ? number_format($production_contracting[1]->seed_volume, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'production_contracting_s2', ['volume', 'price'])">
			</td>
			<td>
				<input type="text" 
				class="form-control price" 
				value="{{(isset($production_contracting)) ? number_format($production_contracting[1]->buying_price, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'production_contracting_s2', ['volume', 'price'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($production_contracting)) ? number_format($production_contracting[1]->amount, 2, ".", "") : 0}}"
				onchange="total('production_contracting_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s2" value="{{(isset($production_contracting)) ? number_format($production_contracting[1]->amount, 2, ".", "") : 0}}" onchange="total('production_contracting_component', 'sub_total')">
	</tbody>

	{{-- component total --}}
	<tr class="production_contracting">
		<td colspan="4" class="text-right"><h4>TOTAL</h4></td>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($production_contracting)) ? number_format($production_contracting[0]->amount + $production_contracting[1]->amount, 2, ".", "") : 0}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of seed production contracting table --}}