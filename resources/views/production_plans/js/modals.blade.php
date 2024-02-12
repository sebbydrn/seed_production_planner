<script>
	
	let plotDetailsMap

	/*
	Modal Dismiss
	*/
	$(document).on('click', '.modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});

	function viewPlots(productionPlanID) {
		HoldOn.open(holdonOptions)

		// Plot info
		$.ajax({
			type: 'POST',
			url: "{{route('production_plans.view_plan_plots')}}",
			data: {
				_token: "{{csrf_token()}}",
				productionPlanID: productionPlanID
			},
			dataType: 'JSON',
			success: (res) => {
				console.log(res)

				// Generate map
				document.getElementById('plotDetailsMapContainer').innerHTML = '<div id="plotDetailsMap" style="height: 400px;"></div>'
				createPlotDetailsMap(res)

				// Open info modal
				$.magnificPopup.open({
					items: {
						src: '#modalViewPlots'
					},
					type: 'inline',
					mainClass: 'mfp-with-zoom',
					zoom: {
						enable: true,
						duration: 300,
						easing: 'ease-in-out'
					}
				})

				// Re-adjust the width and height of bounds of L.Map container
				plotDetailsMap.invalidateSize()

				HoldOn.close()
			}
		})
	}

	function createPlotDetailsMap(data) {
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
		plotDetailsMap = L.map('plotDetailsMap')
		plotDetailsMap.addLayer(GoogleMapsHybrid)

		data.forEach(function(item, index) {
		    let polygon = new Array()
		    let coordinates = item.coordinates
			coordinates = coordinates.split(";")
			console.log(coordinates)
			for (let i=0; i<coordinates.length; i++) {
				let point = coordinates[i].split(",")
				polygon.push(L.latLng(parseFloat(point[0]), parseFloat(point[1])))
			}

			let plot = L.polygon(polygon, {
				color: '#E1E100'
			}).addTo(plotDetailsMap)

			// Get polygon center point
			let center = plot.getBounds().getCenter()

			// Set map view
			plotDetailsMap.setView(center, 16)
		})
		
	}


</script>