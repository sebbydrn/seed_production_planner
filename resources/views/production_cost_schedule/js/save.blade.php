<script>
	function save_changes_prod_cost_sched() {
		swal({
		  	title: "Save Changes",
		  	text: "Do you want to save the changes made in this production cost schedule?",
		  	icon: "warning",
		  	buttons: {
		  		cancel: "No",
		  		confirm: "Yes, Proceed",
		  	},

		})
		.then((submit) => {
		  	if (submit) {
		  		HoldOn.open(holdonOptions);

		  		// make service contracts into an array
		  		// sem 1
		  		var service_contracts_s1 = [];

		  		for (var i=1; i<=serv_con_row_count_s1; i++) {
		  			service_contracts_s1[i] = {
		  				position: document.getElementById('serv_con_name_s1_'+i).value,
		  				count: document.getElementById('serv_cont_count_s1_'+i).value,
		  				rate: document.getElementById('serv_con_rate_s1_'+i).value
		  			};
		  		}

		  		// sem 2
		  		var service_contracts_s2 = [];

		  		for (var i=1; i<=serv_con_row_count_s2; i++) {
		  			service_contracts_s2[i] = {
		  				position: document.getElementById('serv_con_name_s2_'+i).value,
		  				count: document.getElementById('serv_cont_count_s2_'+i).value,
		  				rate: document.getElementById('serv_con_rate_s2_'+i).value
		  			};
		  		}
		  		
		  		$.ajax({
		  			type: 'PATCH',
		  			url: "{{route('production_cost_schedule.update', ['id' => $id])}}",
		  			data: {
		  				_token: "{{csrf_token()}}",
		  				philrice_station_id: "{{$philrice_station_id}}",
		  				year: "{{$year}}",
		  				roto_cost_s1: rot_cost_s1.value,
		  				level_cost_s1: levelling_cost_s1.value,
		  				roto_cost_s2: rot_cost_s2.value,
		  				level_cost_s2: levelling_cost_s2.value,
		  				seed_pull_area_s1: seed_pulling_area_s1.value,
		  				seed_pull_cost_s1: seed_pulling_cost_s1.value,
		  				emergency_labor_s1: emergency_labor_count_s1.value,
		  				emergency_labor_area_s1: emergency_labor_area_s1.value,
		  				emergency_labor_cost_s1: emergency_labor_cost_s1.value,
		  				seed_pull_area_s2: seed_pulling_area_s2.value,
		  				seed_pull_cost_s2: seed_pulling_cost_s2.value,
		  				emergency_labor_s2: emergency_labor_count_s2.value,
		  				emergency_labor_area_s2: emergency_labor_area_s2.value,
		  				emergency_labor_cost_s2: emergency_labor_cost_s2.value,
		  				fertilizer_area_s1: fertilizer_area_s1.value,
		  				fertilizer_cost_s1: fertilizer_cost_s1.value,
		  				fertilizer_area_s2: fertilizer_area_s2.value,
		  				fertilizer_cost_s2: fertilizer_cost_s2.value,
		  				manual_area_s1: manual_harvest_area_s1.value,
		  				manual_cost_s1: manual_harvest_cost_s1.value,
		  				mech_area_s1: mech_harvest_area_s1.value,
		  				mech_cost_s1: mech_harvest_cost_s1.value,
		  				ave_bags_s1: ave_bags_harvest_s1.value,
		  				cost_bag_s1: hauling_cost_s1.value,
		  				threshing_cost_s1: threshing_cost_s1.value,
		  				towing_cost_s1: towing_cost_s1.value,
		  				hay_scatter_cost_s1: hay_scatter_cost_s1.value,
		  				manual_area_s2: manual_harvest_area_s2.value,
		  				manual_cost_s2: manual_harvest_cost_s2.value,
		  				mech_area_s2: mech_harvest_area_s2.value,
		  				mech_cost_s2: mech_harvest_cost_s2.value,
		  				ave_bags_s2: ave_bags_harvest_s2.value,
		  				cost_bag_s2: hauling_cost_s2.value,
		  				threshing_cost_s2: threshing_cost_s2.value,
		  				towing_cost_s2: towing_cost_s2.value,
		  				hay_scatter_cost_s2: hay_scatter_cost_s2.value,
		  				drying_bags_s1: drying_bags_s1.value,
		  				bag_cost_s1: drying_cost_s1.value,
		  				emergency_laborers_s1: drying_emergency_labor_s1.value,
		  				labor_days_s1: drying_emergency_labor_days_s1.value,
		  				labor_cost_s1: drying_emergency_labor_cost_s1.value,
		  				drying_bags_s2: drying_bags_s2.value,
		  				bag_cost_s2: drying_cost_s2.value,
		  				emergency_laborers_s2: drying_emergency_labor_s2.value,
		  				labor_days_s2: drying_emergency_labor_days_s2.value,
		  				labor_cost_s2: drying_emergency_labor_cost_s2.value,
		  				months_hired_s1: months_hired_s1.value,
		  				service_contracts_s1: service_contracts_s1,
		  				months_hired_s2: months_hired_s2.value,
		  				service_contracts_s2: service_contracts_s2,
		  				seeding_rate: seeding_rate.value,
		  				rs_cost_s1: seeds_rs_cost_s1.value,
		  				fs_cost_s1: seeds_fs_cost_s1.value,
		  				rs_cost_s2: seeds_rs_cost_s2.value,
		  				fs_cost_s2: seeds_fs_cost_s2.value,
		  				sack_cost_20kg_s1: lam_sacks_20kg_cost_s1.value,
		  				sack_cost_10kg_s1: lam_sacks_10kg_cost_s1.value,
		  				sack_cost_50kg_s1: sacks_50kg_cost_s1.value,
		  				other_field_supp_s1: other_field_supp_s1.value,
		  				sack_cost_20kg_s2: lam_sacks_20kg_cost_s2.value,
		  				sack_cost_10kg_s2: lam_sacks_10kg_cost_s2.value,
		  				sack_cost_50kg_s2: sacks_50kg_cost_s2.value,
		  				other_field_supp_s2: other_field_supp_s2.value,
		  				diesel_liters_s1: diesel_liters_ha_s1.value,
		  				diesel_cost_s1: diesel_per_liter_s1.value,
		  				gas_liters_s1: gas_liters_ha_s1.value,
		  				gas_cost_s1: gas_per_liter_s1.value,
		  				kerosene_liters_s1: kerosene_liters_ha_s1.value,
		  				kerosene_cost_s1: kerosene_per_liter_s1.value,
		  				diesel_liters_s2: diesel_liters_ha_s2.value,
		  				diesel_cost_s2: diesel_per_liter_s2.value,
		  				gas_liters_s2: gas_liters_ha_s2.value,
		  				gas_cost_s2: gas_per_liter_s2.value,
		  				kerosene_liters_s2: kerosene_liters_ha_s2.value,
		  				kerosene_cost_s2: kerosene_per_liter_s2.value,
		  				irrig_cost_s1: irrigation_cost_s1.value,
		  				irrig_cost_s2: irrigation_cost_s2.value,
		  				seed_lab_amt_s1: seed_lab_fee_s1.value,
		  				seed_lab_amt_s2: seed_lab_fee_s2.value,
		  				land_rental_area_s1: land_rental_area_s1.value,
		  				land_rental_cost_s1: land_rental_cost_s1.value,
		  				land_rental_area_s2: land_rental_area_s2.value,
		  				land_rental_cost_s2: land_rental_cost_s2.value,
		  				seed_volume_s1: seed_prod_cont_vol_s1.value,
		  				buying_price_s1: seed_prod_cont_price_s1.value,
		  				seed_volume_s2: seed_prod_cont_vol_s2.value,
		  				buying_price_s2: seed_prod_cont_price_s2.value,
		  				prod_cost_stotal_s1: total_prod_cost_s1,
		  				prod_cost_stotal_s2: total_prod_cost_s2,
		  			},
		  			dataType: 'JSON',
		  			success: (res) => {
		  				if (res == "success") {
		  					swal("Success! Production cost schedule was updated.", {
					      		icon: "success",
					   		}).then((result) => {
					   			// redirect to production cost schedule table page
					   			window.location.href = "{{route('production_cost_schedule.index')}}";
					   		});
		  				} else {
		  					swal("An error has been encountered.", {
		  						icon: "error",
		  					});
		  				}
		  			}
		  		});
		  	} else {
		  		swal("Action was cancelled");
		  	}
		});
	}
</script>