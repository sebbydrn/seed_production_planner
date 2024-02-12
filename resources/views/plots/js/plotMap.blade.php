<script>
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
		let plotMap = L.map('plotMap', {
			layers: [GoogleMapsHybrid]
		})

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
				plotMap.setView([7.8532763,125.0504606], 16)
				break;
			case 16:
				// Zamboanga
				// CES
				plotMap.setView([15.6711339, 120.8910602], 16)
				break;
			case 17:
				// Samar
				// CES
				plotMap.setView([12.5094183,124.6617746], 16)
				break;
			case 18:
				// Mindoro
				// CES
				plotMap.setView([13.1386758,120.717194], 16)
				break;
			default:
				// CES
				plotMap.setView([15.6711339, 120.8910602], 16)
				break;
		}

		// Show existing active plots to map
		$.ajax({
			type: 'GET',
			url: "{{route('plots.active_plots')}}",
			dataType: 'JSON',
			success: (res) => {
				res.forEach((item) => {
					let coordinates = ""
					let polygon = new Array()

					coordinates = item['coordinates']
					coordinates = coordinates.split(";")

					for (let i=0; i<coordinates.length; i++) {
						let point = coordinates[i].split(",")
						polygon.push(L.latLng(parseFloat(point[0]), parseFloat(point[1])))
					}

					let plot = L.polygon(polygon, {
						color: '#E1E100'
					}).addTo(plotMap)

					let plotDetails = '<table class="table table-bordered table-striped">'
					plotDetails += '<tr><td style="width: 40%;">Plot Name:</td>'
					plotDetails += '<td><strong>'+item['name']+'</strong></td></tr>'
					plotDetails += '<tr><td>Area:</td>'
					plotDetails += '<td><strong>'+parseFloat(item['area'])+' ha</strong></td></tr>'
					plotDetails += '</table>'

					plot.bindPopup(plotDetails)
				})
			} 
		})
	})


</script>