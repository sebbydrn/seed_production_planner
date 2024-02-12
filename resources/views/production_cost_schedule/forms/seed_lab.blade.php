{{-- seed lab table --}}
<table class="table table-bordered seed_lab_component" style="width: 100%;">
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('seed_lab')">L. Seed Laboratory Fees</th>
		<th class="text-center" onclick="toggle_element('seed_lab')">
			Amount (P)
			<span id="seed_lab_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="seed_lab_s1">
		<tr class="seed_lab">
			<td></td>
			<td>Sem 1</td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s1" 
				id="seed_lab_amount_s1" 
				value="{{(isset($seed_laboratory)) ? number_format($seed_laboratory->amount_s1, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="total('seed_lab_component', 'sub_total')">
			</td>
		</tr>
	</tbody>

	{{-- sem 2 --}}
	<tbody class="seed_lab_s2">
		<tr class="seed_lab">
			<td></td>
			<td>Sem 2</td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s2" 
				id="seed_lab_amount_s2"
				value="{{(isset($seed_laboratory)) ? number_format($seed_laboratory->amount_s2, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="total('seed_lab_component', 'sub_total')">
			</td>
		</tr>
	</tbody>

	{{-- component total --}}
	<tr class="seed_lab">
		<td colspan="2" class="text-right"><h4>TOTAL</h4></td>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($seed_laboratory)) ? number_format($seed_laboratory->amount_s1 + $seed_laboratory->amount_s2, 2, ".", "") : 0}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of seed lab rows --}}