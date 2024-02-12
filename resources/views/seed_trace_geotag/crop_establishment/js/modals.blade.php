<script>
	let cropEstablishmentFormMap

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

	function viewFormInfo(cropEstablishmentID) {
		// Form info
		$.ajax({
			type: 'GET',
			url: `{{url('seed_trace_geotag/crop_establishment')}}/`+cropEstablishmentID,
			dataType: 'JSON',
			success: (res) => {
				// Add details to table
				document.getElementById('productionPlotCode').innerHTML = res.production_plot_code
				document.getElementById('activity').innerHTML = res.activity
				if (res.activity == "Transplanting") {
					document.getElementById('transplantingMethod').innerHTML = res.transplanting_method
				}
				document.getElementById('datetimeStart').innerHTML = new Date(res.datetime_start)
				document.getElementById('datetimeEnd').innerHTML = new Date(res.datetime_end)
				document.getElementById('laborCost').innerHTML = res.labor_cost
				document.getElementById('workersNo').innerHTML = res.workers_no
				document.getElementById('remarks').innerHTML = res.remarks

				// Generate map
				document.getElementById('cropEstablishmentFormMapContainer').innerHTML = '<div id="cropEstablishmentFormMap" style="height: 400px;"></div>'
				
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
				cropEstablishmentFormMap.invalidateSize()
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
		cropEstablishmentFormMap = L.map('cropEstablishmentFormMap')
		cropEstablishmentFormMap.addLayer(GoogleMapsHybrid)

		let point = coordinates.split(",")
		let marker = new L.marker(L.latLng(parseFloat(point[0]), parseFloat(point[1]))).addTo(cropEstablishmentFormMap)

		// Set map view
		cropEstablishmentFormMap.setView(L.latLng(parseFloat(point[0]), parseFloat(point[1])), 18)
	}

</script>