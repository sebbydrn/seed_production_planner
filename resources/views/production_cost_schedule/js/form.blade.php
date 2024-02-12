<script>
	var sem1_sc_count = {{(isset($service_contracts)) ? count($service_contracts[0]['positions']) : 1}}; // count of service contract sem 1
	var sem2_sc_count = {{(isset($service_contracts)) ? count($service_contracts[1]['positions']) : 1}}; // count of service contract sem 2

	// shows the area inputs for the selected seed production type
	function select_production_type() {
		var seed_production_type = document.getElementById('seed_production_type').value;

		if (seed_production_type == "Inbred") {
			// changes the label in planting materials - area
			change_element_content('area_for_production_label1', 'Area for FS Production');
			change_element_content('area_for_production_label2', 'Area for RS Production');

			// changes the label in planting materials
			change_element_content('plant_materials_label1', 'Planting Materials for FS Production');
			change_element_content('plant_materials_label2', 'Planting Materials for RS Production');

			// changes the sack label in field supplies
			change_element_content('sack_label1', 'Plastic 20-kg laminated sack for clean seed');
			change_element_content('sack_label2', 'Plastic 10-kg laminated sack for clean seed');

			// changes the average bags label in seed cleaning
			change_element_content('seed_cleaning_label', 'average 20-kg bags (clean seeds) per ha');

			// changes the label in total area in production cost summary
			change_element_content('total_area_for_production_label1', 'Total FS-RS Area (ha)');
			change_element_content('total_area_for_production_label2', 'Total BS-FS Area (ha)');

			// changes volume of clean seeds label
			change_element_content('volume_clean_seeds1', 'Volume of clean seeds, FS-RS (kg)');
			change_element_content('volume_clean_seeds2', 'Volume of clean seeds, BS-FS (kg)');
		}
		else if (seed_production_type == "Hybrid (P and R)") {
			// changes the label in planting materials - area
			change_element_content('area_for_production_label1', 'Area for P-line Production');
			change_element_content('area_for_production_label2', 'Area for R-line Production');

			// changes the label in planting materials
			change_element_content('plant_materials_label1', 'Planting Materials for P-line Production');
			change_element_content('plant_materials_label2', 'Planting Materials for R-line Production');

			// changes the sack label in field supplies
			change_element_content('sack_label1', 'Plastic 5-kg laminated sack for clean seed');
			change_element_content('sack_label2', 'Plastic 5-kg plastic sack for clean seed');

			// changes the average bags label in seed cleaning
			change_element_content('seed_cleaning_label', 'average 15-kg bags (clean seeds) per ha');

			// changes the label in total area in production cost summary
			change_element_content('total_area_for_production_label1', 'Total P-line Area (ha)');
			change_element_content('total_area_for_production_label2', 'Total R-line Area (ha)');

			// changes volume of clean seeds label
			change_element_content('volume_clean_seeds1', 'Volume of clean seeds, P-line (kg)');
			change_element_content('volume_clean_seeds2', 'Volume of clean seeds, R-line (kg)');
		}
		else {
			if (seed_production_type == "Hybrid (AxR)") {
				// changes the label in planting materials - area
				change_element_content('area_for_production_label1', 'Area for AxR Production');
				change_element_content('area_for_production_label2', 'Area for ___ Production');

				// changes the label in planting materials
				change_element_content('plant_materials_label1', 'Planting Materials for AxR Production (A)');
				change_element_content('plant_materials_label2', 'Planting Materials for AxR Production (R)');

				// changes the average bags label in seed cleaning
				change_element_content('seed_cleaning_label', 'average 15-kg bags (clean seeds) per ha');

				// changes the label in total area in production cost summary
				change_element_content('total_area_for_production_label1', 'Total AxR Area (ha)');
				change_element_content('total_area_for_production_label2', 'Total ___ Area (ha)');

				// changes volume of clean seeds label
				change_element_content('volume_clean_seeds1', 'Volume of clean seeds, F1 (kg)');
				change_element_content('volume_clean_seeds2', 'Volume of clean seeds, ___ (kg)');
			}

			if (seed_production_type == "Hybrid (S)") {
				// changes the label in planting materials - area
				change_element_content('area_for_production_label1', 'Area for S-line Production');
				change_element_content('area_for_production_label2', 'Area for ___ Production');

				// changes the label in planting materials
				change_element_content('plant_materials_label1', 'Planting Materials for S Production');
				change_element_content('plant_materials_label2', 'Planting Materials for ___ Production');

				// changes the average bags label in seed cleaning
				change_element_content('seed_cleaning_label', 'average 15-kg bags (clean seeds) per ha');

				// changes the label in total area in production cost summary
				change_element_content('total_area_for_production_label1', 'Total S-line Area (ha)');
				change_element_content('total_area_for_production_label2', 'Total ____ Area (ha)');

				// changes volume of clean seeds label
				change_element_content('volume_clean_seeds1', 'Volume of clean seeds, S-line (kg)');
				change_element_content('volume_clean_seeds2', 'Volume of clean seeds, ____ (kg)');
			}

			if (seed_production_type == "Hybrid (A)") {
				// changes the label in planting materials - area
				change_element_content('area_for_production_label1', 'Area for AxB Production');
				change_element_content('area_for_production_label2', 'Area for ___ Production');

				// changes the label in planting materials
				change_element_content('plant_materials_label1', 'Planting Materials for AxB Production (A)');
				change_element_content('plant_materials_label2', 'Planting Materials for AxB Production (B)');

				// changes the average bags label in seed cleaning
				change_element_content('seed_cleaning_label', 'average 18-kg bags (clean seeds) per ha');

				// changes the label in total area in production cost summary
				change_element_content('total_area_for_production_label1', 'Total AxB Area (ha)');
				change_element_content('total_area_for_production_label2', 'Total ___ Area (ha)');

				// changes volume of clean seeds label
				change_element_content('volume_clean_seeds1', 'Volume of clean seeds, A-line (kg)');
				change_element_content('volume_clean_seeds2', 'Volume of clean seeds, ____ (kg)');
			}

			// changes the sack label in field supplies
			change_element_content('sack_label1', 'Plastic 15-kg laminated sack for clean seed');
			change_element_content('sack_label2', 'Plastic 15-kg plastic sack for clean seed');
		}

		// set value for area fields in planting materials component to zero
		//var planting_materials = document.querySelector('.planting_materials_component');

		/*for (var i = 1; i <= 2; i++) {
			var area = planting_materials.getElementsByClassName('area'+i);
			console.log(area);

			for (var x = 0; x < area.length; x++) {
				area[x].value = 0;
				area[x].onchange();
			}
		}*/
	}

	// adds the seed production area
	function add_seed_production_area() {
		var area_on_station = document.querySelector('#area_on_station').value;
		var area_out_station = document.querySelector('#area_out_station').value;
		var area_contracting = document.querySelector('#area_contracting').value;

		area_on_station = (area_on_station == "") ? 0 : parseFloat(area_on_station);
		area_out_station = (area_out_station == "") ? 0 : parseFloat(area_out_station);
		area_contracting = (area_contracting == "") ? 0 : parseFloat(area_contracting);

		document.querySelector('#total_production_area').value = area_on_station + area_out_station + area_contracting;

		// set "group_id" as key value pair in "total_production_area" object
		var total_production_area = area_on_station + area_out_station + area_contracting;

		// set values of area fields in forms
		change_input_value('area', total_production_area);

		var planting_materials = document.querySelector('.planting_materials_component');

		var elements = planting_materials.querySelectorAll('.area1');

		elements.forEach(function(el) {
			el.value = area_on_station + area_out_station + area_contracting;
			el.onchange();
		});

		// assigns value for production area in production cost summary
		var summary = document.querySelector('.production_cost_summary');

		for (var i=1; i<=2; i++) {
			summary.querySelector('.area1_s'+i).innerHTML = (area_on_station + area_out_station + area_contracting).toLocaleString("en-US", {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2,
			});
		}
	}

	// changes the content of the specified element class
	function change_element_content(class_name, new_content) {
		var el = document.getElementsByClassName(class_name);

		for (var i = 0; i < el.length; i++)
			el[i].innerHTML = new_content;
	}

	// hides or shows specified element class
	function toggle_element(class_name) {
		var el = document.getElementsByClassName(class_name);
		var ticon_id = class_name + "_ticon";

		$('.'+class_name).fadeToggle(400, function() {
			// checks the element if displayed or not and changes the toggle icon
			if (el[0].style.display == "none")
				document.getElementById(ticon_id).innerHTML = `<i class="fa fa-chevron-down"></i>`;
			else
				document.getElementById(ticon_id).innerHTML = `<i class="fa fa-chevron-up"></i>`;
		});
	}

	// changes the values of the specified input fields class
	function change_input_value(class_name, new_value) {
		var el = document.getElementsByClassName(class_name);

		for (var i = 0; i < el.length; i++)
			el[i].value = new_value;
	}

	// add rows to service contractor
	function add_service_contract_row(sem) {
		if (sem == "s1")
			var el = document.querySelector('.positions_'+sem+'.sc_'+sem1_sc_count);
		if (sem == "s2")
			var el = document.querySelector('.positions_'+sem+'.sc_'+sem2_sc_count);

		var clone = el.cloneNode(true);

		if (sem == "s1") {
			$(clone).insertAfter('.positions_'+sem+'.sc_'+sem1_sc_count);

			sem1_sc_count += 1;
			clone.className = "service_contractors positions_"+sem+" sc_"+sem1_sc_count;

			// change oninput parameters for cloned element
			el = document.querySelector('.positions_'+sem+'.sc_'+sem1_sc_count);
			var workers_no = el.querySelector('.workers_no');
			var monthly_rate = el.querySelector('.monthly_rate');
			var monthly_cost = el.querySelector('.monthly_cost');

			workers_no.removeAttribute('oninput');
			workers_no.setAttribute('oninput', `monthly_cost('positions_${sem}', 'sc_${sem1_sc_count}')`);

			monthly_rate.removeAttribute('oninput');
			monthly_rate.setAttribute('oninput', `monthly_cost('positions_${sem}', 'sc_${sem1_sc_count}')`);

			monthly_cost.removeAttribute('onchange');
			monthly_cost.setAttribute('onchange', `contract_amount('positions_${sem}', 'sc_${sem1_sc_count}', '${sem}')`);

			if (sem1_sc_count > 1) {
				el = document.querySelector('.service_contract_s1');
				var button = el.querySelector('.remove_sc');
				button.style.display = "inline-block";
			}
		}

		if (sem == "s2") {
			$(clone).insertAfter('.positions_'+sem+'.sc_'+sem2_sc_count);

			sem2_sc_count += 1;
			clone.className = "service_contractors positions_"+sem+" sc_"+sem2_sc_count;

			// change oninput parameters for cloned element
			el = document.querySelector('.positions_'+sem+'.sc_'+sem2_sc_count);
			var workers_no = el.querySelector('.workers_no');
			var monthly_rate = el.querySelector('.monthly_rate');
			var monthly_cost = el.querySelector('.monthly_cost');

			workers_no.removeAttribute('oninput');
			workers_no.setAttribute('oninput', `monthly_cost('positions_${sem}', 'sc_${sem2_sc_count}')`);

			monthly_rate.removeAttribute('oninput');
			monthly_rate.setAttribute('oninput', `monthly_cost('positions_${sem}', 'sc_${sem2_sc_count}')`);

			monthly_cost.removeAttribute('onchange');
			monthly_cost.setAttribute('onchange', `contract_amount('positions_${sem}', 'sc_${sem2_sc_count}', '${sem}')`);

			if (sem2_sc_count > 1) {
				el = document.querySelector('.service_contract_s2');
				var button = el.querySelector('.remove_sc');
				button.style.display = "inline-block";
			}
		}
	}

	// removes the last row added in service contractor field
	function remove_service_contract_row(sem) {
		if (sem == "s1") {
			$('.positions_'+sem+'.sc_'+sem1_sc_count).remove();
			sem1_sc_count -= 1;

			if (sem1_sc_count == 1) {
				el = document.querySelector('.service_contract_s1');
				var button = el.querySelector('.remove_sc');
				button.style.display = "none";
			}
		}
		if (sem == "s2") {
			$('.positions_'+sem+'.sc_'+sem2_sc_count).remove();
			sem2_sc_count -= 1;

			if (sem2_sc_count == 1) {
				el = document.querySelector('.service_contract_s2');
				var button = el.querySelector('.remove_sc');
				button.style.display = "none";
			}
		}
	}

	function onlyNumKey(evt) {
		var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		if (ASCIICode != 46 && ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) {
			return false;
		}
		return true;
	}

	function submit() {
		var year = document.getElementById('year').value;
		var seed_production_type = document.getElementById('seed_production_type').value;
		var area_station = document.getElementById('area_on_station').value;
		var area_outside = document.getElementById('area_out_station').value;
		var area_contract = document.getElementById('area_contracting').value;
		var remarks = document.getElementById('remarks').value;
		var total_s1 = document.getElementById('total_prod_cost_s1').innerHTML;
		var total_s2 = document.getElementById('total_prod_cost_s2').innerHTML;
		var area1_s1 = document.getElementById('area1_s1').innerHTML;
		var area1_s2 = document.getElementById('area1_s2').innerHTML;
		var area2_s1 = document.getElementById('area2_s1').innerHTML;
		var area2_s2 = document.getElementById('area2_s2').innerHTML;
		var clean_seed1_s1 = document.getElementById('clean_seed1_s1').innerHTML;
		var clean_seed1_s2 = document.getElementById('clean_seed1_s2').innerHTML;
		var clean_seed2_s1 = document.getElementById('clean_seed2_s1').innerHTML;
		var clean_seed2_s2 = document.getElementById('clean_seed2_s2').innerHTML;
		var production_cost_kilo_s1 = document.getElementById('prod_cost_kilo_s1').innerHTML;
		var production_cost_kilo_s2 = document.getElementById('prod_cost_kilo_s2').innerHTML;
		var production_cost_ha_s1 = document.getElementById('prod_cost_ha_s1').innerHTML;
		var production_cost_ha_s2 = document.getElementById('prod_cost_ha_s2').innerHTML;
		var seeding_rate = document.getElementById('seeding_rate').value;
		var seed_lab_amount_s1 = document.getElementById('seed_lab_amount_s1').value;
		var seed_lab_amount_s2 = document.getElementById('seed_lab_amount_s2').value;
		var land_preparation = [];
		var seed_pulling = [];
		var fertilizers = [];
		var harvesting = [];
		var drying = [];
		var seed_cleaning = [];
		var service_contracts = [];
		var service_contract_positions = [];
		var planting_materials = [];
		var field_supplies = [];
		var fuel = [];
		var irrigation = [];
		var land_rental = [];
		var production_contracting = [];

		for (var i=0; i<2; i++) {
			var sem = i+1;

			// land preparation
			var el = document.querySelector('.land_preparation_sem'+sem);
			var rotovate = el.querySelector('.rotovate_s'+sem);
			var levelling = el.querySelector('.levelling_s'+sem);

			land_preparation[i] = {
				sem: sem,
				rotovate_area: rotovate.querySelector('.area').value,
				rotovate_cost: rotovate.querySelector('.cost').value,
				rotovate_amount: rotovate.querySelector('.total').value,
				levelling_area: levelling.querySelector('.area').value,
				levelling_cost: levelling.querySelector('.cost').value,
				levelling_amount: levelling.querySelector('.total').value,
				sub_total: el.querySelector('.sub_total_s'+sem).value
			}

			// seed pulling
			el = document.querySelector('.seed_pulling_s'+sem);
			var pulling = el.querySelector('.pulling_s'+sem);
			var replanting = el.querySelector('.replanting_s'+sem);

			seed_pulling[i] = {
				sem: sem,
				pulling_area: pulling.querySelector('.area').value,
				pulling_cost: pulling.querySelector('.cost').value,
				pulling_amount: pulling.querySelector('.total').value,
				replanting_labor_no: replanting.querySelector('.labor').value,
				replanting_labor_area: replanting.querySelector('.replanting_area').value,
				replanting_labor_cost: replanting.querySelector('.cost').value,
				replanting_labor_amount: replanting.querySelector('.total').value
			}

			// chemicals and fertilizers
			el = document.querySelector('.fertilizers_s'+sem);

			fertilizers[i] = {
				sem: sem,
				area: el.querySelector('.area').value,
				cost: el.querySelector('.cost').value,
				amount: el.querySelector('.total').value
			}

			// harvesting
			el = document.querySelector('.harvesting_s'+sem);
			var manual = el.querySelector('.manual_s'+sem);
			var mechanical = el.querySelector('.combine_s'+sem);
			var hauling = el.querySelector('.hauling_s'+sem);
			var threshing = el.querySelector('.threshing_s'+sem);
			var towing = el.querySelector('.towing_s'+sem);
			var scatter = el.querySelector('.scatter_s'+sem);

			harvesting[i] = {
				sem: sem,
				manual_area: manual.querySelector('.manual_area').value,
				manual_cost: manual.querySelector('.cost').value,
				manual_amount: manual.querySelector('.total').value,
				mechanical_area: mechanical.querySelector('.area').value,
				mechanical_cost: mechanical.querySelector('.cost').value,
				mechanical_amount: mechanical.querySelector('.total').value,
				hauling_ave_bags: hauling.querySelector('.ave_bags').value,
				hauling_bags_no: hauling.querySelector('.bags').value,
				hauling_cost: hauling.querySelector('.cost').value,
				hauling_amount: hauling.querySelector('.total').value,
				threshing_area: threshing.querySelector('.manual_area').value,
				threshing_cost: threshing.querySelector('.cost').value,
				threshing_amount: threshing.querySelector('.total').value,
				towing_area: towing.querySelector('.manual_area').value,
				towing_cost: towing.querySelector('.cost').value,
				towing_amount: towing.querySelector('.total').value,
				scatter_area: scatter.querySelector('.manual_area').value,
				scatter_cost: scatter.querySelector('.cost').value,
				scatter_amount: scatter.querySelector('.total').value,
				sub_total: el.querySelector('.sub_total').value
			}

			// drying
			el = document.querySelector('.drying_s'+sem);
			var drying_fee = el.querySelector('.drying_fee_s'+sem);
			var labor = el.querySelector('.labor_s'+sem);

			drying[i] = {
				sem: sem,
				drying_bags_no: drying_fee.querySelector('.bags').value,
				drying_cost: drying_fee.querySelector('.cost').value,
				drying_amount: drying_fee.querySelector('.total').value,
				emergency_labor_no: labor.querySelector('.laborer_no').value,
				emergency_labor_days: labor.querySelector('.days').value,
				emergency_labor_cost: labor.querySelector('.cost').value,
				emergency_labor_amount: labor.querySelector('.total').value,
				sub_total: el.querySelector('.sub_total').value
			}

			// seed cleaning
			el = document.querySelector('.seed_clean_s'+sem);

			seed_cleaning[i] = {
				sem: sem,
				ave_bags: el.querySelector('.ave_bags').value,
				bags_no: el.querySelector('.bags').value,
				cost: el.querySelector('.cost').value,
				amount: el.querySelector('.total').value
			}

			// service contracts
			el = document.querySelector('.service_contract_s'+sem);

			service_contracts[i] = {
				sem: sem,
				months_no: el.querySelector('.months').value,
				sub_total: el.querySelector('.sub_total').value
			}

			var count = (sem == 1) ? sem1_sc_count : sem2_sc_count;

			service_contract_positions[i] = {}

			for (var x=0; x<count; x++) {
				var sc_count = x+1;

				var position = el.querySelector('.sc_'+sc_count);

				service_contract_positions[i][x] = {
					contract_no: position.querySelector('.workers_no').value,
					position: position.querySelector('.position').value,
					monthly_rate: position.querySelector('.monthly_rate').value,
					monthly_cost: position.querySelector('.monthly_cost').value,
					amount: position.querySelector('.total').value
				}
			}

			// planting materials
			el = document.querySelector('.planting_s'+sem);
			var material1 = el.querySelector('.planting_materials_1');
			var material2 = el.querySelector('.planting_materials_2');

			planting_materials[i] = {
				sem: sem,
				area1: el.querySelector('.area1').value,
				area2: el.querySelector('.area2').value,
				area1_seed_quantity: material1.querySelector('.seeds').value,
				area1_cost: material1.querySelector('.cost').value,
				area1_amount: material1.querySelector('.total').value,
				area2_seed_quantity: material2.querySelector('.seeds').value,
				area2_cost: material2.querySelector('.cost').value,
				area2_amount: material2.querySelector('.total').value,
				sub_total: el.querySelector('.sub_total').value
			}

			// field supplies
			el = document.querySelector('.field_supplies_s'+sem);
			var sacks1 = el.querySelector('.sacks_1');
			var sacks2 = el.querySelector('.sacks_2');
			var sacks3 = el.querySelector('.sacks_3');
			var other_field_supplies = el.querySelector('.other_field_supplies');

			field_supplies[i] = {
				sem: sem,
				sack1_no: sacks1.querySelector('.sacks').value,
				sack1_cost: sacks1.querySelector('.cost').value,
				sack1_amount: sacks1.querySelector('.total').value,
				sack2_no: sacks2.querySelector('.sacks').value,
				sack2_cost: sacks2.querySelector('.cost').value,
				sack2_amount: sacks2.querySelector('.total').value,
				sack3_no: sacks3.querySelector('.sacks').value,
				sack3_cost: sacks3.querySelector('.cost').value,
				sack3_amount: sacks3.querySelector('.total').value,
				other_supplies_amount: other_field_supplies.querySelector('.total').value,
				sub_total: el.querySelector('.sub_total').value 
			}

			// fuel
			el = document.querySelector('.fuel_s'+sem);
			var diesel = el.querySelector('.diesel_s'+sem);
			var gasoline = el.querySelector('.gasoline_s'+sem);
			var kerosene = el.querySelector('.kerosene_s'+sem);

			fuel[i] = {
				sem: sem,
				diesel_liters: diesel.querySelector('.liters').value,
				diesel_cost: diesel.querySelector('.cost').value,
				diesel_amount: diesel.querySelector('.total').value,
				gas_liters: gasoline.querySelector('.liters').value,
				gas_cost: gasoline.querySelector('.cost').value,
				gas_amount: gasoline.querySelector('.total').value,
				kerosene_liters: kerosene.querySelector('.liters').value,
				kerosene_cost: kerosene.querySelector('.cost').value,
				kerosene_amount: kerosene.querySelector('.total').value,
				sub_total: el.querySelector('.sub_total').value
			}

			// irrigation
			el = document.querySelector('.irrigation_s'+sem);

			irrigation[i] = {
				sem: sem,
				area: el.querySelector('.area').value,
				cost: el.querySelector('.cost').value,
				amount: el.querySelector('.total').value
			}

			// land rental
			el = document.querySelector('.land_rental_s'+sem);

			land_rental[i] = {
				sem: sem,
				area: el.querySelector('.area').value,
				cost: el.querySelector('.cost').value,
				amount: el.querySelector('.total').value
			}

			// seed production contracting
			el = document.querySelector('.production_contracting_s'+sem);

			production_contracting[i] = {
				sem: sem,
				seed_volume: el.querySelector('.volume').value,
				buying_price: el.querySelector('.price').value,
				amount: el.querySelector('.total').value
			}
		}

		var data = {
			year: year,
			seed_production_type: seed_production_type,
			area_station: area_station,
			area_outside: area_outside,
			area_contract: area_contract,
			remarks: remarks,
			total_s1: total_s1,
			total_s2: total_s2,
			area1_s1: area1_s1,
			area1_s2: area1_s2,
			area2_s1: area2_s1,
			area2_s2: area2_s2,
			clean_seed1_s1: clean_seed1_s1,
			clean_seed1_s2: clean_seed1_s2,
			clean_seed2_s1: clean_seed2_s1,
			clean_seed2_s2: clean_seed2_s2,
			production_cost_kilo_s1: production_cost_kilo_s1,
			production_cost_kilo_s2: production_cost_kilo_s2,
			production_cost_ha_s1: production_cost_ha_s1,
			production_cost_ha_s2: production_cost_ha_s2,
			seeding_rate: seeding_rate,
			seed_lab_amount_s1: seed_lab_amount_s1,
			seed_lab_amount_s2: seed_lab_amount_s2,
			land_preparation: land_preparation,
			seed_pulling: seed_pulling,
			fertilizers: fertilizers,
			harvesting: harvesting,
			drying: drying,
			seed_cleaning: seed_cleaning,
			service_contracts: service_contracts,
			service_contract_positions: service_contract_positions,
			planting_materials: planting_materials,
			field_supplies: field_supplies,
			fuel: fuel,
			irrigation: irrigation,
			land_rental: land_rental,
			production_contracting: production_contracting
		}

		console.log(data);
		// console.log(data === null);


		// submit using ajax post request
		$.ajax({
			type: 'POST',
			url: "{{route('production_cost_schedule.store')}}",
			data: {
				_token: "{{csrf_token()}}",
				data: data
			},
			dataType: 'JSON',
			success: (res) => {
				console.log(res);

				if (res === "success") {
					window.location.replace("{{route('production_cost_schedule.index')}}");
				} else {
					alert(res);
				}
			}
		});
	}
</script>