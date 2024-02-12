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
		let createPlotMap = L.map('createPlotMap', {
			layers: [GoogleMapsHybrid]
		})

		createPlotMap.setView([15.6711339, 120.8910602], 13);

		// Initialise the FeatureGroup to store editable layers
		let editableLayers = new L.FeatureGroup()
		createPlotMap.addLayer(editableLayers)

		let drawPluginOptions = {
			position: 'topright',
		    draw: {
		        polygon: {
		            allowIntersection: false, // Restricts shapes to simple polygons
		            drawError: {
		                color: '#E1E100', // Color the shape will turn when intersects
		                message: '<strong>Oh snap!<strong> you can\'t draw that!' // Message that will show when intersect
		            },
		            shapeOptions: {
		                color: '#FF001F'
		            },
		            showArea: true,
		            showLength: true,
		            metric: ['ha']
		        },
		        // disable toolbar item by setting it to false
		        polyline: false,
		        circle: false, // Turns off this drawing tool
		        rectangle: false,
		        marker: false,
		        circlemarker: false
		    },
		    edit: {
		        featureGroup: editableLayers, //REQUIRED!!
		        remove: true,
		        edit: false,
		    }
		}

		// Initialise the draw control and pass it the FeatureGroup of editable layers
		let drawControl = new L.Control.Draw(drawPluginOptions);
		createPlotMap.addControl(drawControl);

		createPlotMap.on('draw:created', (e) => {
			let type = e.layerType
			let layer = e.layer

			editableLayers.addLayer(layer)

			let coordinates = layer.toGeoJSON().geometry.coordinates
			let coordinatesArray = []

			for (let i=0; i < coordinates[0].length - 1; ++i) {
				let data = [coordinates[0][i][1], coordinates[0][i][0]]
				coordinatesArray.push(data);
			}

			coordinatesString = coordinatesArray.join([separator=';'])
			document.getElementById('coordinates').value = coordinatesString
		})

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
					}).addTo(createPlotMap)

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