{{-- seed cleaning table --}}
<table class="table table-bordered cleaning_component" style="width: 100%;">
	{{-- seed cleaning --}}
	<tr class="warning">
		<th colspan="2" onclick="toggle_element('seed_cleaning')">F. Seed Cleaning</th>
		<th class="text-center" onclick="toggle_element('seed_cleaning')">Quantity (bags)</th>
		<th class="text-center" onclick="toggle_element('seed_cleaning')">Unit Cost (P)</th>
		<th class="text-center" onclick="toggle_element('seed_cleaning')">
			Amount (P)
			<span id="seed_cleaning_ticon" style="float: right;"><i class="fa fa-chevron-up"></i></span>
		</th>
	</tr>

	{{-- sem 1 --}}
	<tbody class="cleaning_s1">
		<tr class="seed_cleaning">
			<th colspan="5">Sem 1</th>
		</tr>
		<tr class="seed_cleaning seed_clean_s1">
			<td class="text-right">
				<input type="text" 
				class="form-control ave_bags" 
				value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[0]->ave_bags, 2, ".", "") : ''}}" 
				readonly="readonly"
				onchange="compute_bags('s1', 'cleaned')">
			</td>
			<td><i class="seed_cleaning_label">average 20-kg bags (clean seeds) per ha</i></td>
			<td>
				<input type="text" 
				class="form-control bags" 
				value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[0]->bags_no, 2, ".", "") : ''}}" 
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost"  
				value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[0]->cost, 2, ".", "") : ''}}" 
				oninput="compute('mult', 'seed_clean_s1', ['bags', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[0]->amount, 2, ".", "") : ''}}"
				onchange="total('cleaning_s1', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s1" value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[0]->amount, 2, ".", "") : ''}}" onchange="total('cleaning_component', 'sub_total')">
	</tbody>

	{{-- sem 2 --}}
	<tbody class="cleaning_s2">
		<tr class="seed_cleaning">
			<th colspan="5">Sem 2</th>
		</tr>
		<tr class="seed_cleaning seed_clean_s2">
			<td class="text-right">
				<input type="text" 
				class="form-control ave_bags" 
				value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[1]->ave_bags, 2, ".", "") : ''}}" 
				readonly="readonly"
				onchange="compute_bags('s2', 'cleaned')">
			</td>
			<td><i class="seed_cleaning_label">average 20-kg bags (clean seeds) per ha</i></td>
			<td>
				<input type="text" 
				class="form-control bags" 
				value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[1]->bags_no, 2, ".", "") : ''}}" 
				readonly="readonly">
			</td>
			<td>
				<input type="text" 
				class="form-control cost"  
				value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[1]->cost, 2, ".", "") : ''}}" 
				oninput="compute('mult', 'seed_clean_s2', ['bags', 'cost'])">
			</td>
			<td>
				<input type="text" 
				class="form-control total" 
				value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[1]->amount, 2, ".", "") : ''}}"
				onchange="total('cleaning_s2', 'total')" 
				readonly="readonly">
			</td>
		</tr>

		{{-- sub-total hidden field --}}
		<input type="hidden" class="sub_total sub_total_s2" value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[1]->amount, 2, ".", "") : ''}}" onchange="total('cleaning_component', 'sub_total')">
	</tbody>

	{{-- component total --}}
	<tr class="seed_cleaning">
		<th colspan="4" class="text-right"><h4>TOTAL</h4></th>
		<td>
			<input type="text" 
			class="form-control component_total" 
			readonly="readonly" 
			value="{{(isset($seed_cleaning)) ? number_format($seed_cleaning[0]->amount + $seed_cleaning[1]->amount, 2, ".", "") : ''}}" 
			onchange="component_total()">
		</td>
	</tr>
</table>
{{-- end of seed cleaning table --}}