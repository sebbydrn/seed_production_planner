{{-- planting materials table --}}
<table class="table table-bordered planting_materials_component" style="width: 100%;">
	{{-- planting materials --}}
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('planting_materials')" style="width: 40%;">H. Planting Materials</th>
		<th class="text-center" onclick="toggle_element('planting_materials')" style="width: 20%;">Seeds (kg)</th>
		<th class="text-center" onclick="toggle_element('planting_materials')" style="width: 20%;">Unit Cost (P)</th>
		<th class="text-center" onclick="toggle_element('planting_materials')" style="width: 20%;">
			Amount (P)
			<span id="planting_materials_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	
	<tr class="planting_materials">
		<td>
			<input type="text" 
			class="form-control seeding_rate" 
			id="seeding_rate" 
			value="{{(isset($seeding_rate)) ? number_format($seeding_rate->seeding_rate, 2, ".", "") : 30}}" 
			onkeypress="return onlyNumKey(event);" 
			onpaste="return false;" 
			oninput="compute_seed_quantity(0,0);">
		</td>
		<td><i>seeding rate (kg seeds per ha)</i></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	{{-- sem 1 --}}
	<tbody class="planting_s1">
		<tr class="planting_materials">
			<th colspan="5">Sem 1</th>
		</tr>
		<tr class="planting_materials">
			<td>
				<input type="text" 
				class="form-control area1" 
				readonly="readonly"
				onchange="compute_seed_quantity(1,1)"
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->area1, 2, ".", "") : 0}}">
			</td>
			<td><i class="area_for_production_label1">Area for RS Production</i></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class="planting_materials">
			<td>
				<input type="text" 
				class="form-control area2" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->area2, 2, ".", "") : ''}}" 
				onchange="compute_seed_quantity(1,2)">
			</td>
			<td><i class="area_for_production_label2">Area for FS Production</i></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class="planting_materials planting_materials_1">
			<td></td>
			<td class="plant_materials_label1">Planting Materials for RS Production</td>
			<td>
				<input type="text" 
				class="form-control seeds" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->area1_seed_quantity, 2, ".", "") : 0}}" 
				readonly="readonly" 
				onchange="compute_seeds_amount(1,1)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->area1_cost, 2, ".", "") : 0}}" 
				onpaste="return false;" 
				oninput="compute_seeds_amount(1,1)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->area1_amount, 2, ".", "") : 0}}"
				onchange="total('planting_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="planting_materials planting_materials_2">
			<td></td>
			<td class="plant_materials_label2">Planting Materials for FS Production</td>
			<td>
				<input type="text" 
				class="form-control seeds" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->area2_seed_quantity, 2, ".", "") : 0}}"
				readonly="readonly" 
				onchange="compute_seeds_amount(1,2)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->area2_cost, 2, ".", "") : 0}}" 
				onpaste="return false;" 
				oninput="compute_seeds_amount(1,2)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->area2_amount, 2, ".", "") : 0}}"
				onchange="total('planting_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="planting_materials">
			<td colspan="4" class="text-right"><h4>Sub Total Sem 1</h4></td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s1" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->sub_total, 2, ".", "") : 0}}"
				onchange="total('planting_materials_component', 'sub_total')"
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- sem 2 --}}
	<tbody class="planting_s2">
		<tr class="planting_materials">
			<th colspan="5">Sem 2</th>
		</tr>
		<tr class="planting_materials">
			<td>
				<input type="text" 
				class="form-control area1" 
				readonly="readonly"
				onchange="compute_seed_quantity(2,1)"
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area1, 2, ".", "") : 0}}">
			</td>
			<td><i class="area_for_production_label1">Area for RS Production</i></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class="planting_materials">
			<td>
				<input type="text" 
				class="form-control area2" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area2, 2, ".", "") : ''}}" 
				onchange="compute_seed_quantity(2,2)">
			</td>
			<td><i class="area_for_production_label2">Area for FS Production</i></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class="planting_materials planting_materials_1">
			<td></td>
			<td class="plant_materials_label1">Planting Materials for RS Production</td>
			<td>
				<input type="text" 
				class="form-control seeds" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area1_seed_quantity, 2, ".", "") : 0}}" 
				readonly="readonly" 
				onchange="compute_seeds_amount(2,1)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area1_cost, 2, ".", "") : 0}}" 
				onpaste="return false;" 
				oninput="compute_seeds_amount(2,1)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area1_amount, 2, ".", "") : 0}}"
				onchange="total('planting_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="planting_materials planting_materials_2">
			<td></td>
			<td class="plant_materials_label2">Planting Materials for FS Production</td>
			<td>
				<input type="text" 
				class="form-control seeds" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area2_seed_quantity, 2, ".", "") : 0}}"
				readonly="readonly" 
				onchange="compute_seeds_amount(2,2)">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area2_cost, 2, ".", "") : 0}}" 
				onpaste="return false;" 
				oninput="compute_seeds_amount(2,2)">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area2_amount, 2, ".", "") : 0}}"
				onchange="total('planting_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="planting_materials">
			<td colspan="4" class="text-right"><h4>Sub Total Sem 2</h4></td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s2" 
				value="{{(isset($planting_materials)) ? number_format($planting_materials[1]->area2_sub_total, 2, ".", "") : 0}}"
				onchange="total('planting_materials_component', 'sub_total')"
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- component total --}}
	<tr class="planting_materials">
		<td colspan="4" class="text-right"><h4>TOTAL</h4></td>
		<td class="text-right">
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($planting_materials)) ? number_format($planting_materials[0]->sub_total + $planting_materials[1]->sub_total, 2, ".", "") : 0}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of planting materials table --}}