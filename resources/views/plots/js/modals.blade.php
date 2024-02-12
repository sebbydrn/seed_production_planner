<script>
	let plotDetailsMap

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

	function viewPlotInfo(plotID) {
		HoldOn.open(holdonOptions)

		// Plot info
		$.ajax({
			type: 'GET',
			url: `{{url('plots')}}/`+plotID,
			dataType: 'JSON',
			success: (res) => {
				console.log(res)

				// Add details to table
				document.getElementById('plotName').innerHTML = res.name
				document.getElementById('plotArea').innerHTML = res.area + " ha"

				// Generate map
				document.getElementById('plotDetailsMapContainer').innerHTML = '<div id="plotDetailsMap" style="height: 400px;"></div>'
				createPlotDetailsMap(res.coordinates)

				// Open info modal
				$.magnificPopup.open({
					items: {
						src: '#modalViewPlot'
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
		plotDetailsMap = L.map('plotDetailsMap')
		plotDetailsMap.addLayer(GoogleMapsHybrid)

		// Set View
		// switch ({{$philriceStationID}}) {
		// 	case 4:
		// 		// CES
		// 		plotDetailsMap.setView([15.6711339, 120.8910602], 15)
		// 		// wmsLayer.addTo(plotDetailsMap)
		// 		break;
		// 	case 8:
		// 		// Midsayap
		// 		plotDetailsMap.setView([7.180432, 124.492798], 15)
		// 		break;
		// 	case 9:
		// 		// LB
		// 		plotDetailsMap.setView([14.1604417, 121.2456013], 15)
		// 		break;
		// 	case 10:
		// 		// Agusan
		// 		plotDetailsMap.setView([9.0653577, 125.5833771], 15)
		// 		break;
		// 	case 11:
		// 		// Batac
		// 		plotDetailsMap.setView([18.0572043, 120.5421341], 15)
		// 		break;
		// 	case 12:
		// 		// Isabela
		// 		plotDetailsMap.setView([16.8758864, 121.5935317], 15)
		// 		break;
		// 	case 13:
		// 		// Negros
		// 		plotDetailsMap.setView([10.5650808, 122.9924843], 16)
		// 		break;
		// 	case 14:
		// 		// Bicol
		// 		plotDetailsMap.setView([13.2503128, 123.5675003], 16)
		// 		break;
		// 	case 15:
		// 		// CMU
		// 		plotDetailsMap.setView([7.8481625, 125.0482655], 16)
		// 		break;
		// 	case 16:
		// 		// Zamboanga
		// 		// CES
		// 		plotDetailsMap.setView([15.6711339, 120.8910602], 16)
		// 		break;
		// 	case 17:
		// 		// Samar
		// 		// CES
		// 		plotDetailsMap.setView([15.6711339, 120.8910602], 16)
		// 		break;
		// 	case 18:
		// 		// Mindoro
		// 		// CES
		// 		plotDetailsMap.setView([15.6711339, 120.8910602], 16)
		// 		break;
		// 	default:
		// 		// CES
		// 		plotDetailsMap.setView([15.6711339, 120.8910602], 16)
		// 		break;
		// }

		let polygon = new Array()
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
		plotDetailsMap.setView(center, 18)
	}

</script>