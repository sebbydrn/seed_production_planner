{{-- field supplies table --}}
<table class="table table-bordered field_supplies_component" style="width: 100%;">
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('field_supplies')">I. Field Supplies</th>
		<th class="text-center" onclick="toggle_element('field_supplies')">No. of Sacks</th>
		<th class="text-center" onclick="toggle_element('field_supplies')">Cost per Sack (P)</th>
		<th class="text-center" onclick="toggle_element('field_supplies')">
			Amount (P)
			<span id="field_supplies_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="field_supplies_s1">
		<tr class="field_supplies">
			<th colspan="5">Sem 1</th>
		</tr>
		<tr class="field_supplies sacks_1">
			<td class="text-right"></td>
			<td class="sack_label1">Plastic 20-kg laminated sack for clean seed</td>
			<td>
				<input type="text" 
				class="form-control sacks" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack1_no, 2, ".", "") : 0}}" 
				readonly="readonly"
				onchange="sacks_amount(1,1)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack1_cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="sacks_amount(1,1)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack1_amount, 2, ".", "") : 0}}"
				onchange="total('field_supplies_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="field_supplies sacks_2">
			<td class="text-right"></td>
			<td class="sack_label2">Plastic 10-kg laminated sack for clean seed</td>
			<td>
				<input type="text" 
				class="form-control sacks" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack2_no, 2, ".", "") : 0}}" 
				readonly="readonly"
				onchange="sacks_amount(1,2)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack2_cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="sacks_amount(1,2)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack2_amount, 2, ".", "") : 0}}"
				onchange="total('field_supplies_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="field_supplies sacks_3">
			<td class="text-right"></td>
			<td>Ordinary 50-kg sacks for fresh harvest</td>
			<td>
				<input type="text" 
				class="form-control sacks" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack3_no, 2, ".", "") : 0}}" 
				readonly="readonly"
				onchange="sacks_amount(1,3)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack3_cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="sacks_amount(1,3)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sack3_amount, 2, ".", "") : 0}}"
				onchange="total('field_supplies_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="field_supplies other_field_supplies">
			<td class="text-right"></td>
			<td>Other Field Supplies</td>
			<td></td>
			<td></td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->other_supplies_amount, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="total('field_supplies_s1', 'total')">
			</td>
		</tr>
		<tr class="field_supplies">
			<td colspan="4" class="text-right"><h4>Sub Total Sem 1</h4></td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s1" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sub_total, 2, ".", "") : 0}}"
				onchange="total('field_supplies_component', 'sub_total')"
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- sem 2 --}}
	<tbody class="field_supplies_s2">
		<tr class="field_supplies">
			<th colspan="5">Sem 2</th>
		</tr>
		<tr class="field_supplies sacks_1">
			<td class="text-right"></td>
			<td class="sack_label1">Plastic 20-kg laminated sack for clean seed</td>
			<td>
				<input type="text" 
				class="form-control sacks" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack1_no, 2, ".", "") : 0}}" 
				readonly="readonly"
				onchange="sacks_amount(2,1)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack1_cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="sacks_amount(2,1)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack1_amount, 2, ".", "") : 0}}"
				onchange="total('field_supplies_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="field_supplies sacks_2">
			<td class="text-right"></td>
			<td class="sack_label2">Plastic 10-kg laminated sack for clean seed</td>
			<td>
				<input type="text" 
				class="form-control sacks" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack2_no, 2, ".", "") : 0}}" 
				readonly="readonly"
				onchange="sacks_amount(2,2)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack2_cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="sacks_amount(2,2)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack2_amount, 2, ".", "") : 0}}"
				onchange="total('field_supplies_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="field_supplies sacks_3">
			<td class="text-right"></td>
			<td>Ordinary 50-kg sacks for fresh harvest</td>
			<td>
				<input type="text" 
				class="form-control sacks" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack3_no, 2, ".", "") : 0}}" 
				readonly="readonly"
				onchange="sacks_amount(2,3)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack3_cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="sacks_amount(2,3)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sack3_amount, 2, ".", "") : 0}}"
				onchange="total('field_supplies_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="field_supplies other_field_supplies">
			<td class="text-right"></td>
			<td>Other Field Supplies</td>
			<td></td>
			<td></td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->other_supplies_amount, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="total('field_supplies_s2', 'total')">
			</td>
		</tr>
		<tr class="field_supplies">
			<td colspan="4" class="text-right"><h4>Sub Total Sem 2</h4></td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s2" 
				value="{{(isset($field_supplies)) ? number_format($field_supplies[1]->sub_total, 2, ".", "") : 0}}"
				onchange="total('field_supplies_component', 'sub_total')"
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	<tr class="field_supplies">
		<td colspan="4" class="text-right"><h4>TOTAL</h4></td>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($field_supplies)) ? number_format($field_supplies[0]->sub_total + $field_supplies[1]->sub_total, 2, ".", "") : 0}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of field supplies table --}}