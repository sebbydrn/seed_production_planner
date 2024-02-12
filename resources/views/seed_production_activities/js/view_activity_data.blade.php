<script>
	var route;
	var data;
	var modal;
	var data_table;

	(function( $ ) {
		'use strict';

		/*
		Modal Dismiss
		*/
		$(document).on('click', '.modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
		});
	}).apply( this , [ jQuery ]);

	function show_activity_data(name, id) {
		HoldOn.open(holdonOptions);

		switch (name) {
			case "Land Preparation":
				// get land preparation activity data inputs
				route = "{{route('field_activity.land_preparation', ':land_preparation_id')}}"; // add placeholder for id
				route = route.replace(':land_preparation_id', id); // replace placeholder with id value
				
				$.get(route, (res) => { // run function getting the data inputs for the activity
					data = JSON.parse(res);

					console.log(data);

					modal = document.querySelector('#land_preparation_modal');

					// set values in modal
					modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

					var activity_date = new Date(data.datetime_start);
					var date_collected = new Date(data.date_collected);
					var date_received = new Date(data.date_received);

					data_table = modal.querySelector('#land_preparation_table');
					data_table.querySelector('#production_plot_code').innerHTML = data.production_plot_code;
					data_table.querySelector('#activity_date').innerHTML = activity_date.toDateString();
					data_table.querySelector('#cropping_phase').innerHTML = data.crop_phase;
					data_table.querySelector('#activity').innerHTML = data.activity;
					data_table.querySelector('#labor_cost').innerHTML = data.labor_cost;
					data_table.querySelector('#workers_no').innerHTML = data.workers_no;
					data_table.querySelector('#remarks').innerHTML = data.remarks;
					data_table.querySelector('#date_collected').innerHTML = date_collected.toDateString();
					data_table.querySelector('#date_received').innerHTML = date_received.toDateString();

					// show modal based on activity
					show_modal("#land_preparation_modal");
				});

				HoldOn.close();

				break;
			case "Seedling Management":
				// get seedling management activity data inputs
				route = "{{route('field_activity.seedling_management', ':seedling_management_id')}}"; // add placeholder for id
				route = route.replace(':seedling_management_id', id); // replace placeholder with id value

				$.get(route, (res) => {
					data = JSON.parse(res);

					console.log(data);

					modal = document.querySelector('#seedling_management_modal');

					// set values in modal
					modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

					var activity_date = new Date(data.timestamp);
					var date_collected = new Date(data.date_collected);
					var date_received = new Date(data.date_received);

					data_table = modal.querySelector('#seedling_management_table');
					data_table.querySelector('#production_plot_code').innerHTML = data.production_plot_code;
					data_table.querySelector('#activity_date').innerHTML = activity_date.toDateString();
					data_table.querySelector('#activity').innerHTML = data.activity;
					data_table.querySelector('#seed_source').innerHTML = data.seed_certification.seed_source;
					data_table.querySelector('#seedbed_area').innerHTML = data.seed_certification.seedbed_area;
					data_table.querySelector('#seedlot_no').innerHTML = data.seed_certification.seedlot_no;
					data_table.querySelector('#control_no').innerHTML = data.seed_certification.control_no;

					data_table.querySelector('#seed_quantity').innerHTML = data.seed_quantity;
					data_table.querySelector('#remarks').innerHTML = data.remarks;
					data_table.querySelector('#date_collected').innerHTML = date_collected.toDateString();
					data_table.querySelector('#date_received').innerHTML = date_received.toDateString();

					// show modal based on activity
					show_modal("#seedling_management_modal");

					HoldOn.close();
				});

				break;
			case "Crop Establishment":
				// get crop establisment activity data inputs
				route = "{{route('field_activity.crop_establishment', ':crop_establishment_id')}}"; // add placeholder for id
				route = route.replace(':crop_establishment_id', id); // replace placeholder with id value

				$.get(route, (res) => {
					data = JSON.parse(res);

					console.log(data);

					modal = document.querySelector('#crop_establishment_modal');

					// set values in modal
					modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

					var activity_date = new Date(data.datetime_start);
					var date_collected = new Date(data.date_collected);
					var date_received = new Date(data.date_received);

					data_table = modal.querySelector('#crop_establishment_table');
					data_table.querySelector('#production_plot_code').innerHTML = data.production_plot_code;
					data_table.querySelector('#activity_date').innerHTML = activity_date.toDateString();
					data_table.querySelector('#activity').innerHTML = data.activity;
					data_table.querySelector('#workers_no').innerHTML = data.workers_no;
					data_table.querySelector('#labor_cost').innerHTML = data.labor_cost;
					data_table.querySelector('#transplanting_method').innerHTML = data.transplanting_method;

					if (data.activity == "Transplanting") { // only show these data when activity is transplanting
						data_table.querySelector('#previous_variety').innerHTML = data.previous_variety;
					}

					data_table.querySelector('#remarks').innerHTML = data.remarks;
					data_table.querySelector('#date_collected').innerHTML = date_collected.toDateString();
					data_table.querySelector('#date_received').innerHTML = date_received.toDateString();

					// show modal based on activity
					show_modal("#crop_establishment_modal");

					HoldOn.close();
				});

				break;
			case "Water Management":
				// get water management activity data inputs
				route = "{{route('field_activity.water_management', ':water_management_id')}}"; // add placeholder for id
				route = route.replace(':water_management_id', id); // replace placeholder with id value

				$.get(route, (res) => {
					data = JSON.parse(res);

					console.log(data);

					modal = document.querySelector('#water_management_modal');

					// set values in modal
					modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

					var activity_date = new Date(data.datetime_start);
					var date_collected = new Date(data.date_collected);
					var date_received = new Date(data.date_received);

					data_table = modal.querySelector('#water_management_table');
					data_table.querySelector('#production_plot_code').innerHTML = data.production_plot_code;
					data_table.querySelector('#activity_date').innerHTML = activity_date.toDateString();
					data_table.querySelector('#activity').innerHTML = data.activity;
					data_table.querySelector('#crop_phase').innerHTML = data.crop_phase;
					data_table.querySelector('#crop_stage').innerHTML = data.crop_stage;
					data_table.querySelector('#workers_no').innerHTML = data.workers_no;
					data_table.querySelector('#labor_cost').innerHTML = data.labor_cost;
					data_table.querySelector('#remarks').innerHTML = data.remarks;
					data_table.querySelector('#date_collected').innerHTML = date_collected.toDateString();
					data_table.querySelector('#date_received').innerHTML = date_received.toDateString();

					// show modal based on activity
					show_modal("#water_management_modal");

					HoldOn.close();
				});

				break;
			case "Nutrient Management":
				// get nutrient management activity data inputs
				route = "{{route('field_activity.nutrient_management', ':nutrient_management_id')}}"; // add placeholder for id
				route = route.replace(':nutrient_management_id', id); // replace placeholder with id value

				$.get(route, (res) => {
					data = JSON.parse(res);

					console.log(data);

					modal = document.querySelector('#nutrient_management_modal');

					// set values in modal
					modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

					var activity_date = new Date(data.datetime_start);
					var date_collected = new Date(data.date_collected);
					var date_received = new Date(data.date_received);

					data_table = modal.querySelector('#nutrient_management_table');
					data_table.querySelector('#production_plot_code').innerHTML = data.production_plot_code;
					data_table.querySelector('#activity_date').innerHTML = activity_date.toDateString();
					data_table.querySelector('#crop_phase').innerHTML = data.crop_phase;
					data_table.querySelector('#technology_used').innerHTML = data.technology_used;

					if (!data.fertilizer_used == null || !data.fertilizer_used == "")
						data_table.querySelector('#fertilizer_used').innerHTML = data.fertilizer_used;
					else
						data_table.querySelector('#fertilizer_used').innerHTML = data.other_fertilizer;

					data_table.querySelector('#formulation').innerHTML = data.formulation;
					data_table.querySelector('#unit').innerHTML = data.unit;
					data_table.querySelector('#fertilizer_cost').innerHTML = data.fertilizer_cost;
					data_table.querySelector('#labor_cost').innerHTML = data.labor_cost;
					data_table.querySelector('#remarks').innerHTML = data.remarks;
					data_table.querySelector('#is_water_available').innerHTML = data.is_water_available;
					data_table.querySelector('#date_collected').innerHTML = date_collected.toDateString();
					data_table.querySelector('#date_received').innerHTML = date_received.toDateString();

					// show modal based on activity
					show_modal("#nutrient_management_modal");

					HoldOn.close();
				});

				break;
			case "Roguing":
				// get roguing activity data inputs
				route = "{{route('field_activity.roguing', ':roguing_id')}}"; // add placeholder for id
				route = route.replace(':roguing_id', id); // replace placeholder with id value

				$.get(route, (res) => {
					data = JSON.parse(res);

					console.log(data);

					modal = document.querySelector('#roguing_modal');

					// set values in modal
					modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

					var roguing_date = new Date(data.timestamp);
					var date_collected = new Date(data.date_collected);
					var date_received = new Date(data.date_received);

					data_table = modal.querySelector('#roguing_table');
					data_table.querySelector('#production_plot_code').innerHTML = data.production_plot_code;
					data_table.querySelector('#roguing_date').innerHTML = roguing_date.toDateString();
					data_table.querySelector('#crop_phase').innerHTML = data.crop_phase;
					data_table.querySelector('#offtypes_removed_count').innerHTML = data.offtypes_removed_count;

					if (!data.offtypes == null || !data.offtypes == "" || !data.offtypes.length == 0) {
						// add code here to populate offtypes kind
					}

					data_table.querySelector('#laborers').innerHTML = data.laborers;
					data_table.querySelector('#remarks').innerHTML = data.remarks;
					data_table.querySelector('#date_collected').innerHTML = date_collected.toDateString();
					data_table.querySelector('#date_received').innerHTML = date_received.toDateString();

					// show modal based on activity
					show_modal("#roguing_modal");

					HoldOn.close();
				});

				break;
			case "Pest Management":
				// get pest management activity data inputs
				route = "{{route('field_activity.pest_management', ':pest_management_id')}}"; // add placeholder for id
				route = route.replace(':pest_management_id', id); // replace placeholder with id value

				$.get(route, (res) => {
					data = JSON.parse(res);

					console.log(data);

					modal = document.querySelector('#pest_management_modal');

					// set values in modal
					modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

					var activity_date = new Date(data.datetime_start);
					var date_collected = new Date(data.date_collected);
					var date_received = new Date(data.date_received);

					data_table = modal.querySelector('#pest_management_table');
					data_table.querySelector('#production_plot_code').innerHTML = data.production_plot_code;
					data_table.querySelector('#activity_date').innerHTML = activity_date.toDateString();
					data_table.querySelector('#crop_phase').innerHTML = data.crop_phase;
					data_table.querySelector('#pest_type').innerHTML = data.pest_type;
					data_table.querySelector('#pest_spec').innerHTML = data.pest_spec;
					data_table.querySelector('#control_type').innerHTML = data.control_type;
					data_table.querySelector('#control_spec').innerHTML = data.control_spec;
					data_table.querySelector('#chemical_used').innerHTML = data.chemical_used;
					data_table.querySelector('#active_ingredient').innerHTML = data.active_ingredient;
					data_table.querySelector('#application_mode').innerHTML = data.application_mode;
					data_table.querySelector('#brand_name').innerHTML = data.brand_name;
					data_table.querySelector('#unit').innerHTML = data.unit;
					data_table.querySelector('#total_chemical_used').innerHTML = data.total_chemical_used;
					data_table.querySelector('#tank_load_no').innerHTML = data.tank_load_no;
					data_table.querySelector('#tank_load_volume').innerHTML = data.tank_load_volume;
					data_table.querySelector('#tank_load_rate').innerHTML = data.tank_load_rate;
					data_table.querySelector('#workers_no').innerHTML = data.workers_no;
					data_table.querySelector('#labor_cost').innerHTML = data.labor_cost;
					data_table.querySelector('#remarks').innerHTML = data.remarks;
					data_table.querySelector('#date_collected').innerHTML = date_collected.toDateString();
					data_table.querySelector('#date_received').innerHTML = date_received.toDateString();

					// show modal based on activity
					show_modal("#pest_management_modal");

					HoldOn.close();
				});

				break;
			case "Harvesting":
				// get harvesting activity data inputs
				route = "{{route('field_activity.harvesting', ':harvesting_id')}}"; // add placeholder for id
				route = route.replace(':harvesting_id', id); // replace placeholder with id value

				$.get(route, (res) => {
					data = JSON.parse(res);

					console.log(data);

					modal = document.querySelector('#harvesting_modal');

					// set values in modal
					modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

					var harvesting_date = new Date(data.timestamp);
					var date_collected = new Date(data.date_collected);
					var date_received = new Date(data.date_received);

					data_table = modal.querySelector('#harvesting_table');
					data_table.querySelector('#production_plot_code').innerHTML = data.production_plot_code;
					data_table.querySelector('#harvesting_date').innerHTML = harvesting_date.toDateString();
					data_table.querySelector('#harvesting_method').innerHTML = data.harvesting_method;
					data_table.querySelector('#bags_no').innerHTML = data.bags_no;
					data_table.querySelector('#harvested_area').innerHTML = data.harvested_area;
					data_table.querySelector('#remarks').innerHTML = data.remarks;
					data_table.querySelector('#date_collected').innerHTML = date_collected.toDateString();
					data_table.querySelector('#date_received').innerHTML = date_received.toDateString();

					// show modal based on activity
					show_modal("#harvesting_modal");

					HoldOn.close();
				});

				break;
			default:
				// statements_def
				alert('No data');
				HoldOn.close();
				break;
		}
	}

	function show_activity_map(name, id) {
		HoldOn.open(holdonOptions);

		route = "{{route('field_activity.map', [':activity_name', ':activity_id'])}}"; // add placeholder for activity name and id
		route = route.replace(':activity_name', name); // replace placeholder with name value
		route = route.replace(':activity_id', id); // replace placeholder with id value

		$.get(route, (res) => {
			data = JSON.parse(res);

			console.log(data);

			modal = document.querySelector('#field_map_modal');

			// set values in modal
			modal.querySelector('#production_plot_code').innerHTML = data.production_plot_code;

			if (!data.location_point == null || !data.location_point == '') {
				// replace existing map container inside the modal
				modal.querySelector('.modal-wrapper').innerHTML = '<div id="field_map" style="height: 400px;"></div>';

				// Google Maps Hybrid map tile layer
				var GoogleMapsHybrid = L.tileLayer('http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga',{
				    attribution: 'Tiles &copy; Google',
				    maxZoom: 20,
				    subdomains:['mt0','mt1','mt2','mt3']
				})

				// Create map
				var field_map = L.map('field_map')
				field_map.addLayer(GoogleMapsHybrid)

				var location_point = (data.location_point).split(", ");

				// set coordinates as view in map
				field_map.setView([location_point[0], location_point[1]], 18);

				// set point in map
				L.marker([location_point[0], location_point[1]]).addTo(field_map);

				// show field map modal
				show_modal("#field_map_modal");

				// Re-adjust the width and height of bounds of L.Map container
				field_map.invalidateSize()
			} else {
				alert('No data');
			}

			HoldOn.close();
		});
	}

	function show_modal(name) {
		// Open info modal
		$.magnificPopup.open({
			items: {
				src: name
			},
			type: 'inline',
			mainClass: 'mfp-with-zoom',
			zoom: {
				enable: true,
				duration: 300,
				easing: 'ease-in-out'
			}
		});
	}
</script>