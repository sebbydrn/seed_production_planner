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

		// Drone map tile layer
		// let wmsLayer = L.tileLayer.wms('https://staging.philrice.gov.ph:8443/geoserver/RSIS/wms', {
		//     layers: 'DroneRSISCES_2ndSem',
		//     format : 'image/png',
		//     transparent : true,
		//     maxZoom: 20,
		//     zIndex: 1000
		// });

		// Create map
		plotMap = L.map('plotMap', {
			layers: [GoogleMapsHybrid]
		})

		// Plots LayerGroup
		layerGroup = L.layerGroup().addTo(plotMap)

		// Set View
		switch ({{$philriceStationID}}) {
			case 4:
				// CES
				plotMap.setView([15.6711339, 120.8910602], 16)
				// wmsLayer.addTo(plotMap)
				break;
			case 8:
				// Midsayap
				plotMap.setView([7.180432, 124.492798], 16)
				break;
			case 9:
				// LB
				plotMap.setView([14.1604417, 121.2456013], 16)
				break;
			case 10:
				// Agusan
				plotMap.setView([9.0653577, 125.5833771], 16)
				break;
			case 11:
				// Batac
				plotMap.setView([18.0572043, 120.5421341], 16)
				break;
			case 12:
				// Isabela
				plotMap.setView([16.8758864, 121.5935317], 16)
				break;
			case 13:
				// Negros
				plotMap.setView([10.5650808, 122.9924843], 16)
				break;
			case 14:
				// Bicol
				plotMap.setView([13.2503128, 123.5675003], 16)
				break;
			case 15:
				// CMU
				plotMap.setView([7.8481625, 125.0482655], 16)
				break;
			case 16:
				// Zamboanga
				// CES
				plotMap.setView([15.6711339, 120.8910602], 16)
				break;
			case 17:
				// Samar
				// CES
				plotMap.setView([15.6711339, 120.8910602], 16)
				break;
			case 18:
				// Mindoro
				// CES
				plotMap.setView([15.6711339, 120.8910602], 16)
				break;
			default:
				// Zoom out to view all PH, this is for users that has permission to view all stations' dashboard
				plotMap.setView([12.413680, 122.597985], 6)
				break;
		}
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
					})

					// Set total area value
					document.getElementById('plotsTotalArea').value = parseFloat(res.totalArea)

					// Calculate seed quantity
					let seedQuantity = 40 * parseFloat(res.totalArea)
					seedQuantity = Math.round(seedQuantity / 20)
					seedQuantity = seedQuantity * 20
					document.getElementById('seedQuantity').value = seedQuantity

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
</script>