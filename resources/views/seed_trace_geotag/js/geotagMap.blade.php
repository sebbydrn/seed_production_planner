<script>
	let geotagMap
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
		geotagMap = L.map('geotagMap', {
			layers: [GoogleMapsHybrid]
		})

		// Set View
		switch ({{$philriceStationID}}) {
			case 4:
				// CES
				geotagMap.setView([15.6711339, 120.8910602], 16)
				// wmsLayer.addTo(geotagMap)
				break;
			case 8:
				// Midsayap
				geotagMap.setView([7.180432, 124.492798], 16)
				break;
			case 9:
				// LB
				geotagMap.setView([14.1604417, 121.2456013], 16)
				break;
			case 10:
				// Agusan
				geotagMap.setView([9.0653577, 125.5833771], 16)
				break;
			case 11:
				// Batac
				geotagMap.setView([18.0572043, 120.5421341], 16)
				break;
			case 12:
				// Isabela
				geotagMap.setView([16.8758864, 121.5935317], 16)
				break;
			case 13:
				// Negros
				geotagMap.setView([10.5650808, 122.9924843], 16)
				break;
			case 14:
				// Bicol
				geotagMap.setView([13.2503128, 123.5675003], 16)
				break;
			case 15:
				// CMU
				geotagMap.setView([7.8481625, 125.0482655], 16)
				break;
			case 16:
				// Zamboanga
				// CES
				geotagMap.setView([15.6711339, 120.8910602], 16)
				break;
			case 17:
				// Samar
				// CES
				geotagMap.setView([15.6711339, 120.8910602], 16)
				break;
			case 18:
				// Mindoro
				// CES
				geotagMap.setView([15.6711339, 120.8910602], 16)
				break;
			default:
				// CES
				geotagMap.setView([15.6711339, 120.8910602], 16)
				break;
		}

		// Get latitude and longitude on right click on map
		geotagMap.on("contextmenu", function (event) {
  			console.log("user right-clicked on map coordinates: " + event.latlng.toString());
  			L.marker(event.latlng).addTo(geotagMap);
  			document.getElementById('locationPoint').value = event.latlng.lat + ',' + event.latlng.lng
		})
	})
</script>