<script>
	let roguingFormMap

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

	function viewFormInfo(roguingID) {
		// Form info
		$.ajax({
			type: 'GET',
			url: `{{url('seed_trace_geotag/roguing')}}/`+roguingID,
			dataType: 'JSON',
			success: (res) => {
				let offtype = res.offtype
				let offtypes = ""
				console.log(offtype)
				offtype.forEach(function(item, index) {
					if (offtypes == "") {
						offtypes += item.offtype_kind
					} else {
						offtypes += ", " + item.offtype_kind
					}
				})



				// Add details to table
				document.getElementById('productionPlotCode').innerHTML = res.roguing.production_plot_code
				document.getElementById('cropPhase').innerHTML = res.roguing.crop_phase
				document.getElementById('offtypesRemoved').innerHTML = res.roguing.offtypes_removed_count
				document.getElementById('offtypes').innerHTML = offtypes
				document.getElementById('remarks').innerHTML = res.roguing.remarks
				document.getElementById('laborers').innerHTML = res.roguing.laborers
				document.getElementById('datetime').innerHTML = new Date(res.roguing.timestamp)

				// Generate map
				document.getElementById('roguingFormMapContainer').innerHTML = '<div id="roguingFormMap" style="height: 400px;"></div>'
				
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
				roguingFormMap.invalidateSize()
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
		roguingFormMap = L.map('roguingFormMap')
		roguingFormMap.addLayer(GoogleMapsHybrid)

		let point = coordinates.split(",")
		let marker = new L.marker(L.latLng(parseFloat(point[0]), parseFloat(point[1]))).addTo(roguingFormMap)

		// Set map view
		roguingFormMap.setView(L.latLng(parseFloat(point[0]), parseFloat(point[1])), 18)
	}

</script>