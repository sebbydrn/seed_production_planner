{{-- land preparation table --}}
<table class="table table-bordered land_preparation_component" style="width: 100%;">
	{{-- land preparation --}}
	<tr class="warning">
		<th colspan="5" onclick="toggle_element('land_preparation')">
			A. Land Preparation (3 Passing) 
			<span id="land_preparation_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	<tbody>
		<tr class="land_preparation">
			<th colspan="2" style="width: 50%;"></th>
			<th class="text-center" style="width: 15%;">Area (ha)</th>
			<th class="text-center" style="width: 15%;">Cost per ha (P)</th>
			<th class="text-center" style="width: 20%;">Amount (P)</th>
		</tr>
	</tbody>

	{{-- sem 1 --}}
	<tbody class="land_preparation_sem1">
		<tr class="land_preparation">
			<td colspan="5">Sem 1</td>
		</tr>
		<tr class="land_preparation rotovate_s1">
			<td class="text-right" style="width: 10%;">a.</td>
			<td style="width: 40%;">Custom Services for Rotovation/ Plowing/ Harrowing</td>
			<td>
				<input type="text" class="form-control area" readonly="readonly" value="{{(isset($land_preparation)) ? number_format($land_preparation[0]->rotovate_area, 2, ".", "") : ''}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[0]->rotovate_cost, 2, ".", "") : ''}}" 
				onpaste="return false;" 
				oninput="compute('mult', 'rotovate_s1', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[0]->rotovate_amount, 2, ".", "") : ''}}"
				onchange="total('land_preparation_sem1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="land_preparation levelling_s1">
			<td class="text-right">b.</td>
			<td>Field Levelling</td>
			<td>
				<input type="text" class="form-control area" readonly="readonly" value="{{(isset($land_preparation)) ? number_format($land_preparation[0]->levelling_area, 2, ".", "") : ''}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[0]->levelling_cost, 2, ".", "") : ''}}" 
				onpaste="return false;" 
				oninput="compute('mult', 'levelling_s1', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[0]->levelling_amount, 2, ".", "") : ''}}"
				onchange="total('land_preparation_sem1', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="land_preparation">
			<td colspan="4" class="text-right"><h4>Sub Total Sem 1</h4></td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s1" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[0]->sub_total, 2, ".", "") : ''}}"
				onchange="total('land_preparation_component', 'sub_total')"
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- sem 2 --}}
	<tbody class="land_preparation_sem2">
		<tr class="land_preparation">
			<td colspan="5">Sem 2</td>
		</tr>
		<tr class="land_preparation rotovate_s2">
			<td class="text-right" style="width: 10%;">a.</td>
			<td style="width: 40%;">Custom Services for Rotovation/ Plowing/ Harrowing</td>
			<td>
				<input type="text" class="form-control area" readonly="readonly" value="{{(isset($land_preparation)) ? number_format($land_preparation[1]->rotovate_area, 2, ".", "") : ''}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[1]->rotovate_cost, 2, ".", "") : ''}}" 
				onpaste="return false;" 
				oninput="compute('mult', 'rotovate_s2', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[1]->rotovate_amount, 2, ".", "") : ''}}"
				onchange="total('land_preparation_sem2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="land_preparation levelling_s2">
			<td class="text-right">b.</td>
			<td>Field Levelling</td>
			<td>
				<input type="text" class="form-control area" readonly="readonly" value="{{(isset($land_preparation)) ? number_format($land_preparation[1]->levelling_area, 2, ".", "") : ''}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[1]->levelling_cost, 2, ".", "") : ''}}" 
				onpaste="return false;" 
				oninput="compute('mult', 'levelling_s2', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[1]->levelling_amount, 2, ".", "") : ''}}"
				onchange="total('land_preparation_sem2', 'total')" 
				readonly="readonly">
			</td>
		</tr>
		<tr class="land_preparation">
			<td colspan="4" class="text-right"><h4>Sub Total Sem 2</h4></td>
			<td>
				<input type="text" 
				class="form-control sub_total sub_total_s2" 
				value="{{(isset($land_preparation)) ? number_format($land_preparation[1]->sub_total, 2, ".", "") : ''}}"
				onchange="total('land_preparation_component', 'sub_total')"
				readonly="readonly">
			</td>
		</tr>
	</tbody>

	{{-- component total --}}
	<tr class="land_preparation">
		<td colspan="4" class="text-right"><h4>TOTAL</h4></td>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($land_preparation)) ? number_format($land_preparation[0]->sub_total + $land_preparation[1]->sub_total, 2, ".", "") : ''}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>

{{-- end of land preparation table --}}