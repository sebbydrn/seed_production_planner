<script>
	var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	var map;

	function show_seed_prod_ax() {
		let station = document.getElementById('station').value;
		let year = document.getElementById('year').value;
		let semInput = document.getElementsByName('sem');
		let sem;
		Array.from(semInput).map(currElement => {
			if (currElement.checked) {
				sem = currElement.value;
			}
		});

		if (station && year && sem) {
			HoldOn.open(holdonOptions);

			$.ajax({
				type: 'POST',
				url: "{{route('seed_production_activities.show_activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'stationID': station,
					'year': year,
					'sem': sem
				},
				dataType: 'JSON',
				success: (res) => {
					console.log(res);

					var table = document.getElementById('seed_production_activities');
					var tbody = document.getElementById('tbody_activities');

					tbody.innerHTML = "";

					if (Object.keys(res).length > 0) {
						for (var [key, value] of Object.entries(res)) {
							var activities = value;
							var date = new Date(key);

							x = 1;

							var rows = activities.length;

							for (var i=0; i<rows; i++) {
								// add row
								var tr = tbody.insertRow(0);

								if (activities[i]['is_actual'] == 1) {
									var is_actual = `<button class="btn btn-success btn-xs active">Actual</button>`;
								} else {
									var is_actual = `<button class="btn btn-primary btn-xs active">Planned</button>`;
								}

								var button = `<button class="btn btn-primary btn-xs" onclick="view_map(`+activities[i]['production_plan_id']+`)">View map</button>`;

								if (i == rows-1) {
									var td0 = tr.insertCell(0);
									var date_content = `<div class="dayofmonth">`+date.getDate()+`</div><div class="dayofweek">`+days[date.getDay()]+`</div><div class="shortdate text-muted">`+months[date.getMonth()]+`, `+date.getFullYear()+`</div>`;
									td0.innerHTML = date_content;

									if (rows > 1) {
										td0.rowSpan = rows;
									}

									var td1 = tr.insertCell(1);
									td1.innerHTML = activities[i]['variety'];
									td1.style.textAlign = "center";

									var td2 = tr.insertCell(2);
									td2.innerHTML = activities[i]['seed_class'];
									td2.style.textAlign = "center";

									var td3 = tr.insertCell(3);
									td3.innerHTML = activities[i]['activity'];
									td3.style.textAlign = "center";
									td3.style.width = "30%";

									var td4 = tr.insertCell(4);
									td4.innerHTML = is_actual;
									td4.style.textAlign = "center";

									var td5 = tr.insertCell(5);
									td5.innerHTML = activities[i]['station'];
									td5.style.textAlign = "center";

									var td6 = tr.insertCell(6);
									td6.innerHTML = button;
									td6.style.textAlign = "center";
								} else {
									var td0 = tr.insertCell(0);
									td0.innerHTML = activities[i]['variety'];
									td0.style.textAlign = "center";

									var td1 = tr.insertCell(1);
									td1.innerHTML = activities[i]['seed_class'];
									td1.style.textAlign = "center";

									var td2 = tr.insertCell(2);
									td2.innerHTML = activities[i]['activity'];
									td2.style.textAlign = "center";
									td2.style.width = "30%";

									var td3 = tr.insertCell(3);
									td3.innerHTML = is_actual;
									td3.style.textAlign = "center";

									var td4 = tr.insertCell(4);
									td4.innerHTML = activities[i]['station'];
									td4.style.textAlign = "center";

									var td5 = tr.insertCell(5);
									td5.innerHTML = button;
									td5.style.textAlign = "center";
								}

							}
						}

						table.style.display = "table";
					} else {
						table.style.display = "none";
						alert('No data');
					}

					HoldOn.close();
				}
			});
		}
	}

	// dismiss modal
	$(document).on('click', '.modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});

	function view_map(production_plan_id) {
		HoldOn.open(holdonOptions)

		// plots
		$.ajax({
			type: 'POST',
			url: "{{route('production_plans.view_plan_plots')}}",
			data: {
				_token: "{{csrf_token()}}",
				productionPlanID: production_plan_id
			},
			dataType: 'JSON',
			success: (res) => {
				console.log(res);
				// Generate map
				document.getElementById('map_container').innerHTML = `<div id="map" style="height: 600px;"></div>`;
				create_map(res);

				// Open info modal
				$.magnificPopup.open({
					items: {
						src: '#modal_view_map'
					},
					type: 'inline',
					mainClass: 'mfp-with-zoom',
					zoom: {
						enable: true,
						duration: 300,
						easing: 'ease-in-out'
					}
				});

				// Re-adjust the width and height of bounds of L.Map container
				map.invalidateSize();

				HoldOn.close();
			}
		})
	}

	function create_map(data) {
		// Google Maps Hybrid map tile layer
		let GoogleMapsHybrid = L.tileLayer('http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga',{
		    attribution: 'Tiles &copy; Google',
		    maxZoom: 20,
		    subdomains:['mt0','mt1','mt2','mt3']
		})

		// Drone map tile layer
		// let wmsLayer = L.tileLayer.wms('https://staging.philrice.gov.ph:8443/geoserver/RSIS/wms', {
		//     layers: 'DroneRSISCES_2ndSem',
		//     format : 'image/png',
		//     transparent : true,
		//     maxZoom: 20,
		//     zIndex: 1000
		// });

		// Create map
		map = L.map('map')
		map.addLayer(GoogleMapsHybrid)

		data.forEach(function(item, index) {
		    let polygon = new Array()
		    let coordinates = item.coordinates
			coordinates = coordinates.split(";")
			console.log(coordinates)
			for (let i=0; i<coordinates.length; i++) {
				let point = coordinates[i].split(",")
				polygon.push(L.latLng(parseFloat(point[0]), parseFloat(point[1])))
			}

			var plot = L.polygon(polygon, {
				color: '#E1E100'
			}).addTo(map)

			// Get polygon center point
			let center = plot.getBounds().getCenter()

			// Set map view
			map.setView(center, 18)
		})
	}
</script>