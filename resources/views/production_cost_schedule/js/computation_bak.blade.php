<script>
	var rot_area_s1 = document.getElementById('rot_area_s1');
	var rot_cost_s1 = document.getElementById('rot_cost_s1');
	var rot_amt_s1 = 0;
	var levelling_area_s1 = document.getElementById('levelling_area_s1');
	var levelling_cost_s1 = document.getElementById('levelling_cost_s1');
	var levelling_amt_s1 = 0;
	var land_prep_stotal_s1 = 0;
	var rot_area_s2 = document.getElementById('rot_area_s2');
	var rot_cost_s2 = document.getElementById('rot_cost_s2');
	var rot_amt_s2 = 0;
	var levelling_area_s2 = document.getElementById('levelling_area_s2');
	var levelling_cost_s2 = document.getElementById('levelling_cost_s2');
	var levelling_amt_s2 = 0;
	var land_prep_stotal_s2 = 0;
	var land_prep_total = 0;
	var seed_pulling_area_s1 = document.getElementById('seed_pulling_area_s1');
	var seed_pulling_cost_s1 = document.getElementById('seed_pulling_cost_s1');
	var seed_pulling_amt_s1 = 0;
	var emergency_labor_count_s1 = document.getElementById('emergency_labor_count_s1');
	var emergency_labor_area_s1 = document.getElementById('emergency_labor_area_s1');
	var emergency_labor_cost_s1 = document.getElementById('emergency_labor_cost_s1');
	var emergency_labor_amt_s1 = 0;
	var seed_pulling_area_s2 = document.getElementById('seed_pulling_area_s2');
	var seed_pulling_cost_s2 = document.getElementById('seed_pulling_cost_s2');
	var seed_pulling_amt_s2 = 0;
	var emergency_labor_count_s2 = document.getElementById('emergency_labor_count_s2');
	var emergency_labor_area_s2 = document.getElementById('emergency_labor_area_s2');
	var emergency_labor_cost_s2 = document.getElementById('emergency_labor_cost_s2');
	var emergency_labor_amt_s2 = 0;
	var seed_pulling_total = 0;
	var fertilizer_area_s1 = document.getElementById('fertilizer_area_s1');
	var fertilizer_cost_s1 = document.getElementById('fertilizer_cost_s1');
	var fertilizer_amt_s1 = 0;
	var fertilizer_area_s2 = document.getElementById('fertilizer_area_s2');
	var fertilizer_cost_s2 = document.getElementById('fertilizer_cost_s2');
	var fertilizer_amt_s2 = 0;
	var fertilizer_total = 0;
	var manual_harvest_area_s1 = document.getElementById('manual_harvest_area_s1');
	var manual_harvest_cost_s1 = document.getElementById('manual_harvest_cost_s1');
	var manual_harvest_amt_s1 = 0;
	var mech_harvest_area_s1 = document.getElementById('mech_harvest_area_s1');
	var mech_harvest_cost_s1 = document.getElementById('mech_harvest_cost_s1');
	var mech_harvest_amt_s1 = 0;
	var ave_bags_harvest_s1 = document.getElementById('ave_bags_harvest_s1');
	var hauling_bags_s1 = document.getElementById('hauling_bags_s1');
	var hauling_cost_s1 = document.getElementById('hauling_cost_s1');
	var hauling_amt_s1 = 0;
	var threshing_area_s1 = document.getElementById('threshing_area_s1');
	var threshing_cost_s1 = document.getElementById('threshing_cost_s1');
	var threshing_amt_s1 = 0;
	var towing_area_s1 = document.getElementById('towing_area_s1');
	var towing_cost_s1 = document.getElementById('towing_cost_s1');
	var towing_amt_s1 = 0;
	var hay_scatter_area_s1 = document.getElementById('hay_scatter_area_s1');
	var hay_scatter_cost_s1 = document.getElementById('hay_scatter_cost_s1');
	var hay_scatter_amt_s1 = 0;
	var harvest_stotal_s1 = 0;
	var manual_harvest_area_s2 = document.getElementById('manual_harvest_area_s2');
	var manual_harvest_cost_s2 = document.getElementById('manual_harvest_cost_s2');
	var manual_harvest_amt_s2 = 0;
	var mech_harvest_area_s2 = document.getElementById('mech_harvest_area_s2');
	var mech_harvest_cost_s2 = document.getElementById('mech_harvest_cost_s2');
	var mech_harvest_amt_s2 = 0;
	var ave_bags_harvest_s2 = document.getElementById('ave_bags_harvest_s2');
	var hauling_bags_s2 = document.getElementById('hauling_bags_s2');
	var hauling_cost_s2 = document.getElementById('hauling_cost_s2');
	var hauling_amt_s2 = 0;
	var threshing_area_s2 = document.getElementById('threshing_area_s2');
	var threshing_cost_s2 = document.getElementById('threshing_cost_s2');
	var threshing_amt_s2 = 0;
	var towing_area_s2 = document.getElementById('towing_area_s2');
	var towing_cost_s2 = document.getElementById('towing_cost_s2');
	var towing_amt_s2 = 0;
	var hay_scatter_area_s2 = document.getElementById('hay_scatter_area_s2');
	var hay_scatter_cost_s2 = document.getElementById('hay_scatter_cost_s2');
	var hay_scatter_amt_s2 = 0;
	var harvest_stotal_s2 = 0;
	var harvest_total = 0;
	var drying_bags_s1 = document.getElementById('drying_bags_s1');
	var drying_cost_s1 = document.getElementById('drying_cost_s1');
	var drying_amt_s1 = 0;
	var drying_emergency_labor_s1 = document.getElementById('drying_emergency_labor_s1');
	var drying_emergency_labor_days_s1 = document.getElementById('drying_emergency_labor_days_s1');
	var drying_emergency_labor_cost_s1 = document.getElementById('drying_emergency_labor_cost_s1');
	var drying_emergency_labor_amt_s1 = 0;
	var drying_stotal_s1 = 0;
	var drying_bags_s2 = document.getElementById('drying_bags_s2');
	var drying_cost_s2 = document.getElementById('drying_cost_s2');
	var drying_amt_s2 = 0;
	var drying_emergency_labor_s2 = document.getElementById('drying_emergency_labor_s2');
	var drying_emergency_labor_days_s2 = document.getElementById('drying_emergency_labor_days_s2');
	var drying_emergency_labor_cost_s2 = document.getElementById('drying_emergency_labor_cost_s2');
	var drying_emergency_labor_amt_s2 = 0;
	var drying_stotal_s2 = 0;
	var drying_total = 0;
	var seed_clean_ave_bags_s1 = document.getElementById('seed_clean_ave_bags_s1');
	var seed_clean_qty_s1 = document.getElementById('seed_clean_qty_s1');
	var seed_clean_cost_s1 = document.getElementById('seed_clean_cost_s1');
	var seed_clean_amt_s1 = 0;
	var seed_clean_ave_bags_s2 = document.getElementById('seed_clean_ave_bags_s2');
	var seed_clean_qty_s2 = document.getElementById('seed_clean_qty_s2');
	var seed_clean_cost_s2 = document.getElementById('seed_clean_cost_s2');
	var seed_clean_amt_s2 = 0;
	var seed_clean_total = 0;
	var months_hired_s1 = document.getElementById('months_hired_s1');
	var sc_monthly_cost_stotal_s1 = 0;
	var sc_stotal_s1 = 0;
	var months_hired_s2 = document.getElementById('months_hired_s2');
	var sc_monthly_cost_stotal_s2 = 0;
	var sc_stotal_s2 = 0;
	var sc_total = 0;
	var seeding_rate = document.getElementById('seeding_rate');
	var rs_area_s1 = document.getElementById('rs_area_s1');
	var fs_area_s1 = document.getElementById('fs_area_s1');
	var seeds_rs_s1 = document.getElementById('seeds_rs_s1');
	var seeds_rs_cost_s1 = document.getElementById('seeds_rs_cost_s1');
	var seeds_rs_amt_s1 = 0;
	var seeds_fs_s1 = document.getElementById('seeds_fs_s1');
	var seeds_fs_cost_s1 = document.getElementById('seeds_fs_cost_s1');
	var seeds_fs_amt_s1 = 0;
	var seeds_stotal_s1 = 0;
	var rs_area_s2 = document.getElementById('rs_area_s2');
	var fs_area_s2 = document.getElementById('fs_area_s2');
	var seeds_rs_s2 = document.getElementById('seeds_rs_s2');
	var seeds_rs_cost_s2 = document.getElementById('seeds_rs_cost_s2');
	var seeds_rs_amt_s2 = 0;
	var seeds_fs_s2 = document.getElementById('seeds_fs_s2');
	var seeds_fs_cost_s2 = document.getElementById('seeds_fs_cost_s2');
	var seeds_fs_amt_s2 = 0;
	var seeds_stotal_s2 = 0;
	var seeds_total = 0;
	var lam_sacks_20kg_s1 = document.getElementById('lam_sacks_20kg_s1');
	var lam_sacks_20kg_cost_s1 = document.getElementById('lam_sacks_20kg_cost_s1');
	var lam_sacks_20kg_amt_s1 = 0;
	var lam_sacks_10kg_s1 = document.getElementById('lam_sacks_10kg_s1');
	var lam_sacks_10kg_cost_s1 = document.getElementById('lam_sacks_10kg_cost_s1');
	var lam_sacks_10kg_amt_s1 = 0;
	var sacks_50kg_s1 = document.getElementById('sacks_50kg_s1');
	var sacks_50kg_cost_s1 = document.getElementById('sacks_50kg_cost_s1');
	var sacks_50kg_amt_s1 = 0;
	var other_field_supp_s1 = document.getElementById('other_field_supp_s1');
	var field_supp_stotal_s1 = 0;
	var lam_sacks_20kg_s2 = document.getElementById('lam_sacks_20kg_s2');
	var lam_sacks_20kg_cost_s2 = document.getElementById('lam_sacks_20kg_cost_s2');
	var lam_sacks_20kg_amt_s2 = 0;
	var lam_sacks_10kg_s2 = document.getElementById('lam_sacks_10kg_s2');
	var lam_sacks_10kg_cost_s2 = document.getElementById('lam_sacks_10kg_cost_s2');
	var lam_sacks_10kg_amt_s2 = 0;
	var sacks_50kg_s2 = document.getElementById('sacks_50kg_s2');
	var sacks_50kg_cost_s2 = document.getElementById('sacks_50kg_cost_s2');
	var sacks_50kg_amt_s2 = 0;
	var other_field_supp_s2 = document.getElementById('other_field_supp_s2');
	var field_supp_stotal_s2 = 0;
	var field_supp_total = 0;
	var total_service_area_s1 = document.getElementById('total_service_area_s1');
	var diesel_liters_ha_s1 = document.getElementById('diesel_liters_ha_s1');
	var diesel_per_liter_s1 = document.getElementById('diesel_per_liter_s1');
	var diesel_amt_s1 = 0;
	var gas_liters_ha_s1 = document.getElementById('gas_liters_ha_s1');
	var gas_per_liter_s1 = document.getElementById('gas_per_liter_s1');
	var gas_amt_s1 = 0;
	var kerosene_liters_ha_s1 = document.getElementById('kerosene_liters_ha_s1');
	var kerosene_per_liter_s1 = document.getElementById('kerosene_per_liter_s1');
	var kerosene_amt_s1 = 0;
	var fuel_stotal_s1 = 0;
	var total_service_area_s2 = document.getElementById('total_service_area_s2');
	var diesel_liters_ha_s2 = document.getElementById('diesel_liters_ha_s2');
	var diesel_per_liter_s2 = document.getElementById('diesel_per_liter_s2');
	var diesel_amt_s2 = 0;
	var gas_liters_ha_s2 = document.getElementById('gas_liters_ha_s2');
	var gas_per_liter_s2 = document.getElementById('gas_per_liter_s2');
	var gas_amt_s2 = 0;
	var kerosene_liters_ha_s2 = document.getElementById('kerosene_liters_ha_s2');
	var kerosene_per_liter_s2 = document.getElementById('kerosene_per_liter_s2');
	var kerosene_amt_s2 = 0;
	var fuel_stotal_s2 = 0;
	var fuel_total = 0;
	var irrigation_area_s1 = document.getElementById('irrigation_area_s1');
	var irrigation_cost_s1 = document.getElementById('irrigation_cost_s1');
	var irrigation_amt_s1 = 0;
	var irrigation_area_s2 = document.getElementById('irrigation_area_s2');
	var irrigation_cost_s2 = document.getElementById('irrigation_cost_s2');
	var irrigation_amt_s2 = 0;
	var irrigation_total = 0;
	var seed_lab_fee_s1 = document.getElementById('seed_lab_fee_s1');
	var seed_lab_fee_s2 = document.getElementById('seed_lab_fee_s2');
	var seed_lab_fee_total = 0;
	var land_rental_area_s1 = document.getElementById('land_rental_area_s1');
	var land_rental_cost_s1 = document.getElementById('land_rental_cost_s1');
	var land_rental_amt_s1 = 0;
	var land_rental_area_s2 = document.getElementById('land_rental_area_s2');
	var land_rental_cost_s2 = document.getElementById('land_rental_cost_s2');
	var land_rental_amt_s2 = 0;
	var land_rental_total = 0;
	var seed_prod_cont_vol_s1 = document.getElementById('seed_prod_cont_vol_s1');
	var seed_prod_cont_price_s1 = document.getElementById('seed_prod_cont_price_s1');
	var seed_prod_cont_amt_s1 = 0;
	var seed_prod_cont_vol_s2 = document.getElementById('seed_prod_cont_vol_s2');
	var seed_prod_cont_price_s2 = document.getElementById('seed_prod_cont_price_s2');
	var seed_prod_cont_amt_s2 = 0;
	var seed_prod_cont_total = 0;
	var total_prod_cost_s1 = 0;
	var total_prod_cost_s2 = 0;
	var total_prod_cost = 0;
	var serv_con_row_count_s1 = 1;
	var serv_con_row_count_s2 = 1;
	var rem_serv_con_button_s1 = document.getElementById('rem_serv_con_button_s1');
	var rem_serv_con_button_s2 = document.getElementById('rem_serv_con_button_s2');

	$('document').ready(() => {
		compute_seeds();
	});

	function compute_rot_s1() {
		if (rot_area_s1.value != "" && rot_cost_s1.value != "") {
			console.log("Rot area S1: " + rot_area_s1.value + "\n Rot cost S1: " + rot_cost_s1.value);

			rot_amt_s1 = parseFloat(rot_area_s1.value * rot_cost_s1.value);
			document.getElementById('rot_amt_s1').innerHTML = to_locale_string(rot_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_land_prep_stotal_s1();
		compute_mech_harvest_area_s1();
		compute_hauling_bags_s1();
	}

	function compute_levelling_s1() {
		if (levelling_area_s1.value != "" && levelling_cost_s1.value != "") {
			console.log("Levelling area S1: " + levelling_area_s1.value + "\n Levelling cost S1: " + levelling_cost_s1.value);

			levelling_amt_s1 = parseFloat(levelling_area_s1.value * levelling_cost_s1.value);
			document.getElementById('levelling_amt_s1').innerHTML = to_locale_string(levelling_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_land_prep_stotal_s1();
	}

	function add_land_prep_stotal_s1() {
		land_prep_stotal_s1 = parseFloat(rot_amt_s1 + levelling_amt_s1);
		console.log("Land Preparation Sub Total S1:" + land_prep_stotal_s1);

		if (!isNaN(land_prep_stotal_s1)) {
			document.getElementById('land_prep_stotal_s1').innerHTML = to_locale_string(land_prep_stotal_s1);
			document.getElementById('land_prep_stotal_s1_summary').innerHTML = to_locale_string(land_prep_stotal_s1);
		}

		add_land_prep_total();
		add_total_prod_cost_s1();
	}

	function compute_rot_s2() {
		if (rot_area_s2.value != "" && rot_cost_s2.value != "") {
			console.log("Rot area S2: " + rot_area_s2.value + "\n Rot cost S2: " + rot_cost_s2.value);

			rot_amt_s2 = parseFloat(rot_area_s2.value * rot_cost_s2.value);
			document.getElementById('rot_amt_s2').innerHTML = to_locale_string(rot_amt_s2);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_land_prep_stotal_s2();
		compute_mech_harvest_area_s2();
		compute_hauling_bags_s2();
	}

	function compute_levelling_s2() {
		if (levelling_area_s2.value != "" && levelling_cost_s2.value != "") {
			console.log("Levelling area S2: " + levelling_area_s2.value + "\n Levelling cost S2: " + levelling_cost_s2.value);

			levelling_amt_s2 = parseFloat(levelling_area_s2.value * levelling_cost_s2.value);
			document.getElementById('levelling_amt_s2').innerHTML = to_locale_string(levelling_amt_s2);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_land_prep_stotal_s2();
	}

	function add_land_prep_stotal_s2() {
		land_prep_stotal_s2 = parseFloat(rot_amt_s2 + levelling_amt_s2);
		console.log("Land Preparation Sub Total S2:" + land_prep_stotal_s2);

		if (!isNaN(land_prep_stotal_s2)) {
			document.getElementById('land_prep_stotal_s2').innerHTML = to_locale_string(land_prep_stotal_s2);
			document.getElementById('land_prep_stotal_s2_summary').innerHTML = to_locale_string(land_prep_stotal_s2);
		}

		add_land_prep_total();
		add_total_prod_cost_s2();
	}

	function add_land_prep_total() {
		land_prep_total = parseFloat(land_prep_stotal_s1 + land_prep_stotal_s2);
		console.log("Land Preparation Total: " + land_prep_total);

		if (!isNaN(land_prep_total)) {
			document.getElementById('land_prep_total').innerHTML = to_locale_string(land_prep_total);
			document.getElementById('land_prep_total_summary').innerHTML = to_locale_string(land_prep_total);
		}
	}

	function compute_seed_pulling_s1() {
		if (seed_pulling_area_s1.value != "" && seed_pulling_cost_s1.value != "") {
			console.log("Seed pulling area S1: " + seed_pulling_area_s1.value + "\n Seed pulling cost S1: " + seed_pulling_cost_s1.value);

			seed_pulling_amt_s1 = parseFloat(seed_pulling_area_s1.value * seed_pulling_cost_s1.value);
			document.getElementById('seed_pulling_amt_s1').innerHTML = to_locale_string(seed_pulling_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_seed_pulling_total();
		add_seed_pulling_s1();
	}

	function compute_emergency_labor_s1() {
		if (emergency_labor_count_s1.value != "" && emergency_labor_area_s1.value != "" && emergency_labor_cost_s1.value != "") {
			console.log("Emergency labor count S1: " + emergency_labor_count_s1.value + "\n Emergency labor area S1: " + emergency_labor_area_s1.value + "\n Emergency labor cost S1: " + emergency_labor_cost_s1.value);

			emergency_labor_amt_s1 = parseFloat((emergency_labor_count_s1.value * emergency_labor_area_s1.value) * emergency_labor_cost_s1.value);
			document.getElementById('emergency_labor_amt_s1').innerHTML = to_locale_string(emergency_labor_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_seed_pulling_total();
		add_seed_pulling_s1();
	}

	function add_seed_pulling_s1() {
		var seed_pulling_stotal_s1 = parseFloat(seed_pulling_amt_s1 + emergency_labor_amt_s1);
		console.log("Seed Pulling, Marking & Transplanting Total S1:" + seed_pulling_stotal_s1);

		if (!isNaN(seed_pulling_stotal_s1)) {
			document.getElementById('seed_pulling_stotal_s1_summary').innerHTML = to_locale_string(seed_pulling_stotal_s1);
		}

		add_total_prod_cost_s1();
	}

	function compute_seed_pulling_s2() {
		if (seed_pulling_area_s2.value != "" && seed_pulling_cost_s2.value != "") {
			console.log("Seed pulling area S2: " + seed_pulling_area_s2.value + "\n Seed pulling cost S2: " + seed_pulling_cost_s2.value);

			seed_pulling_amt_s2 = parseFloat(seed_pulling_area_s2.value * seed_pulling_cost_s2.value);
			document.getElementById('seed_pulling_amt_s2').innerHTML = to_locale_string(seed_pulling_amt_s2);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_seed_pulling_total();
		add_seed_pulling_s2();
	}

	function compute_emergency_labor_s2() {
		if (emergency_labor_count_s2.value != "" && emergency_labor_area_s2.value != "" && emergency_labor_cost_s2.value != "") {
			console.log("Emergency labor count S2: " + emergency_labor_count_s2.value + "\n Emergency labor area S2: " + emergency_labor_area_s2.value + "\n Emergency labor cost S2: " + emergency_labor_cost_s2.value);

			emergency_labor_amt_s2 = parseFloat((emergency_labor_count_s2.value * emergency_labor_area_s2.value) * emergency_labor_cost_s2.value);
			document.getElementById('emergency_labor_amt_s2').innerHTML = to_locale_string(emergency_labor_amt_s2);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_seed_pulling_total();
		add_seed_pulling_s2();
	}

	function add_seed_pulling_s2() {
		var seed_pulling_stotal_s2 = parseFloat(seed_pulling_amt_s2 + emergency_labor_amt_s2);
		console.log("Seed Pulling, Marking & Transplanting Total S2:" + seed_pulling_stotal_s2);

		if (!isNaN(seed_pulling_stotal_s2)) {
			document.getElementById('seed_pulling_stotal_s2_summary').innerHTML = to_locale_string(seed_pulling_stotal_s2);
		}

		add_total_prod_cost_s2();
	}

	function add_seed_pulling_total() {
		seed_pulling_total = parseFloat(seed_pulling_amt_s1 + emergency_labor_amt_s1 + seed_pulling_amt_s2 + emergency_labor_amt_s2);
		console.log("Seed Pulling, Marking & Transplanting Total: " + seed_pulling_total);

		if (!isNaN(seed_pulling_total)) {
			document.getElementById('seed_pulling_total').innerHTML = to_locale_string(seed_pulling_total);
			document.getElementById('seed_pulling_total_summary').innerHTML = to_locale_string(seed_pulling_total);
		}
	}

	function compute_fertilizer_s1() {
		if (fertilizer_area_s1.value != "" && fertilizer_cost_s1.value != "") {
			console.log("Fertilizer area S2: " + fertilizer_area_s1.value + "\n Fertilizer cost S2: " + fertilizer_cost_s1.value);

			fertilizer_amt_s1 = parseFloat(fertilizer_area_s1.value * fertilizer_cost_s1.value);
			document.getElementById('fertilizer_amt_s1').innerHTML = to_locale_string(fertilizer_amt_s1);
			document.getElementById('fertilizer_amt_s1_summary').innerHTML = to_locale_string(fertilizer_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_fertilizer_total();
		add_total_prod_cost_s1();
	}

	function compute_fertilizer_s2() {
		if (fertilizer_area_s2.value != "" && fertilizer_cost_s2.value != "") {
			console.log("Fertilizer area S2: " + fertilizer_area_s2.value + "\n Fertilizer cost S2: " + fertilizer_cost_s2.value);

			fertilizer_amt_s2 = parseFloat(fertilizer_area_s2.value * fertilizer_cost_s2.value);
			document.getElementById('fertilizer_amt_s2').innerHTML = to_locale_string(fertilizer_amt_s2);
			document.getElementById('fertilizer_amt_s2_summary').innerHTML = to_locale_string(fertilizer_amt_s2);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_fertilizer_total();
		add_total_prod_cost_s2();
	}

	function add_fertilizer_total() {
		fertilizer_total = parseFloat(fertilizer_amt_s1 + fertilizer_amt_s2);
		console.log("Chemicals & Fertilizers: " + fertilizer_total);

		if (!isNaN(fertilizer_total)) {
			document.getElementById('fertilizer_total').innerHTML = to_locale_string(fertilizer_total);
			document.getElementById('fertilizer_total_summary').innerHTML = to_locale_string(fertilizer_total);
		}
	}

	function compute_manual_harvest_s1() {
		if (manual_harvest_area_s1.value != "" && manual_harvest_cost_s1.value != "") {
			console.log("Manual harvest area S1: " + manual_harvest_area_s1.value + "\n Manual harvest cost S1: " + manual_harvest_cost_s1.value);

			manual_harvest_amt_s1 = parseFloat(manual_harvest_area_s1.value * manual_harvest_cost_s1.value);
			document.getElementById('manual_harvest_amt_s1').innerHTML = to_locale_string(manual_harvest_amt_s1);

			document.getElementById('threshing_area_s1').value = manual_harvest_area_s1.value;
			document.getElementById('towing_area_s1').value = manual_harvest_area_s1.value;
			document.getElementById('hay_scatter_area_s1').value = manual_harvest_area_s1.value;
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_harvest_stotal_s1();
		compute_mech_harvest_area_s1();
	}

	function compute_mech_harvest_area_s1() {
		var mech_harvest_area = parseFloat(rot_area_s1.value - manual_harvest_area_s1.value);
		document.getElementById('mech_harvest_area_s1').value = mech_harvest_area;
	}

	function compute_mech_harvest_s1() {
		if (mech_harvest_area_s1.value != "" && mech_harvest_cost_s1.value != "") {
			console.log("Mechanical harvest area S1: " + mech_harvest_area_s1.value + "\n Mechanical harvest cost S1: " + mech_harvest_cost_s1.value);

			mech_harvest_amt_s1 = parseFloat(mech_harvest_area_s1.value * mech_harvest_cost_s1.value);
			document.getElementById('mech_harvest_amt_s1').innerHTML = to_locale_string(mech_harvest_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_harvest_stotal_s1();
	}

	function compute_hauling_bags_s1() {
		if (rot_area_s1.value != "" && ave_bags_harvest_s1.value != "") {
			console.log("Area S1: " + rot_area_s1.value + "\n Average 50-kg bags (fresh harvest) per ha S1: " + ave_bags_harvest_s1.value);

			var hauling_bags = parseFloat(rot_area_s1.value * ave_bags_harvest_s1.value)
			hauling_bags_s1.value = Math.round(hauling_bags);
			hauling_bags_s1.setAttribute('trueVal', hauling_bags);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		compute_hauling_s1();
		add_harvest_stotal_s1();
		compute_seed_clean_ave_bags_s1();
		compute_lam_sacks();
	}

	function compute_hauling_s1() {
		if (hauling_bags_s1.value != "" && hauling_cost_s1.value != "") {
			console.log("No. of bags S1: " + hauling_bags_s1.value + "\n Per bag S1: " + hauling_cost_s1.value);

			hauling_amt_s1 = parseFloat(hauling_bags_s1.getAttribute('trueVal') * hauling_cost_s1.value);
			document.getElementById('hauling_amt_s1').innerHTML = to_locale_string(hauling_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_harvest_stotal_s1();
	}

	function compute_threshing_s1() {
		if (threshing_area_s1.value != "" && threshing_cost_s1.value != "") {
			console.log("Threshing no. of ha S1: " + threshing_area_s1.value + "\n Per ha S1: " + threshing_cost_s1.value);

			threshing_amt_s1 = parseFloat(threshing_area_s1.value * threshing_cost_s1.value);
			document.getElementById('threshing_amt_s1').innerHTML = to_locale_string(threshing_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_harvest_stotal_s1();
	}

	function compute_towing_s1() {
		if (towing_area_s1.value != "" && towing_cost_s1.value != "") {
			console.log("Towing of thresher S1: " + towing_area_s1.value + "\n Per ha S1: " + towing_cost_s1.value);

			towing_amt_s1 = parseFloat(towing_area_s1.value * towing_cost_s1.value);
			document.getElementById('towing_amt_s1').innerHTML = to_locale_string(towing_amt_s1);
		} else {
			document.getElementById('towing_amt_s1').innerHTML = "-";
		}

		add_harvest_stotal_s1();
	}

	function compute_hay_scatter_s1() {
		if (hay_scatter_area_s1.value != "" && hay_scatter_cost_s1.value != "") {
			console.log("Hay scattering S1: " + towing_area_s1.value + "\n Per ha S1: " + towing_cost_s1.value);

			hay_scatter_amt_s1 = parseFloat(hay_scatter_area_s1.value * hay_scatter_cost_s1.value);
			document.getElementById('hay_scatter_amt_s1').innerHTML = to_locale_string(hay_scatter_amt_s1);
		} else {
			document.getElementById('hay_scatter_amt_s1').innerHTML = "-";
		}

		add_harvest_stotal_s1();
	}

	function add_harvest_stotal_s1() {
		harvest_stotal_s1 = parseFloat(manual_harvest_amt_s1 + mech_harvest_amt_s1 + hauling_amt_s1 + threshing_amt_s1 + towing_amt_s1 + hay_scatter_amt_s1);
		console.log("Harvesting Sub Total S1:" + harvest_stotal_s1);

		if (!isNaN(harvest_stotal_s1)) {
			document.getElementById('harvest_stotal_s1').innerHTML = to_locale_string(harvest_stotal_s1);
			document.getElementById('harvest_stotal_s1_summary').innerHTML = to_locale_string(harvest_stotal_s1);
		}

		add_harvest_total();
		add_total_prod_cost_s1();
	}

	function compute_manual_harvest_s2() {
		if (manual_harvest_area_s2.value != "" && manual_harvest_cost_s2.value != "") {
			console.log("Manual harvest area S2: " + manual_harvest_area_s2.value + "\n Manual harvest cost S2: " + manual_harvest_cost_s2.value);

			manual_harvest_amt_s2 = parseFloat(manual_harvest_area_s2.value * manual_harvest_cost_s2.value);
			document.getElementById('manual_harvest_amt_s2').innerHTML = to_locale_string(manual_harvest_amt_s2);

			document.getElementById('threshing_area_s2').value = manual_harvest_area_s2.value;
			document.getElementById('towing_area_s2').value = manual_harvest_area_s2.value;
			document.getElementById('hay_scatter_area_s2').value = manual_harvest_area_s2.value;
		} else {
			document.getElementById('towing_amt_s2').innerHTML = "-";
		}

		add_harvest_stotal_s2();
		compute_mech_harvest_area_s2();
	}

	function compute_mech_harvest_area_s2() {
		var mech_harvest_area = parseFloat(rot_area_s2.value - manual_harvest_area_s2.value);
		document.getElementById('mech_harvest_area_s2').value = mech_harvest_area;
	}

	function compute_mech_harvest_s2() {
		if (mech_harvest_area_s2.value != "" && mech_harvest_cost_s2.value != "") {
			console.log("Mechanical harvest area S2: " + mech_harvest_area_s2.value + "\n Mechanical harvest cost S2: " + mech_harvest_cost_s2.value);

			mech_harvest_amt_s2 = parseFloat(mech_harvest_area_s2.value * mech_harvest_cost_s2.value);
			document.getElementById('mech_harvest_amt_s2').innerHTML = to_locale_string(mech_harvest_amt_s2);
		} else {
			document.getElementById('towing_amt_s2').innerHTML = "-";
		}

		add_harvest_stotal_s2();
	}

	function compute_hauling_bags_s2() {
		if (rot_area_s2.value != "" && ave_bags_harvest_s2.value != "") {
			console.log("Area S2: " + rot_area_s2.value + "\n Average 50-kg bags (fresh harvest) per ha S2: " + ave_bags_harvest_s2.value);

			var hauling_bags = parseFloat(rot_area_s2.value * ave_bags_harvest_s2.value)
			hauling_bags_s2.value = Math.round(hauling_bags);
			hauling_bags_s2.setAttribute('trueVal', hauling_bags);
		} else {
			document.getElementById('towing_amt_s2').innerHTML = "-";
		}

		compute_hauling_s2();
		add_harvest_stotal_s2();
		compute_seed_clean_ave_bags_s2();
		compute_lam_sacks();
	}

	function compute_hauling_s2() {
		if (hauling_bags_s2.value != "" && hauling_cost_s2.value != "") {
			console.log("No. of bags S2: " + hauling_bags_s2.value + "\n Per bag S2: " + hauling_cost_s2.value);

			hauling_amt_s2 = parseFloat(hauling_bags_s2.getAttribute('trueVal') * hauling_cost_s2.value);
			document.getElementById('hauling_amt_s2').innerHTML = to_locale_string(hauling_amt_s2);
		} else {
			document.getElementById('towing_amt_s2').innerHTML = "-";
		}

		add_harvest_stotal_s2();
	}

	function compute_threshing_s2() {
		if (threshing_area_s2.value != "" && threshing_cost_s2.value != "") {
			console.log("Threshing no. of ha S2: " + threshing_area_s2.value + "\n Per ha S2: " + threshing_cost_s2.value);

			threshing_amt_s2 = parseFloat(threshing_area_s2.value * threshing_cost_s2.value);
			document.getElementById('threshing_amt_s2').innerHTML = to_locale_string(threshing_amt_s2);
		} else {
			document.getElementById('towing_amt_s2').innerHTML = "-";
		}

		add_harvest_stotal_s2();
	}

	function compute_towing_s2() {
		if (towing_area_s2.value != "" && towing_cost_s2.value != "") {
			console.log("Towing of thresher S2: " + towing_area_s2.value + "\n Per ha S2: " + towing_cost_s2.value);

			towing_amt_s2 = parseFloat(towing_area_s2.value * towing_cost_s2.value);
			document.getElementById('towing_amt_s2').innerHTML = to_locale_string(towing_amt_s2);
		} else {
			document.getElementById('towing_amt_s2').innerHTML = "-";
		}

		add_harvest_stotal_s2();
	}

	function compute_hay_scatter_s2() {
		if (hay_scatter_area_s2.value != "" && hay_scatter_cost_s2.value != "") {
			console.log("Hay scattering S2: " + towing_area_s2.value + "\n Per ha S2: " + towing_cost_s2.value);

			hay_scatter_amt_s2 = parseFloat(hay_scatter_area_s2.value * hay_scatter_cost_s2.value);
			document.getElementById('hay_scatter_amt_s2').innerHTML = to_locale_string(hay_scatter_amt_s2);
		} else {
			document.getElementById('hay_scatter_amt_s2').innerHTML = "-";
		}

		add_harvest_stotal_s2();
	}

	function add_harvest_stotal_s2() {
		harvest_stotal_s2 = parseFloat(manual_harvest_amt_s2 + mech_harvest_amt_s2 + hauling_amt_s2 + threshing_amt_s2 + towing_amt_s2 + hay_scatter_amt_s2);
		console.log("Harvesting Sub Total S2:" + harvest_stotal_s2);

		if (!isNaN(harvest_stotal_s2)) {
			document.getElementById('harvest_stotal_s2').innerHTML = to_locale_string(harvest_stotal_s2);
			document.getElementById('harvest_stotal_s2_summary').innerHTML = to_locale_string(harvest_stotal_s2);
		}

		add_harvest_total();
		add_total_prod_cost_s2();
	}

	function add_harvest_total() {
		harvest_total = parseFloat(harvest_stotal_s1 + harvest_stotal_s2);
		console.log("Harvesting: " + harvest_total);

		if (!isNaN(harvest_total)) {
			document.getElementById('harvest_total').innerHTML = to_locale_string(harvest_total);
			document.getElementById('harvest_total_summary').innerHTML = to_locale_string(harvest_total);
		}
	}

	function compute_drying_s1() {
		if (drying_bags_s1.value != "" && drying_cost_s1.value != "") {
			console.log("No. of bags S1: " + drying_bags_s1.value + "\n Per bag S1: " + drying_cost_s1.value);

			drying_amt_s1 = parseFloat(drying_bags_s1.value * drying_cost_s1.value);
			document.getElementById('drying_amt_s1').innerHTML = to_locale_string(drying_amt_s1);
		} else {
			document.getElementById('drying_amt_s1').innerHTML = "-";
		}

		add_drying_stotal_s1();
	}

	function compute_drying_emergency_labor_s1() {
		if (drying_emergency_labor_s1.value != "" && drying_emergency_labor_days_s1.value != "" && drying_emergency_labor_cost_s1.value != "") {
			console.log("No. of emergency labrorers S1: " + drying_emergency_labor_s1.value + "\n No. of days S1: " + drying_emergency_labor_days_s1.value + "\n Per day S1: " + drying_emergency_labor_cost_s1.value);

			drying_emergency_labor_amt_s1 = parseFloat((drying_emergency_labor_s1.value * drying_emergency_labor_days_s1.value) * drying_emergency_labor_cost_s1.value);
			document.getElementById('drying_emergency_labor_amt_s1').innerHTML = to_locale_string(drying_emergency_labor_amt_s1);
		} else {
			document.getElementById('drying_emergency_labor_amt_s1').innerHTML = "-";
		}

		add_drying_stotal_s1();
	}

	function add_drying_stotal_s1() {
		drying_stotal_s1 = parseFloat(drying_amt_s1 + drying_emergency_labor_amt_s1);
		console.log("Drying Sub Total S1: " + drying_stotal_s1);

		if (!isNaN(drying_stotal_s1)) {
			document.getElementById('drying_stotal_s1').innerHTML = to_locale_string(drying_stotal_s1);
			document.getElementById('drying_stotal_s1_summary').innerHTML = to_locale_string(drying_stotal_s1);
		}

		add_drying_total();
		add_total_prod_cost_s1();
	}

	function compute_drying_s2() {
		if (drying_bags_s2.value != "" && drying_cost_s2.value != "") {
			console.log("No. of bags S2: " + drying_bags_s2.value + "\n Per bag S2: " + drying_cost_s2.value);

			drying_amt_s2 = parseFloat(drying_bags_s2.value * drying_cost_s2.value);
			document.getElementById('drying_amt_s2').innerHTML = to_locale_string(drying_amt_s2);
		} else {
			document.getElementById('drying_amt_s2').innerHTML = "-";
		}

		add_drying_stotal_s2();
	}

	function compute_drying_emergency_labor_s2() {
		if (drying_emergency_labor_s2.value != "" && drying_emergency_labor_days_s2.value != "" && drying_emergency_labor_cost_s2.value != "") {
			console.log("No. of emergency labrorers S2: " + drying_emergency_labor_s2.value + "\n No. of days S2: " + drying_emergency_labor_days_s2.value + "\n Per day S2: " + drying_emergency_labor_cost_s2.value);

			drying_emergency_labor_amt_s2 = parseFloat((drying_emergency_labor_s2.value * drying_emergency_labor_days_s2.value) * drying_emergency_labor_cost_s2.value);
			document.getElementById('drying_emergency_labor_amt_s2').innerHTML = to_locale_string(drying_emergency_labor_amt_s2);
		} else {
			document.getElementById('drying_emergency_labor_amt_s2').innerHTML = "-";
		}

		add_drying_stotal_s2();
	}

	function add_drying_stotal_s2() {
		drying_stotal_s2 = parseFloat(drying_amt_s2 + drying_emergency_labor_amt_s2);
		console.log("Drying Sub Total S2: " + drying_stotal_s2);

		if (!isNaN(drying_stotal_s2)) {
			document.getElementById('drying_stotal_s2').innerHTML = to_locale_string(drying_stotal_s2);
			document.getElementById('drying_stotal_s2_summary').innerHTML = to_locale_string(drying_stotal_s2);
		}

		add_drying_total();
		add_total_prod_cost_s2();
	}

	function add_drying_total() {
		drying_total = parseFloat(drying_stotal_s1 + drying_stotal_s2);
		console.log("Drying total: " + drying_total);

		if (!isNaN(drying_total)) {
			document.getElementById('drying_total').innerHTML = to_locale_string(drying_total);
			document.getElementById('drying_total_summary').innerHTML = to_locale_string(drying_total);
		}
	}

	function compute_seed_clean_ave_bags_s1() {
		var bags = parseFloat((ave_bags_harvest_s1.value * 50) * ((100 - 21) / 88) / 20);
		console.log("Average 20-kg bags (clean seeds) per ha S1: " + bags);
		document.getElementById('seed_clean_ave_bags_s1').value = Math.round(bags);
		document.getElementById('seed_clean_ave_bags_s1').setAttribute('trueVal', bags);

		compute_seed_clean_qty_s1(bags);
		compute_lam_sacks();
		compute_clean_seeds_vol_rs();
		compute_clean_seeds_vol_fs();
	}

	function compute_seed_clean_qty_s1(bags) {
		var qty = parseFloat(bags * rot_area_s1.value);
		console.log("Quantity (bags) S1: " + qty);
		document.getElementById('seed_clean_qty_s1').value = Math.round(qty);
		document.getElementById('seed_clean_qty_s1').setAttribute('trueVal', bags);

		compute_seed_clean_cost_s1(qty);
		compute_lam_sacks(qty);
	}

	function compute_seed_clean_cost_s1(qty) {
		var cost = parseFloat((420 * 20 * 17) / qty);
		console.log("Unit Cost S1: " + cost);
		document.getElementById('seed_clean_cost_s1').value = cost.toFixed(2);
		document.getElementById('seed_clean_cost_s1').setAttribute('trueVal', cost);

		compute_seed_clean_amt_s1(qty, cost);
	}

	function compute_seed_clean_amt_s1(qty, cost) {
		seed_clean_amt_s1 = parseFloat(qty * cost);
		console.log("Seed Cleaning Amount S1: " + seed_clean_amt_s1);

		if (!isNaN(seed_clean_amt_s1)) {
			document.getElementById('seed_clean_amt_s1').innerHTML = to_locale_string(seed_clean_amt_s1);
			document.getElementById('seed_clean_amt_s1_summary').innerHTML = to_locale_string(seed_clean_amt_s1);
		}

		add_seed_clean_total();
		add_total_prod_cost_s1();
	}

	function compute_seed_clean_ave_bags_s2() {
		var bags = parseFloat((ave_bags_harvest_s2.value * 50) * ((100 - 25) / 88) / 20);
		console.log("Average 20-kg bags (clean seeds) per ha S2: " + bags);
		document.getElementById('seed_clean_ave_bags_s2').value = Math.round(bags);
		document.getElementById('seed_clean_ave_bags_s2').setAttribute('trueVal', bags);

		compute_seed_clean_qty_s2(bags);
		compute_lam_sacks();
		compute_clean_seeds_vol_rs();
		compute_clean_seeds_vol_fs();
	}

	function compute_seed_clean_qty_s2(bags) {
		var qty = parseFloat(bags * rot_area_s2.value);
		console.log("Quantity (bags) S2: " + qty);
		document.getElementById('seed_clean_qty_s2').value = Math.round(qty);
		document.getElementById('seed_clean_qty_s2').setAttribute('trueVal', qty);

		compute_seed_clean_cost_s2(qty);
		compute_lam_sacks(qty);
	}

	function compute_seed_clean_cost_s2(qty) {
		var cost = parseFloat((420 * 20 * 17) / qty);
		console.log("Unit Cost S2: " + cost);
		document.getElementById('seed_clean_cost_s2').value = cost.toFixed(2);
		document.getElementById('seed_clean_cost_s2').setAttribute('trueVal', cost);

		compute_seed_clean_amt_s2(qty, cost);
	}

	function compute_seed_clean_amt_s2(qty, cost) {
		seed_clean_amt_s2 = parseFloat(qty * cost);
		console.log("Seed Cleaning Amount S2: " + seed_clean_amt_s2);

		if (!isNaN(seed_clean_amt_s2)) {
			document.getElementById('seed_clean_amt_s2').innerHTML = to_locale_string(seed_clean_amt_s2);
			document.getElementById('seed_clean_amt_s2_summary').innerHTML = to_locale_string(seed_clean_amt_s2);
		}

		add_seed_clean_total();
		add_total_prod_cost_s2();
	}

	function add_seed_clean_total() {
		seed_clean_total = parseFloat(seed_clean_amt_s1 + seed_clean_amt_s2);
		console.log("Seed clean total: " + seed_clean_total);

		if (!isNaN(seed_clean_total)) {
			document.getElementById('seed_clean_total').innerHTML = to_locale_string(seed_clean_total);
			document.getElementById('seed_clean_total_summary').innerHTML = to_locale_string(seed_clean_total);
		}
	}

	function compute_sc_s1() {
		for (var i=1; i<=serv_con_row_count_s1; i++) {
			compute_serv_cont_(1, i);
		}
	}

	function add_monthly_cost_stotal_s1() {
		sc_monthly_cost_stotal_s1 = 0;

		for (var i=1; i<=serv_con_row_count_s1; i++) {
			sc_monthly_cost_stotal_s1 += remove_comma_to_amount(document.getElementById('serv_con_monthly_cost_s1_'+i).value);
		}

		console.log("SC monthly cost sub total S1: " + sc_monthly_cost_stotal_s1);

		if (!isNaN(sc_monthly_cost_stotal_s1)) {
			document.getElementById('sc_monthly_cost_stotal_s1').innerHTML = to_locale_string(sc_monthly_cost_stotal_s1);
		}
	}

	function add_sc_stotal_s1() {
		sc_stotal_s1 = 0;

		for (i=1; i<=serv_con_row_count_s1; i++) {
			var total = remove_comma_to_amount(document.getElementById('serv_con_total_s1_'+i).innerHTML);
			sc_stotal_s1 += total;
		}

		console.log("SC sub total S1: " + sc_stotal_s1);

		if (!isNaN(sc_stotal_s1)) {
			document.getElementById('sc_stotal_s1').innerHTML = to_locale_string(sc_stotal_s1);
			document.getElementById('sc_stotal_s1_summary').innerHTML = to_locale_string(sc_stotal_s1);
		}

		add_sc_total();
		add_total_prod_cost_s1();
	}

	function compute_sc_s2() {
		for (var i=1; i<=serv_con_row_count_s2; i++) {
			compute_serv_cont_(2, i);
		}
	}

	function add_monthly_cost_stotal_s2() {
		sc_monthly_cost_stotal_s2 = 0;

		for (var i=1; i<=serv_con_row_count_s2; i++) {
			sc_monthly_cost_stotal_s2 += remove_comma_to_amount(document.getElementById('serv_con_monthly_cost_s2_'+i).value);
		}

		console.log("SC monthly cost sub total S2: " + sc_monthly_cost_stotal_s2);

		if (!isNaN(sc_monthly_cost_stotal_s2)) {
			document.getElementById('sc_monthly_cost_stotal_s2').innerHTML = to_locale_string(sc_monthly_cost_stotal_s2);
		}
	}

	function add_sc_stotal_s2() {
		sc_stotal_s2 = 0;

		for (i=1; i<=serv_con_row_count_s2; i++) {
			var total = remove_comma_to_amount(document.getElementById('serv_con_total_s2_'+i).innerHTML);
			sc_stotal_s2 += total;
		}

		console.log("SC sub total S2: " + sc_stotal_s2);

		if (!isNaN(sc_stotal_s2)) {
			document.getElementById('sc_stotal_s2').innerHTML = to_locale_string(sc_stotal_s2);
			document.getElementById('sc_stotal_s2_summary').innerHTML = to_locale_string(sc_stotal_s2);
		}

		add_sc_total();
		add_total_prod_cost_s2();
	}

	function add_sc_total() {
		sc_total = parseFloat(sc_stotal_s1 + sc_stotal_s2);
		console.log("SC total: " + sc_total);

		if (!isNaN(sc_total)) {
			document.getElementById('sc_total').innerHTML = to_locale_string(sc_total);
			document.getElementById('sc_total_summary').innerHTML = to_locale_string(sc_total);
		}
	}

	function compute_seeds() {
		var rs_s1 = parseFloat(seeding_rate.value * rs_area_s1.value);
		var fs_s1 = parseFloat(seeding_rate.value * fs_area_s1.value);
		var rs_s2 = parseFloat(seeding_rate.value * rs_area_s2.value);
		var fs_s2 = parseFloat(seeding_rate.value * fs_area_s2.value);

		seeds_rs_s1.value = rs_s1;
		seeds_fs_s1.value = fs_s1;
		seeds_rs_s2.value = rs_s2;
		seeds_fs_s2.value = fs_s2;
	}

	function compute_seeds_rs_amt_s1() {
		if (seeds_rs_s1.value != "" && seeds_rs_cost_s1 != "") {
			console.log("Seeds (kg) S1: " + seeds_rs_s1.value + "\n Unit cost: " + seeds_rs_cost_s1.value);

			seeds_rs_amt_s1 = parseFloat(seeds_rs_s1.value * seeds_rs_cost_s1.value);

			document.getElementById('seeds_rs_amt_s1').innerHTML = to_locale_string(seeds_rs_amt_s1);
		} else {
			document.getElementById('seeds_rs_amt_s1').innerHTML = "-";
		}

		add_seeds_stotal_s1();
	}

	function compute_seeds_fs_amt_s1() {
		if (seeds_fs_s1.value != "" && seeds_fs_cost_s1 != "") {
			console.log("Seeds (kg) S1: " + seeds_fs_s1.value + "\n Unit cost: " + seeds_fs_cost_s1.value);

			seeds_fs_amt_s1 = parseFloat(seeds_fs_s1.value * seeds_fs_cost_s1.value);

			document.getElementById('seeds_fs_amt_s1').innerHTML = to_locale_string(seeds_fs_amt_s1);
		} else {
			document.getElementById('seeds_fs_amt_s1').innerHTML = "-";
		}

		add_seeds_stotal_s1();
	}

	function add_seeds_stotal_s1() {
		seeds_stotal_s1 = parseFloat(seeds_rs_amt_s1 + seeds_fs_amt_s1);
		console.log("Seeds Sub Total S1 Amount: " + seeds_stotal_s1);

		if (!isNaN(seeds_stotal_s1)) {
			document.getElementById('seeds_stotal_s1').innerHTML = to_locale_string(seeds_stotal_s1);
			document.getElementById('seeds_stotal_s1_summary').innerHTML = to_locale_string(seeds_stotal_s1);
		}

		add_seeds_total();
		add_total_prod_cost_s1();
	}

	function compute_seeds_rs_amt_s2() {
		if (seeds_rs_s2.value != "" && seeds_rs_cost_s2 != "") {
			console.log("Seeds (kg) S2: " + seeds_rs_s2.value + "\n Unit cost: " + seeds_rs_cost_s2.value);

			seeds_rs_amt_s2 = parseFloat(seeds_rs_s2.value * seeds_rs_cost_s2.value);

			document.getElementById('seeds_rs_amt_s2').innerHTML = to_locale_string(seeds_rs_amt_s2);
		} else {
			document.getElementById('seeds_rs_amt_s2').innerHTML = "-";
		}

		add_seeds_stotal_s2();
	}

	function compute_seeds_fs_amt_s2() {
		if (seeds_fs_s2.value != "" && seeds_fs_cost_s2 != "") {
			console.log("Seeds (kg) S2: " + seeds_fs_s2.value + "\n Unit cost: " + seeds_fs_cost_s2.value);

			seeds_fs_amt_s2 = parseFloat(seeds_fs_s2.value * seeds_fs_cost_s2.value);

			document.getElementById('seeds_fs_amt_s2').innerHTML = to_locale_string(seeds_fs_amt_s2);
		} else {
			document.getElementById('seeds_fs_amt_s2').innerHTML = "-";
		}

		add_seeds_stotal_s2();
	}

	function add_seeds_stotal_s2() {
		seeds_stotal_s2 = parseFloat(seeds_rs_amt_s2 + seeds_fs_amt_s2);
		console.log("Seeds Sub Total Amount S2: " + seeds_stotal_s2);

		if (!isNaN(seeds_stotal_s2)) {
			document.getElementById('seeds_stotal_s2').innerHTML = to_locale_string(seeds_stotal_s2);
			document.getElementById('seeds_stotal_s2_summary').innerHTML = to_locale_string(seeds_stotal_s2);
		}

		add_seeds_total();
		add_total_prod_cost_s2();
	}

	function add_seeds_total() {
		seeds_total = parseFloat(seeds_stotal_s1 + seeds_stotal_s2);
		console.log("Seeds Total Amount: " + seeds_total);

		if (!isNaN(seeds_total)) {
			document.getElementById('seeds_total').innerHTML = to_locale_string(seeds_total);
			document.getElementById('seeds_total_summary').innerHTML = to_locale_string(seeds_total);
		}
	}

	function compute_lam_sacks(qty) {
		if (seed_clean_ave_bags_s1.getAttribute('trueVal') && hauling_bags_s1.getAttribute('trueVal')) {
			var lam_sacks_20kg = parseFloat((rs_area_s1.value * parseFloat(seed_clean_ave_bags_s1.getAttribute('trueVal'))) * 1.15);
			var lam_sacks_10kg = parseFloat((fs_area_s1.value * parseFloat(seed_clean_ave_bags_s1.getAttribute('trueVal'))) * 1.15);
			var sacks_50kg = parseFloat(parseFloat(hauling_bags_s1.getAttribute('trueVal')) * 1.1);

			lam_sacks_20kg_s1.value = Math.round(lam_sacks_20kg);
			lam_sacks_10kg_s1.value = Math.round(lam_sacks_10kg);
			sacks_50kg_s1.value = Math.round(sacks_50kg);
		}

		if (seed_clean_ave_bags_s2.getAttribute('trueVal') && hauling_bags_s2.getAttribute('trueVal')) {
			var lam_sacks_20kg = parseFloat((rs_area_s2.value * parseFloat(seed_clean_ave_bags_s2.getAttribute('trueVal'))) * 1.15);
			var lam_sacks_10kg = parseFloat((fs_area_s2.value * parseFloat(seed_clean_ave_bags_s2.getAttribute('trueVal'))) * 1.15);
			var sacks_50kg = parseFloat(parseFloat(hauling_bags_s2.getAttribute('trueVal')) * 1.1);

			lam_sacks_20kg_s2.value = Math.round(lam_sacks_20kg);
			lam_sacks_10kg_s2.value = Math.round(lam_sacks_10kg);
			sacks_50kg_s2.value = Math.round(sacks_50kg);
		}
	}

	function compute_lam_sacks_20kg_amt_s1() {
		if (lam_sacks_20kg_s1.value != "" && lam_sacks_20kg_cost_s1 != "") {
			console.log("No. of sacks S1: " + lam_sacks_20kg_s1.value + "\n Cost per sack: " + lam_sacks_20kg_cost_s1.value);

			lam_sacks_20kg_amt_s1 = parseFloat(lam_sacks_20kg_s1.value * lam_sacks_20kg_cost_s1.value);

			document.getElementById('lam_sacks_20kg_amt_s1').innerHTML = to_locale_string(lam_sacks_20kg_amt_s1);
		} else {
			document.getElementById('lam_sacks_20kg_amt_s1').innerHTML = "-";
		}

		add_field_supp_stotal_s1();
	}

	function compute_lam_sacks_10kg_amt_s1() {
		if (lam_sacks_10kg_s1.value != "" && lam_sacks_10kg_cost_s1 != "") {
			console.log("No. of sacks S1: " + lam_sacks_10kg_s1.value + "\n Cost per sack: " + lam_sacks_10kg_cost_s1.value);

			lam_sacks_10kg_amt_s1 = parseFloat(lam_sacks_10kg_s1.value * lam_sacks_10kg_cost_s1.value);

			document.getElementById('lam_sacks_10kg_amt_s1').innerHTML = to_locale_string(lam_sacks_10kg_amt_s1);
		} else {
			document.getElementById('lam_sacks_10kg_amt_s1').innerHTML = "-";
		}

		add_field_supp_stotal_s1();
	}

	function compute_sacks_50kg_amt_s1() {
		if (sacks_50kg_s1.value != "" && sacks_50kg_cost_s1 != "") {
			console.log("No. of sacks S1: " + sacks_50kg_s1.value + "\n Cost per sack: " + sacks_50kg_cost_s1.value);

			sacks_50kg_amt_s1 = parseFloat(sacks_50kg_s1.value * sacks_50kg_cost_s1.value);

			document.getElementById('sacks_50kg_amt_s1').innerHTML = to_locale_string(sacks_50kg_amt_s1);
		} else {
			document.getElementById('sacks_50kg_amt_s1').innerHTML = "-";
		}

		add_field_supp_stotal_s1();
	}

	function add_field_supp_stotal_s1() {
		field_supp_stotal_s1 = parseFloat(lam_sacks_20kg_amt_s1 + lam_sacks_10kg_amt_s1 + sacks_50kg_amt_s1 + parseFloat(other_field_supp_s1.value));
		console.log("Field Supplies Sub Total S1: " + field_supp_stotal_s1);

		if (!isNaN(field_supp_stotal_s1)) {
			document.getElementById('field_supp_stotal_s1').innerHTML = to_locale_string(field_supp_stotal_s1);
			document.getElementById('field_supp_stotal_s1_summary').innerHTML = to_locale_string(field_supp_stotal_s1);
		}

		add_field_supp_total();
		add_total_prod_cost_s1();
	}

	function compute_lam_sacks_20kg_amt_s2() {
		if (lam_sacks_20kg_s2.value != "" && lam_sacks_20kg_cost_s2 != "") {
			console.log("No. of sacks S2: " + lam_sacks_20kg_s2.value + "\n Cost per sack: " + lam_sacks_20kg_cost_s2.value);

			lam_sacks_20kg_amt_s2 = parseFloat(lam_sacks_20kg_s2.value * lam_sacks_20kg_cost_s2.value);

			document.getElementById('lam_sacks_20kg_amt_s2').innerHTML = to_locale_string(lam_sacks_20kg_amt_s2);
		} else {
			document.getElementById('lam_sacks_20kg_amt_s2').innerHTML = "-";
		}

		add_field_supp_stotal_s2();
	}

	function compute_lam_sacks_10kg_amt_s2() {
		if (lam_sacks_10kg_s2.value != "" && lam_sacks_10kg_cost_s2 != "") {
			console.log("No. of sacks S2: " + lam_sacks_10kg_s2.value + "\n Cost per sack: " + lam_sacks_10kg_cost_s2.value);

			lam_sacks_10kg_amt_s2 = parseFloat(lam_sacks_10kg_s2.value * lam_sacks_10kg_cost_s2.value);

			document.getElementById('lam_sacks_10kg_amt_s2').innerHTML = to_locale_string(lam_sacks_10kg_amt_s2);
		} else {
			document.getElementById('lam_sacks_10kg_amt_s2').innerHTML = "-";
		}

		add_field_supp_stotal_s2();
	}

	function compute_sacks_50kg_amt_s2() {
		if (sacks_50kg_s2.value != "" && sacks_50kg_cost_s2 != "") {
			console.log("No. of sacks S2: " + sacks_50kg_s2.value + "\n Cost per sack: " + sacks_50kg_cost_s2.value);

			sacks_50kg_amt_s2 = parseFloat(sacks_50kg_s2.value * sacks_50kg_cost_s2.value);

			document.getElementById('sacks_50kg_amt_s2').innerHTML = to_locale_string(sacks_50kg_amt_s2);
		} else {
			document.getElementById('sacks_50kg_amt_s2').innerHTML = "-";
		}

		add_field_supp_stotal_s2();
	}

	function add_field_supp_stotal_s2() {
		field_supp_stotal_s2 = parseFloat(lam_sacks_20kg_amt_s2 + lam_sacks_10kg_amt_s2 + sacks_50kg_amt_s2 + parseFloat(other_field_supp_s2.value));
		console.log("Field Supplies Sub Total S2: " + field_supp_stotal_s2);

		if (!isNaN(field_supp_stotal_s2)) {
			document.getElementById('field_supp_stotal_s2').innerHTML = to_locale_string(field_supp_stotal_s2);
			document.getElementById('field_supp_stotal_s2_summary').innerHTML = to_locale_string(field_supp_stotal_s2);
		}

		add_field_supp_total();
		add_total_prod_cost_s2();
	}

	function add_field_supp_total() {
		field_supp_total = parseFloat(field_supp_stotal_s1 + field_supp_stotal_s2);
		console.log("Field Supplies Total: " + field_supp_total);

		if (!isNaN(field_supp_total)) {
			document.getElementById('field_supp_total').innerHTML = to_locale_string(field_supp_total);
			document.getElementById('field_supp_total_summary').innerHTML = to_locale_string(field_supp_total);
		}
	}

	function compute_diesel_amt_s1() {
		if (total_service_area_s1.value != "" && diesel_liters_ha_s1.value != "" && diesel_per_liter_s1.value != "") {
			console.log("Liters per ha S1: " + diesel_liters_ha_s1.value + "\n Cost per liter: " + diesel_per_liter_s1.value);

			diesel_amt_s1 = parseFloat((diesel_liters_ha_s1.value * diesel_per_liter_s1.value) * total_service_area_s1.value);

			document.getElementById('diesel_amt_s1').innerHTML = to_locale_string(diesel_amt_s1);
		} else {
			document.getElementById('diesel_amt_s1').innerHTML = "-";
		}

		add_fuel_stotal_s1();
	}

	function compute_gas_amt_s1() {
		if (total_service_area_s1.value != "" && gas_liters_ha_s1.value != "" && gas_per_liter_s1.value != "") {
			console.log("Liters per ha S1: " + gas_liters_ha_s1.value + "\n Cost per liter: " + gas_per_liter_s1.value);

			gas_amt_s1 = parseFloat((gas_liters_ha_s1.value * gas_per_liter_s1.value) * total_service_area_s1.value);

			document.getElementById('gas_amt_s1').innerHTML = to_locale_string(gas_amt_s1);
		} else {
			document.getElementById('gas_amt_s1').innerHTML = "-";
		}

		add_fuel_stotal_s1();
	}

	function compute_kerosene_amt_s1() {
		if (total_service_area_s1.value != "" && kerosene_liters_ha_s1.value != "" && kerosene_per_liter_s1.value != "") {
			console.log("Liters per ha S1: " + kerosene_liters_ha_s1.value + "\n Cost per liter: " + kerosene_per_liter_s1.value);

			kerosene_amt_s1 = parseFloat((kerosene_liters_ha_s1.value * kerosene_per_liter_s1.value) * total_service_area_s1.value);

			document.getElementById('kerosene_amt_s1').innerHTML = to_locale_string(kerosene_amt_s1);
		} else {
			document.getElementById('kerosene_amt_s1').innerHTML = "-";
		}

		add_fuel_stotal_s1();
	}

	function add_fuel_stotal_s1() {
		fuel_stotal_s1 = parseFloat(diesel_amt_s1 + gas_amt_s1 + kerosene_amt_s1);
		console.log("Fuel Sub Total S1: " + fuel_stotal_s1);

		if (!isNaN(fuel_stotal_s1)) {
			document.getElementById('fuel_stotal_s1').innerHTML = to_locale_string(fuel_stotal_s1);
			document.getElementById('fuel_stotal_s1_summary').innerHTML = to_locale_string(fuel_stotal_s1);
		}

		add_fuel_total();
		add_total_prod_cost_s1();
	}

	function compute_diesel_amt_s2() {
		if (total_service_area_s2.value != "" && diesel_liters_ha_s2.value != "" && diesel_per_liter_s2.value != "") {
			console.log("Liters per ha S2: " + diesel_liters_ha_s2.value + "\n Cost per liter: " + diesel_per_liter_s2.value);

			diesel_amt_s2 = parseFloat((diesel_liters_ha_s2.value * diesel_per_liter_s2.value) * total_service_area_s2.value);

			document.getElementById('diesel_amt_s2').innerHTML = to_locale_string(diesel_amt_s2);
		} else {
			document.getElementById('diesel_amt_s2').innerHTML = "-";
		}

		add_fuel_stotal_s2();
	}

	function compute_gas_amt_s2() {
		if (total_service_area_s2.value != "" && gas_liters_ha_s2.value != "" && gas_per_liter_s2.value != "") {
			console.log("Liters per ha S2: " + gas_liters_ha_s2.value + "\n Cost per liter: " + gas_per_liter_s2.value);

			gas_amt_s2 = parseFloat((gas_liters_ha_s2.value * gas_per_liter_s2.value) * total_service_area_s2.value);

			document.getElementById('gas_amt_s2').innerHTML = to_locale_string(gas_amt_s2);
		} else {
			document.getElementById('gas_amt_s2').innerHTML = "-";
		}

		add_fuel_stotal_s2();
	}

	function compute_kerosene_amt_s2() {
		if (total_service_area_s2.value != "" && kerosene_liters_ha_s2.value != "" && kerosene_per_liter_s2.value != "") {
			console.log("Liters per ha S2: " + kerosene_liters_ha_s2.value + "\n Cost per liter: " + kerosene_per_liter_s2.value);

			kerosene_amt_s2 = parseFloat((kerosene_liters_ha_s2.value * kerosene_per_liter_s2.value) * total_service_area_s2.value);

			document.getElementById('kerosene_amt_s2').innerHTML = to_locale_string(kerosene_amt_s2);
		} else {
			document.getElementById('kerosene_amt_s2').innerHTML = "-";
		}

		add_fuel_stotal_s2();
	}

	function add_fuel_stotal_s2() {
		fuel_stotal_s2 = parseFloat(diesel_amt_s2 + gas_amt_s2 + kerosene_amt_s2);
		console.log("Fuel Sub Total S2: " + fuel_stotal_s2);

		if (!isNaN(fuel_stotal_s2)) {
			document.getElementById('fuel_stotal_s2').innerHTML = to_locale_string(fuel_stotal_s2);
			document.getElementById('fuel_stotal_s2_summary').innerHTML = to_locale_string(fuel_stotal_s2);
		}

		add_fuel_total();
		add_total_prod_cost_s2();
	}

	function add_fuel_total() {
		fuel_total = parseFloat(fuel_stotal_s1 + fuel_stotal_s2);
		console.log("Fuel Total: " + fuel_total);

		if (!isNaN(fuel_total)) {
			document.getElementById('fuel_total').innerHTML = to_locale_string(fuel_total);
			document.getElementById('fuel_total_summary').innerHTML = to_locale_string(fuel_total);
		}
	}

	function compute_irrigation_amt_s1() {
		if (irrigation_area_s1.value != "" && irrigation_cost_s1.value != "") {
			console.log("Area S1: " + irrigation_area_s1.value + "\n Cost per ha: " + irrigation_cost_s1.value);

			irrigation_amt_s1 = parseFloat(irrigation_area_s1.value * irrigation_cost_s1.value);

			document.getElementById('irrigation_amt_s1').innerHTML = to_locale_string(irrigation_amt_s1);
			document.getElementById('irrigation_stotal_s1_summary').innerHTML = to_locale_string(irrigation_amt_s1);
		} else {
			document.getElementById('irrigation_amt_s1').innerHTML = "-";
		}

		add_irrigation_total();
		add_total_prod_cost_s1();
	}

	function compute_irrigation_amt_s2() {
		if (irrigation_area_s2.value != "" && irrigation_cost_s2.value != "") {
			console.log("Area S2: " + irrigation_area_s2.value + "\n Cost per ha: " + irrigation_cost_s2.value);

			irrigation_amt_s2 = parseFloat(irrigation_area_s2.value * irrigation_cost_s2.value);

			document.getElementById('irrigation_amt_s2').innerHTML = to_locale_string(irrigation_amt_s2);
			document.getElementById('irrigation_stotal_s2_summary').innerHTML = to_locale_string(irrigation_amt_s2);
		} else {
			document.getElementById('irrigation_amt_s2').innerHTML = "-";
		}

		add_irrigation_total();
		add_total_prod_cost_s2();
	}

	function add_irrigation_total() {
		irrigation_total = parseFloat(irrigation_amt_s1 + irrigation_amt_s2);
		console.log("Irrigation Total: " + irrigation_total);

		if (!isNaN(irrigation_total)) {
			document.getElementById('irrigation_total').innerHTML = to_locale_string(irrigation_total);
			document.getElementById('irrigation_total_summary').innerHTML = to_locale_string(irrigation_total);
		}
	}

	function add_seed_lab_fee_total() {
		if (seed_lab_fee_s1.value != "" && seed_lab_fee_s2.value != "") {
			seed_lab_fee_total = parseFloat(seed_lab_fee_s1.value) + parseFloat(seed_lab_fee_s2.value);

			document.getElementById('seed_lab_fee_total').innerHTML = to_locale_string(seed_lab_fee_total);
			document.getElementById('seed_lab_fee_s1_summary').innerHTML = to_locale_string((parseFloat(seed_lab_fee_s1.value) / 1));
			document.getElementById('seed_lab_fee_s2_summary').innerHTML = to_locale_string((parseFloat(seed_lab_fee_s2.value) /1));
			document.getElementById('seed_lab_fee_total_summary').innerHTML = to_locale_string(seed_lab_fee_total);
		} else {
			document.getElementById('seed_lab_fee_total').innerHTML = "-";
		}

		add_total_prod_cost_s1();
		add_total_prod_cost_s2();
	}

	function compute_land_rental_amt_s1() {
		if (land_rental_area_s1.value != "" && land_rental_cost_s1.value != "") {
			console.log("Area S1: " + land_rental_area_s1.value + "\n Cost per ha: " + land_rental_cost_s1.value);

			land_rental_amt_s1 = parseFloat(land_rental_area_s1.value * land_rental_cost_s1.value);

			document.getElementById('land_rental_amt_s1').innerHTML = to_locale_string(land_rental_amt_s1);
			document.getElementById('land_rental_amt_s1_summary').innerHTML = to_locale_string(land_rental_amt_s1);
		} else {
			document.getElementById('land_rental_amt_s1').innerHTML = "-";
		}

		add_land_rental_total();
		add_total_prod_cost_s1();
	}

	function compute_land_rental_amt_s2() {
		if (land_rental_area_s2.value != "" && land_rental_cost_s2.value != "") {
			console.log("Area S2: " + land_rental_area_s2.value + "\n Cost per ha: " + land_rental_cost_s2.value);

			land_rental_amt_s2 = parseFloat(land_rental_area_s2.value * land_rental_cost_s2.value);

			document.getElementById('land_rental_amt_s2').innerHTML = to_locale_string(land_rental_amt_s2);
			document.getElementById('land_rental_amt_s2_summary').innerHTML = to_locale_string(land_rental_amt_s2);
		} else {
			document.getElementById('land_rental_amt_s2').innerHTML = "-";
		}

		add_land_rental_total();
		add_total_prod_cost_s2();
	}

	function add_land_rental_total() {
		land_rental_total = parseFloat(land_rental_amt_s1 + land_rental_amt_s2);
		console.log("Land Rental Total: " + land_rental_total);

		if (!isNaN(land_rental_total)) {
			document.getElementById('land_rental_total').innerHTML = to_locale_string(land_rental_total);
			document.getElementById('land_rental_total_summary').innerHTML = to_locale_string(land_rental_total);
		}
	}

	function compute_seed_prod_cont_amt_s1() {
		if (seed_prod_cont_vol_s1.value != "" && seed_prod_cont_price_s1.value != "") {
			console.log("Area S1: " + seed_prod_cont_vol_s1.value + "\n Cost per ha: " + seed_prod_cont_price_s1.value);

			seed_prod_cont_amt_s1 = parseFloat(seed_prod_cont_vol_s1.value * seed_prod_cont_price_s1.value);

			document.getElementById('seed_prod_cont_amt_s1').innerHTML = to_locale_string(seed_prod_cont_amt_s1);
			document.getElementById('seed_prod_cont_amt_s1_summary').innerHTML = to_locale_string(seed_prod_cont_amt_s1);
		} else {
			document.getElementById('seed_prod_cont_amt_s1').innerHTML = "-";
		}

		add_seed_prod_cont_total();
		add_total_prod_cost_s1();
	}

	function compute_seed_prod_cont_amt_s2() {
		if (seed_prod_cont_vol_s2.value != "" && seed_prod_cont_price_s2.value != "") {
			console.log("Area S2: " + seed_prod_cont_vol_s2.value + "\n Cost per ha: " + seed_prod_cont_price_s2.value);

			seed_prod_cont_amt_s2 = parseFloat(seed_prod_cont_vol_s2.value * seed_prod_cont_price_s2.value);

			document.getElementById('seed_prod_cont_amt_s2').innerHTML = to_locale_string(seed_prod_cont_amt_s2);
			document.getElementById('seed_prod_cont_amt_s2_summary').innerHTML = to_locale_string(seed_prod_cont_amt_s2);
		} else {
			document.getElementById('seed_prod_cont_amt_s2').innerHTML = "-";
		}

		add_seed_prod_cont_total();
		add_total_prod_cost_s2();
	}

	function add_seed_prod_cont_total() {
		seed_prod_cont_total = parseFloat(seed_prod_cont_amt_s1 + seed_prod_cont_amt_s2);
		console.log("Seed Production Contracting Total: " + seed_prod_cont_total);

		if (!isNaN(seed_prod_cont_total)) {
			document.getElementById('seed_prod_cont_total').innerHTML = to_locale_string(seed_prod_cont_total);
			document.getElementById('seed_prod_cont_total_summary').innerHTML = to_locale_string(seed_prod_cont_total);
		}
	}

	function add_total_prod_cost_s1() {
		total_prod_cost_s1 = parseFloat(remove_comma_to_amount(land_prep_stotal_s1_summary.innerHTML) + remove_comma_to_amount(seed_pulling_stotal_s1_summary.innerHTML) + remove_comma_to_amount(fertilizer_amt_s1_summary.innerHTML) + remove_comma_to_amount(harvest_stotal_s1_summary.innerHTML) + remove_comma_to_amount(drying_stotal_s1_summary.innerHTML) + remove_comma_to_amount(seed_clean_amt_s1_summary.innerHTML) + remove_comma_to_amount(sc_stotal_s1_summary.innerHTML) + remove_comma_to_amount(seeds_stotal_s1_summary.innerHTML) + remove_comma_to_amount(field_supp_stotal_s1_summary.innerHTML) + remove_comma_to_amount(fuel_stotal_s1_summary.innerHTML) + remove_comma_to_amount(irrigation_stotal_s1_summary.innerHTML) + remove_comma_to_amount(seed_lab_fee_s1_summary.innerHTML) + remove_comma_to_amount(land_rental_amt_s1_summary.innerHTML) + remove_comma_to_amount(seed_prod_cont_amt_s1_summary.innerHTML));
		console.log("Total Production Cost S1: " + total_prod_cost_s1);

		if (!isNaN(total_prod_cost_s1)) {
			document.getElementById('total_prod_cost_s1').innerHTML = to_locale_string(total_prod_cost_s1);
		}

		add_total_prod_cost();
		compute_clean_seeds_vol_rs();
		compute_clean_seeds_vol_fs();
	}

	function add_total_prod_cost_s2() {
		total_prod_cost_s2 = parseFloat(remove_comma_to_amount(land_prep_stotal_s2_summary.innerHTML) + remove_comma_to_amount(seed_pulling_stotal_s2_summary.innerHTML) + remove_comma_to_amount(fertilizer_amt_s2_summary.innerHTML) + remove_comma_to_amount(harvest_stotal_s2_summary.innerHTML) + remove_comma_to_amount(drying_stotal_s2_summary.innerHTML) + remove_comma_to_amount(seed_clean_amt_s2_summary.innerHTML) + remove_comma_to_amount(sc_stotal_s2_summary.innerHTML) + remove_comma_to_amount(seeds_stotal_s2_summary.innerHTML) + remove_comma_to_amount(field_supp_stotal_s2_summary.innerHTML) + remove_comma_to_amount(fuel_stotal_s2_summary.innerHTML) + remove_comma_to_amount(irrigation_stotal_s2_summary.innerHTML) + remove_comma_to_amount(seed_lab_fee_s2_summary.innerHTML) + remove_comma_to_amount(land_rental_amt_s2_summary.innerHTML) + remove_comma_to_amount(seed_prod_cont_amt_s2_summary.innerHTML));
		console.log("Total Production Cost S2: " + total_prod_cost_s2);

		if (!isNaN(total_prod_cost_s2)) {
			document.getElementById('total_prod_cost_s2').innerHTML = to_locale_string(total_prod_cost_s2);
		}

		add_total_prod_cost();
		compute_clean_seeds_vol_rs();
		compute_clean_seeds_vol_fs();
	}

	function add_total_prod_cost() {
		total_prod_cost = parseFloat(total_prod_cost_s1 + total_prod_cost_s2);
		console.log("Total Production Cost: " + total_prod_cost);

		if (!isNaN(total_prod_cost)) {
			document.getElementById('total_prod_cost').innerHTML = to_locale_string(total_prod_cost);
		}
	}

	function compute_clean_seeds_vol_rs() {
		var clean_seeds_s1 = parseFloat((remove_comma_to_amount(seed_clean_ave_bags_s1.getAttribute('trueVal')) * 20) * remove_comma_to_amount("{{$area_rs_s1}}"));
		var clean_seeds_s2 = parseFloat((remove_comma_to_amount(seed_clean_ave_bags_s2.getAttribute('trueVal')) * 20) * remove_comma_to_amount("{{$area_rs_s2}}"));

		if (!isNaN(clean_seeds_s1)) {
			document.getElementById('clean_seeds_vol_rs_s1').innerHTML = to_locale_string(clean_seeds_s1);
		}

		if (!isNaN(clean_seeds_s2)) {
			document.getElementById('clean_seeds_vol_rs_s2').innerHTML = to_locale_string(clean_seeds_s2);
		}

		add_total_clean_seeds_prod();
	}

	function compute_clean_seeds_vol_fs() {
		var clean_seeds_s1 = parseFloat((remove_comma_to_amount(seed_clean_ave_bags_s1.getAttribute('trueVal')) * 20) * remove_comma_to_amount("{{$area_fs_s1}}"));
		var clean_seeds_s2 = parseFloat((remove_comma_to_amount(seed_clean_ave_bags_s2.getAttribute('trueVal')) * 20) * remove_comma_to_amount("{{$area_fs_s2}}"));

		if (!isNaN(clean_seeds_s1)) {
			document.getElementById('clean_seeds_vol_fs_s1').innerHTML = to_locale_string(clean_seeds_s1);
		}

		if (!isNaN(clean_seeds_s2)) {
			document.getElementById('clean_seeds_vol_fs_s2').innerHTML = to_locale_string(clean_seeds_s2);
		}

		add_total_clean_seeds_prod();
	}

	function add_total_clean_seeds_prod() {
		var total_clean_seeds_prod_s1 = parseFloat(remove_comma_to_amount(document.getElementById('clean_seeds_vol_rs_s1').innerHTML) + remove_comma_to_amount(document.getElementById('clean_seeds_vol_fs_s1').innerHTML));
		var total_clean_seeds_prod_s2 = parseFloat(remove_comma_to_amount(document.getElementById('clean_seeds_vol_rs_s2').innerHTML) + remove_comma_to_amount(document.getElementById('clean_seeds_vol_fs_s2').innerHTML));

		if (!isNaN(total_clean_seeds_prod_s1)) {
			document.getElementById('total_clean_seeds_prod_s1').innerHTML = to_locale_string(total_clean_seeds_prod_s1);
		}

		if (!isNaN(total_clean_seeds_prod_s2)) {
			document.getElementById('total_clean_seeds_prod_s2').innerHTML = to_locale_string(total_clean_seeds_prod_s2);
		}

		compute_prod_cost_kilo();
		compute_prod_cost_ha();
	}

	function compute_prod_cost_kilo() {
		var prod_cost_kilo_s1 = parseFloat(remove_comma_to_amount(document.getElementById('total_prod_cost_s1').innerHTML) / remove_comma_to_amount(document.getElementById('total_clean_seeds_prod_s1').innerHTML));
		var prod_cost_kilo_s2 = parseFloat(remove_comma_to_amount(document.getElementById('total_prod_cost_s2').innerHTML) / remove_comma_to_amount(document.getElementById('total_clean_seeds_prod_s2').innerHTML));

		if (!isNaN(prod_cost_kilo_s1)) {
			document.getElementById('prod_cost_kilo_s1').innerHTML = to_locale_string(prod_cost_kilo_s1);
		}

		if (!isNaN(prod_cost_kilo_s2)) {
			document.getElementById('prod_cost_kilo_s2').innerHTML = to_locale_string(prod_cost_kilo_s2);
		}
	}

	function compute_prod_cost_ha() {
		var prod_cost_ha_s1 = parseFloat(remove_comma_to_amount(document.getElementById('total_prod_cost_s1').innerHTML) / (remove_comma_to_amount("{{$area_rs_s1}}") + remove_comma_to_amount("{{$area_fs_s1}}")));
		var prod_cost_ha_s2 = parseFloat(remove_comma_to_amount(document.getElementById('total_prod_cost_s2').innerHTML) / (remove_comma_to_amount("{{$area_rs_s2}}") + remove_comma_to_amount("{{$area_fs_s2}}")));

		if (!isNaN(prod_cost_ha_s1)) {
			document.getElementById('prod_cost_ha_s1').innerHTML = to_locale_string(prod_cost_ha_s1);
		}

		if (!isNaN(prod_cost_ha_s2)) {
			document.getElementById('prod_cost_ha_s2').innerHTML = to_locale_string(prod_cost_ha_s2);
		}
	}

	function remove_comma_to_amount(value) {
		if (value != null) {
			return parseFloat(value.replace(/,/g, ''));
		}
	}

	function to_locale_string(value) {
		return value.toLocaleString('en-US', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
			roundingIncrement: 5
		});
	}

	function onlyNumKey(evt) {
		var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		if (ASCIICode != 46 && ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) {
			return false;
		}
		return true;
	}

	// add new row to service contractors
	function add_serv_con_row(sem) {
		// reference table row
		var row_count = (sem == 1) ? serv_con_row_count_s1 : serv_con_row_count_s2;
		var ref_tr = document.getElementById('serv_cont_s'+sem+'_'+row_count);
		row_count++;

		// new row
		var new_tr = document.createElement('tr');
		new_tr.id = 'serv_cont_s'+sem+'_'+row_count; // set id for table row
		new_tr.classList.add('service_contractors');
		new_tr.innerHTML = `
			<td class="text-right"><input type="text" class="form-control" id="serv_cont_count_s`+sem+`_`+row_count+`" value="0" style="text-align: right;" onkeypress="return onlyNumKey(event)" onpaste="return false;" oninput="compute_serv_cont_(`+sem+`, `+row_count+`)"></td>
			<td>
				<div class="input-group">
					<span class="input-group-addon">no. of</span>
					<input type="text" class="form-control" id="serv_con_name_s`+sem+`_`+row_count+`" onpaste="return false;" placeholder="Enter service contract position (ex.: Laborer II - Passed QS & PS)">
				</div>
			</td>
			<td><input type="text" class="form-control" id="serv_con_rate_s`+sem+`_`+row_count+`" value="0" style="text-align: right;" onkeypress="return onlyNumKey(event)" onpaste="return false;" oninput="compute_serv_cont_(`+sem+`, `+row_count+`)"></td>
			<td><input type="text" class="form-control" id="serv_con_monthly_cost_s`+sem+`_`+row_count+`" value="0" style="text-align: right;" readonly></td>
			<td class="text-right"><h4 id="serv_con_total_s`+sem+`_`+row_count+`"></h4></td>
		`;
		ref_tr.parentNode.insertBefore(new_tr, ref_tr.nextSibling);

		if (sem == 1) {
			serv_con_row_count_s1++;

			if (row_count > 1)
				rem_serv_con_button_s1.style.display = "inline";
		}
		else { 
			serv_con_row_count_s2++;

			if (row_count > 1)
				rem_serv_con_button_s2.style.display = "inline";
		}
	}

	// remove row to service contractors
	function rem_serv_con_row(sem) {
		var row_count = (sem == 1) ? serv_con_row_count_s1 : serv_con_row_count_s2;
		var table_row = document.getElementById('serv_cont_s'+sem+'_'+row_count);
		table_row.remove();

		row_count--;

		if (sem == 1) {
			serv_con_row_count_s1--;

			if (row_count == 1)
				rem_serv_con_button_s1.style.display = "none";
		}
		else {
			serv_con_row_count_s2--;

			if (row_count == 1)
				rem_serv_con_button_s2.style.display = "none";
		}

		// run compute function
		compute_sc_s1();
		compute_sc_s2();
	}

	// computes service contract rate
	function compute_serv_cont_(sem, id) {
		var service_contract_no = document.getElementById('serv_cont_count_s'+sem+'_'+id);
		var service_contract_rate = document.getElementById('serv_con_rate_s'+sem+'_'+id);
		var service_contract_monthly = document.getElementById('serv_con_monthly_cost_s'+sem+'_'+id);
		var service_contract_total = document.getElementById('serv_con_total_s'+sem+'_'+id);
		var months_hired = (sem == 1) ? months_hired_s1.value : months_hired_s2.value;

		if (months_hired != "" && service_contract_no.value != "" && service_contract_rate.value != "") {
			var monthly_cost = parseFloat(service_contract_no.value * service_contract_rate.value);
			service_contract_monthly.value = monthly_cost;

			var total = parseFloat(months_hired * monthly_cost);
			service_contract_total.innerHTML = to_locale_string(total);
		} else {
			service_contract_monthly.value = 0;
			service_contract_total.innerHTML = "-";
		}

		if (sem == 1) {
			add_monthly_cost_stotal_s1();
			add_sc_stotal_s1();
		} else {
			add_monthly_cost_stotal_s2();
			add_sc_stotal_s2();
		}
	}
</script>