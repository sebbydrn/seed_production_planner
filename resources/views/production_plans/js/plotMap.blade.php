<script>
	let plotMap
	let layerGroup

	$(document).ready(function() {
		// Google Maps Hybrid map tile layer
		let GoogleMapsHybrid = L.tileLayer('http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga',{
		    attribution: 'Tiles &copy; Google',
		    maxZoom: 20,
		    subdomains:['mt0','mt1','mt2','mt3']
		})

		var drone_map_name = $('#drone_map_name').val();
		var drone_map_link = $('#drone_map_link').val();
		
		// Create map
		plotMap = L.map('plotMap', {
			layers: [GoogleMapsHybrid]
		})

		// Plots LayerGroup
		layerGroup = L.layerGroup().addTo(plotMap)

		if (! drone_map_name == "" && ! drone_map_link == "") {
			// Drone map tile layer
			let wmsLayer = L.tileLayer.wms(drone_map_link, {
				layers: drone_map_name,
				format : 'image/png',
				transparent : true,
				maxZoom: 20,
				zIndex: 1000
			});

			// add to map
			wmsLayer.addTo(plotMap)
		}

		plotMap.setView([15.6711339, 120.8910602], 13);
	})

	function showPlotsOnMap() {
		let plotIDs = $('#plots').val()

		// Clear polygons in LayerGroup
		if (layerGroup) {
			layerGroup.clearLayers()
		}

		if (plotIDs && plotIDs.length > 0) {
			// Get coordinates and area of plots
			$.ajax({
				type: 'POST',
				url: "{{route('production_plans.plots')}}",
				data: {
					_token: "{{csrf_token()}}",
					plotIDs: plotIDs
				},
				dataType: 'JSON',
				success: (res) => {
					let plots = res.plots

					plots.forEach((plot) => {
						let coordinates
						let coordinatesArray = []
						coordinates = plot.coordinates
						coordinates = coordinates.split(';')

						for (let i=0; i<coordinates.length; i++) {
							let latLng = coordinates[i].split(',')
							coordinatesArray.push(L.latLng(parseFloat(latLng[0]), parseFloat(latLng[1])))
						}

						let polygon = L.polygon(coordinatesArray, {
							color: '#E1E100'
						})
						layerGroup.addLayer(polygon)
						let center = polygon.getBounds().getCenter()

						plotMap.setView(center, 18)

						let plotDetails = '<table class="table table-bordered table-striped">'
						plotDetails += '<tr><td style="width: 40%;">Plot Name:</td>'
						plotDetails += '<td><strong>'+plot.name+'</strong></td></tr>'
						plotDetails += '<tr><td>Area:</td>'
						plotDetails += '<td><strong>'+parseFloat(plot.area)+' ha</strong></td></tr>'
						plotDetails += '</table>'

						polygon.bindPopup(plotDetails)

						// Set total area value
						document.getElementById('plotsTotalArea').value = parseFloat(res.totalArea)

						calculate_seed_quantity();
					})
				}
			})
		}
	}

	// Show plots on map in view production plan page
	function showPlots(productionPlanID) {
		let plotIDs = []
		@if(isset($plots))
			@foreach($plots as $plot)
				plotIDs.push({{$plot->plot_id}})
			@endforeach
		@endif

		$.ajax({
			type: 'POST',
			url: "{{route('production_plans.plots')}}",
			data: {
				_token: "{{csrf_token()}}",
				plotIDs: plotIDs
			},
			dataType: 'JSON',
			success: (res) => {
				let plots = res.plots

				plots.forEach((plot) => {
					let coordinates
					let coordinatesArray = []
					coordinates = plot.coordinates
					coordinates = coordinates.split(';')

					for (let i=0; i<coordinates.length; i++) {
						let latLng = coordinates[i].split(',')
						coordinatesArray.push(L.latLng(parseFloat(latLng[0]), parseFloat(latLng[1])))
					}

					let polygon = L.polygon(coordinatesArray, {
						color: '#E1E100'
					})
					layerGroup.addLayer(polygon)
					let center = polygon.getBounds().getCenter()

					plotMap.setView(center, 18)

					let plotDetails = '<table class="table table-bordered table-striped">'
					plotDetails += '<tr><td style="width: 40%;">Plot Name:</td>'
					plotDetails += '<td><strong>'+plot.name+'</strong></td></tr>'
					plotDetails += '<tr><td>Area:</td>'
					plotDetails += '<td><strong>'+parseFloat(plot.area)+' ha</strong></td></tr>'
					plotDetails += '</table>'

					polygon.bindPopup(plotDetails)
				})
			}
		})
	}

	// calculate seed quantity to be used
	function calculate_seed_quantity() {
		var seed_class_planted = document.getElementById('seedClass').value;
		var area = document.getElementById('plotsTotalArea').value;

		// Calculate seed quantity
		// change to 20 kg if bs-fs, fs-rs and 40 kg if rs-cs
		// update if nucleus seeding rate was updated
		var seeding_rate = 0;
		
		if (seed_class_planted == "Breeder" || seed_class_planted == "Foundation") {
			seeding_rate = 20;
		} else if (seed_class_planted == "Registered") {
			seeding_rate = 40;
		}

		var seedQuantity = seeding_rate * parseFloat(area);
		// seedQuantity = Math.round(seedQuantity / 20)
		// seedQuantity = seedQuantity * 20
		
		document.getElementById('seedQuantity').value = seedQuantity
	}
</script>