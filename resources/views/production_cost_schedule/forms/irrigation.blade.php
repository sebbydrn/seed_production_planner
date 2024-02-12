{{-- irrigation table --}}
<table class="table table-bordered irrigation_component" style="width: 100%;">
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('irrigation')">K. Irrigation Fees</th>
		<th class="text-center" onclick="toggle_element('irrigation')">Area (ha)</th>
		<th class="text-center" onclick="toggle_element('irrigation')">Cost per ha (P)</th>
		<th class="text-center" onclick="toggle_element('irrigation')">
			Amount (P)
			<span id="irrigation_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="irrigation_s1">
		<tr class="irrigation">
			<td></td>
			<td>Sem 1</td>
			<td>
				<input type="text" 
				class="form-control area" 
				readonly="reaonly"
				value="{{(isset($irrigation)) ? number_format($irrigation[0]->area, 2, ".", "") : 0}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($irrigation)) ? number_format($irrigation[0]->cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'irrigation_s1', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($irrigation)) ? number_format($irrigation[0]->amount, 2, ".", "") : 0}}"
				onchange="total('irrigation_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s1" value="{{(isset($irrigation)) ? number_format($irrigation[0]->amount, 2, ".", "") : 0}}" onchange="total('irrigation_component', 'sub_total')">
	</tbody>

	{{-- sem 2 --}}
	<tbody class="irrigation_s2">
		<tr class="irrigation">
			<td></td>
			<td>Sem 1</td>
			<td>
				<input type="text" 
				class="form-control area" 
				readonly="reaonly"
				value="{{(isset($irrigation)) ? number_format($irrigation[1]->area, 2, ".", "") : 0}}">
			</td>
			<td>
				<input type="text" 
				class="form-control cost" 
				value="{{(isset($irrigation)) ? number_format($irrigation[1]->cost, 2, ".", "") : 0}}" 
				onkeypress="return onlyNumKey(event)" 
				onpaste="return false;" 
				oninput="compute('mult', 'irrigation_s2', ['area', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($irrigation)) ? number_format($irrigation[0]->amount, 2, ".", "") : 0}}"
				onchange="total('irrigation_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s2" value="{{(isset($irrigation)) ? number_format($irrigation[0]->amount, 2, ".", "") : 0}}" onchange="total('irrigation_component', 'sub_total')">
	</tbody>

	{{-- component total --}}
	<tr class="irrigation">
		<td colspan="4" class="text-right"><h4>TOTAL</h4></td>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($irrigation)) ? number_format($irrigation[0]->amount + $irrigation[1]->amount, 2, ".", "") : 0}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of irrigation table --}}