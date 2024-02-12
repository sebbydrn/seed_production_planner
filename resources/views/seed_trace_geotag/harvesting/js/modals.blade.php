<script>
	let harvestingFormMap

	(function( $ ) {
		'use strict';

		/*
		Modal Dismiss
		*/
		$(document).on('click', '.modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
		});
	}).apply( this , [ jQuery ])

	function viewFormInfo(harvestingID) {
		// Form info
		$.ajax({
			type: 'GET',
			url: `{{url('seed_trace_geotag/harvesting')}}/`+harvestingID,
			dataType: 'JSON',
			success: (res) => {
				// Add details to table
				document.getElementById('productionPlotCode').innerHTML = res.production_plot_code
				document.getElementById('harvestingMethod').innerHTML = res.harvesting_method
				document.getElementById('datetime').innerHTML = new Date(res.timestamp)
				document.getElementById('bagsNo').innerHTML = res.bags_no
				document.getElementById('remarks').innerHTML = res.remarks

				// Generate map
				document.getElementById('harvestingFormMapContainer').innerHTML = '<div id="harvestingFormMap" style="height: 400px;"></div>'
				
				if (res.location_point) {
					createPlotDetailsMap(res.location_point)
				}

				// Open info modal
				$.magnificPopup.open({
					items: {
						src: '#modalViewForm'
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
				harvestingFormMap.invalidateSize()
			}
		})
	}

	function createPlotDetailsMap(coordinates) {
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
		harvestingFormMap = L.map('harvestingFormMap')
		harvestingFormMap.addLayer(GoogleMapsHybrid)

		let point = coordinates.split(",")
		let marker = new L.marker(L.latLng(parseFloat(point[0]), parseFloat(point[1]))).addTo(harvestingFormMap)

		// Set map view
		harvestingFormMap.setView(L.latLng(parseFloat(point[0]), parseFloat(point[1])), 18)
	}

</script>