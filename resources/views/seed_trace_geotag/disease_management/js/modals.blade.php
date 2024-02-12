<script>
	let diseaseManagementFormMap

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

	function viewFormInfo(diseaseManagementID) {
		// Form info
		$.ajax({
			type: 'GET',
			url: `{{url('seed_trace_geotag/disease_management')}}/`+diseaseManagementID,
			dataType: 'JSON',
			success: (res) => {
				// Add details to table
				document.getElementById('productionPlotCode').innerHTML = res.production_plot_code
				document.getElementById('cropPhase').innerHTML = res.crop_phase
				if (res.disease_type == "Others") {
					document.getElementById('diseaseType').innerHTML = res.disease_type
				} else {
					document.getElementById('diseaseType').innerHTML = res.other_disease
				}
				document.getElementById('controlType').innerHTML = res.control_type
				if (res.control_type == "Chemical") {
					document.getElementById('chemicalUsed').innerHTML = res.chemical_used
					document.getElementById('activeIngredient').innerHTML = res.active_ingredient
					document.getElementById('applicationMode').innerHTML = res.application_mode
					document.getElementById('brandName').innerHTML = res.brand_name
					document.getElementById('formulation').innerHTML = res.formulation
					document.getElementById('unit').innerHTML = res.unit
					if (res.formulation == "Liquid") {
						document.getElementById('tankLoadNo').innerHTML = res.tank_load_no
						document.getElementById('tankLoadVolume').innerHTML = res.tank_load_volume
						document.getElementById('tankLoadRate').innerHTML = res.tank_load_rate
					} else {
						document.getElementById('totalChemicalUsed').innerHTML = res.total_chemical_used
					}
				} else {
					document.getElementById('controlSpec').innerHTML = res.control_spec
				}
				document.getElementById('datetimeStart').innerHTML = new Date(res.datetime_start)
				document.getElementById('datetimeEnd').innerHTML = new Date(res.datetime_end)
				document.getElementById('remarks').innerHTML = res.remarks

				// Generate map
				document.getElementById('diseaseManagementFormMapContainer').innerHTML = '<div id="diseaseManagementFormMap" style="height: 400px;"></div>'
				
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
				diseaseManagementFormMap.invalidateSize()
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
		diseaseManagementFormMap = L.map('diseaseManagementFormMap')
		diseaseManagementFormMap.addLayer(GoogleMapsHybrid)

		let point = coordinates.split(",")
		let marker = new L.marker(L.latLng(parseFloat(point[0]), parseFloat(point[1]))).addTo(diseaseManagementFormMap)

		// Set map view
		diseaseManagementFormMap.setView(L.latLng(parseFloat(point[0]), parseFloat(point[1])), 18)
	}

</script>