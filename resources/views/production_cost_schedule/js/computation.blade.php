<script type="text/javascript">
	// performs the specified operation to all the values that is being passed as parameter inside the class that was specified
	function compute(operation, class_name, values) {
		var el = document.querySelector('.'+class_name);

		var result = 0;

		for (var i = 0; i < values.length; i++) {
			var number = parseFloat(el.querySelector('.'+values[i]).value);

			if (operation == "add") // addition
				result += number;

			if (operation == "sub") // subtraction
				result = (!result == 0) ? result - number : number;

			if (operation == "mult") // multiplication
				result = (!result == 0) ? result * number : number;

			if (operation == "div") // division
				result = (!result == 0) ? result / number : number;
		}
		
		el.querySelector('.total').value = Math.ceil(result); // set the value
		el.querySelector('.total').onchange(); // fire onchange event for readonly input
	}

	// adds all the child class values for sub-total, component total and grand total
	function total(parent_class, child_class) {
		var el = document.querySelector('.'+parent_class);
		// console.log(el);

		var result = 0;

		var values = el.querySelectorAll('.'+child_class);

		for (var i = 0; i < values.length; i++)
			result += parseFloat(values[i].value);

		if (child_class == "total") {
			el.querySelector('.sub_total').value = result;
			el.querySelector('.sub_total').onchange(); // fire onchange event for readonly input

			// update production cost summary values
			document.querySelector('#'+parent_class).innerHTML = result.toLocaleString("en-US", {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2,
			});
		}

		if (child_class == "sub_total") {
			el.querySelector('.component_total').value = result;
			el.querySelector('.component_total').onchange(); // fire onchange event for readonly input

			// update production cost summary values
			document.querySelector('#'+parent_class).innerHTML = result.toLocaleString("en-US", {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2,
			});
		}

		if (child_class == "monthly_cost") {
			el.querySelector('.monthly_cost_sub_total').value = result;
		}

		// seed lab component is an exception to the total condition because it does not have that field
		if (parent_class == "seed_lab_component") {
			el = document.querySelector('.'+parent_class);

			for (var i=1; i<=2; i++) {
				var sub_total = el.querySelector('.sub_total_s'+i).value;

				// update production cost summary values for seed laboratory component
				document.querySelector('#seed_lab_s'+i).innerHTML = sub_total.toLocaleString("en-US", {
					minimumFractionDigits: 2,
					maximumFractionDigits: 2,
				});
			}
		}
	}

	// component total was a different function because querySelector cannot access individual tables inside the cost component table
	function component_total() {
		var elements = document.querySelectorAll('.component_total');
		var component_total = 0;

		elements.forEach((element) => {
			component_total += parseFloat(element.value);
		});

		document.querySelector('#total_prod_cost').innerHTML = component_total.toLocaleString("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});

		// let's place the computation of sub total for sem 1 and 2 here
		for (var i=1; i<=2; i++) {
			elements = document.querySelectorAll('.sub_total_s'+i);
			var sub_total = 0;

			elements.forEach((element) => {
				sub_total += parseFloat(element.value);
			});

			document.querySelector('#total_prod_cost_s'+i).innerHTML = sub_total.toLocaleString("en-US", {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2,
			});

			production_cost(i); // runs function production cost to update the production cost value
		}
	}

	// subtracts the manual area inputted to the combine area
	function combine_area(sem) {
		var el = document.querySelector('.manual_'+sem);
		var manual_area = el.querySelector('.manual_area').value;

		el = document.querySelector('.threshing_'+sem);
		el.querySelector('.manual_area').value = manual_area;

		el = document.querySelector('.towing_'+sem);
		el.querySelector('.manual_area').value = manual_area;

		el = document.querySelector('.scatter_'+sem);
		el.querySelector('.manual_area').value = manual_area;

		el = document.querySelector('.rotovate_'+sem);
		var area = el.querySelector('.area').value;

		var combine_area = parseFloat(area) - parseFloat(manual_area);

		el = document.querySelector('.combine_'+sem);
		el.querySelector('.area').value = combine_area;
	}

	// multiplies the average number of bags per hectare and area
	function compute_bags(sem, type) {
		var el = document.querySelector('.rotovate_'+sem);
		var area = el.querySelector('.area').value;

		if (type == "fresh")
			el = document.querySelector('.hauling_'+sem);
		if (type == "cleaned")
			el = document.querySelector('.seed_clean_'+sem);

		var average_bags = el.querySelector('.ave_bags').value;

		var bags = parseFloat(area) * parseFloat(average_bags);

		el.querySelector('.bags').value = bags;
		
		if (type == "fresh") {
			sacks_number(sem); // run sacks number function
			sacks_number_for_fresh(sem); // run sacks number for fresh function
		}
	}

	// computes for the average bag per hectare of clean seeds
	function compute_clean_ave(sem) {
		var el = document.querySelector('.hauling_'+sem);
		var fresh_bags = el.querySelector('.ave_bags').value;
		var seed_type = document.querySelector('.seed_production_type').value;

		switch (seed_type) {
			case "Inbred":
				var divisor = 20;
				break;
			case "Hybrid (AxR)":
				var divisor = 18;
				break;
			case "Hybrid (P and R)":
				var divisor = 5;
				break;
			case "Hybrid (S)":
				var divisor = 15;
				break;
			case "Hybrid (A)":
				var divisor = 15;
				break;
		}

		if (sem == "s1")
			var average_clean_bags = (parseFloat(fresh_bags) * 50) * ((100 - 21) / 88) / divisor;

		if (sem == "s2")
			var average_clean_bags = (parseFloat(fresh_bags) * 50) * ((100 - 25) / 88) / divisor;

		el = document.querySelector('.seed_clean_'+sem);
		average_clean_bags = Math.ceil(average_clean_bags)
		el.querySelector('.ave_bags').value = average_clean_bags; // rounds up
		el.querySelector('.ave_bags').onchange(); // fire onchange event
	}

	// computes for the monthly cost of the service contractor
	function monthly_cost(class_name, sc_count) {
		var el = document.querySelector('.'+class_name+'.'+sc_count);
		var workers_no = el.querySelector('.workers_no').value;
		var monthly_rate = el.querySelector('.monthly_rate').value;
		var monthly_cost = parseFloat(workers_no) * parseFloat(monthly_rate);

		el.querySelector('.monthly_cost').value = monthly_cost;
		el.querySelector('.monthly_cost').onchange(); // fire onchange event for input
	}

	// computes for the total amount of service contract position
	function contract_amount(class_name, sc_count, sem) {
		var el = document.querySelector('.months_hired_'+sem);
		var months = el.querySelector('.months').value;

		el = document.querySelector('.'+class_name+'.'+sc_count);
		var monthly_cost = el.querySelector('.monthly_cost').value;

		var amount = parseFloat(monthly_cost) * parseInt(months);

		total('service_contract_'+sem, 'monthly_cost');

		el.querySelector('.total').value = amount;
		el.querySelector('.total').onchange(); // fire onchange event for readonly input
	}

	// recomputes amount for service contracts
	function recompute_amount(sem) {		
		var count = (sem == 's1') ? sem1_sc_count : sem2_sc_count;

		for (var i = 1; i <= count; i++) {
			contract_amount('positions_'+sem, 'sc_'+i, sem);
			// console.log(i);
		}
	}

	// computes seed quantity for planting materials
	function compute_seed_quantity(sem, area) {
		var planting_materials = document.querySelector('.planting_materials_component');

		var seeding_rate = planting_materials.querySelector('.seeding_rate').value;
		seeding_rate = parseFloat(seeding_rate);

		if (!sem == 0 && !area == 0) {
			var el = planting_materials.querySelector('.planting_s'+sem);
			var production_area = el.querySelector('.area'+area).value;
			production_area = parseFloat(production_area);
			var seed_quantity = production_area * seeding_rate;

			// set seed quantity value
			el = el.querySelector('.planting_materials_'+area);
			el.querySelector('.seeds').value = seed_quantity;

			if (area == 2) {
				// subtract area2 to area1 and change area1 value to result
				var total_seed_production_area = document.querySelector('#total_production_area').value;
				total_seed_production_area = parseFloat(total_seed_production_area);

				new_area1 = total_seed_production_area - production_area;

				el = planting_materials.querySelector('.planting_s'+sem);
				el.querySelector('.area1').value = new_area1;

				// assigns value for production area in production cost summary
				var area_array = [new_area1, production_area];

				var summary = document.querySelector('.production_cost_summary');
		
				for (var i=1; i<=2; i++) {
					summary.querySelector('.area'+i+'_s'+sem).innerHTML = area_array[i-1].toLocaleString("en-US", {
						minimumFractionDigits: 2,
						maximumFractionDigits: 2,
					});
				}

				compute_seed_quantity(sem,1);
			}

			sacks_number('s'+sem); // run sacks number function
			clean_seeds_volume(sem); // run clean seeds volume function
		} else {
			compute_seed_quantity(1,1);
			compute_seed_quantity(1,2);
			compute_seed_quantity(2,1);
			compute_seed_quantity(2,2);
			compute_seeds_amount(0,0);

			clean_seeds_volume(1);
			clean_seeds_volume(2);
		}
	}

	// computes seeds amount
	function compute_seeds_amount(sem, area) {
		var planting_materials = document.querySelector('.planting_materials_component');

		if (!sem == 0 && !area == 0) {
			var el = planting_materials.querySelector('.planting_s'+sem);
			el = el.querySelector('.planting_materials_'+area);
			var seed_quantity = el.querySelector('.seeds').value;
			seed_quantity = parseFloat(seed_quantity);
			var cost = el.querySelector('.cost').value;
			cost = parseFloat(cost);

			// set amount value
			el.querySelector('.total').value = seed_quantity * cost;
			// fire onchange
			el.querySelector('.total').onchange();
		} else {
			compute_seeds_amount(1,1);
			compute_seeds_amount(1,2);
			compute_seeds_amount(2,1);
			compute_seeds_amount(2,2);
		}
	}

	// computes the number of sacks in field supplies
	function sacks_number(sem) {
		var el = document.querySelector('.seed_clean_'+sem); // s1 or s2
		var average_bags = el.querySelector('.ave_bags').value;
		average_bags = parseFloat(average_bags);

		var seed_production_type = document.querySelector('.seed_production_type').value;

		if (seed_production_type == "Hybrid (S)" || seed_production_type == "Hybrid (A)") {
			console.log('test');
			el = document.querySelector('.planting_s1');
			var area = el.querySelector('.area1').value;
			area = parseFloat(area);
			var sacks = Math.ceil(area * average_bags * 1.2);

			for (var i=1; i<=2; i++) {
				var field_supplies_el = document.querySelector('.field_supplies_'+sem);
				var sacks_el = field_supplies_el.querySelector('.sacks_'+i);
				sacks_el.querySelector('.sacks').value = sacks;
			}
		} else {
			el = document.querySelector('.planting_'+sem);

			for (var i=1; i<=2; i++) {
				var area = el.querySelector('.area'+i).value;
				area = parseFloat(area);
				var sacks = Math.ceil(area * average_bags * 1.2);

				// console.log(sacks);

				var field_supplies_el = document.querySelector('.field_supplies_'+sem);
				var sacks_el = field_supplies_el.querySelector('.sacks_'+i);
				sacks_el.querySelector('.sacks').value = sacks;
			}
		}
	}

	// computes the number of 50kg sacks fresh harvest in field supplies 
	function sacks_number_for_fresh(sem) {
		var el = document.querySelector('.hauling_'+sem);
		var bags = el.querySelector('.bags').value;
		bags = parseFloat(bags);

		var sacks = Math.ceil(bags * 1.1);

		var field_supplies_el = document.querySelector('.field_supplies_'+sem);
		var sacks_el = field_supplies_el.querySelector('.sacks_3');
		sacks_el.querySelector('.sacks').value = sacks;
	}

	// computes the amount of the item in field supplies
	function sacks_amount(sem, num) {
		var el = document.querySelector('.field_supplies_s'+sem);
		var row = el.querySelector('.sacks_'+num);
		var sacks = row.querySelector('.sacks').value;
		sacks = parseFloat(sacks);
		var cost = row.querySelector('.cost').value;
		cost = parseFloat(cost);

		var amount = Math.ceil(sacks * cost);

		row.querySelector('.total').value = amount;
	}

	// computes the clean seeds volume
	function clean_seeds_volume(sem) {
		var planting_material = document.querySelector('.planting_s'+sem);
		var seed_cleaning = document.querySelector('.seed_clean_s'+sem);
		var ave_bags = seed_cleaning.querySelector('.ave_bags').value;
		console.log("ave bags: " + ave_bags);

		var total_clean_seeds = 0;

		for (var i=1; i<=2; i++) {
			var area = planting_material.querySelector('.area'+i).value;
			area = parseFloat(area);

			var seed_type = document.querySelector('.seed_production_type').value;

			switch (seed_type) {
				case "Inbred":
					var multiplier = 20;
					break;
				case "Hybrid (AxR)":
					var multiplier = 18;
					break;
				case "Hybrid (P and R)":
					var multiplier = 5;
					break;
				case "Hybrid (S)":
					var multiplier = 15;
					break;
				case "Hybrid (A)":
					var multiplier = 15;
					break;
			}

			var clean_seed = area * multiplier * ave_bags;
			clean_seed = Math.ceil(clean_seed);
			document.querySelector('.clean_seed'+i+'_s'+sem).innerHTML = clean_seed.toLocaleString("en-US", {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2,
			});

			total_clean_seeds += clean_seed;
		}

		// set total clean seeds value in the production cost schedule summary table
		document.querySelector('.clean_seeds_total_s'+sem).innerHTML = total_clean_seeds.toLocaleString("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});

		production_cost(sem); // run production cost function
	}

	// computes the production cost
	function production_cost(sem) {
		// cost per kilo
		var production_cost = document.querySelector('#total_prod_cost_s'+sem).innerHTML;
		production_cost = parseFloat(production_cost.replace(/,/g, ''));

		var clean_seeds = document.querySelector('.clean_seeds_total_s'+sem).innerHTML;
		clean_seeds = parseFloat(clean_seeds.replace(/,/g, ''));

		var cost_per_kilo = production_cost / clean_seeds;
		cost_per_kilo = Math.ceil(cost_per_kilo);

		console.log("cost per kilo: " + cost_per_kilo);

		// set value of production cost per kilo
		document.querySelector('.prod_cost_kilo_s'+sem).innerHTML = cost_per_kilo.toLocaleString("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});

		// cost per hectare
		var total_area = 0;
		for (var i=1; i<=2; i++) {
			var area = document.querySelector('.area'+i+'_s'+sem).innerHTML;
			area = parseFloat(area.replace(/,/g, ''));

			total_area += area;
		}

		var cost_per_hectare = production_cost / total_area;
		cost_per_hectare = Math.ceil(cost_per_hectare);

		// set value of production cost per hectare
		document.querySelector('.prod_cost_ha_s'+sem).innerHTML = cost_per_hectare.toLocaleString("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});
	}
</script>