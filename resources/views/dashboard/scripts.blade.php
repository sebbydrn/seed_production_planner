<script>
	$(document).ready(() => {
		var stationID = document.getElementById('station').value

		if (stationID != "Select Station") {
			HoldOn.open(holdonOptions)

			$.ajax({
				type: 'POST',
				url: "{{route('dashboard.years')}}",
				data: {
					_token: "{{csrf_token()}}",
					stationID: stationID
				},
				dataType: 'JSON',
				success: (res) => {
					let yearSelect = document.getElementById('year')
					yearSelect.innerHTML = ""

					let option = document.createElement('option')
					option.innerHTML = 'Select Year'
					option.setAttribute('disabled', 'disabled')
					option.setAttribute('selected', 'selected')
					yearSelect.append(option)

					res.forEach(function(item, index) {
						let option = document.createElement('option')
						option.value = item.year
						option.innerHTML = item.year
						yearSelect.append(option)
					})

					HoldOn.close()
				}
			})
		}
	})


	function stationChange() {
		HoldOn.open(holdonOptions)

		stationID = document.getElementById('station').value

		$.ajax({
			type: 'POST',
			url: "{{route('dashboard.years')}}",
			data: {
				_token: "{{csrf_token()}}",
				stationID: stationID
			},
			dataType: 'JSON',
			success: (res) => {
				let yearSelect = document.getElementById('year')
				yearSelect.innerHTML = ""

				let option = document.createElement('option')
				option.innerHTML = 'Select Year'
				option.setAttribute('disabled', 'disabled')
				option.setAttribute('selected', 'selected')
				yearSelect.append(option)

				res.forEach(function(item, index) {
					let option = document.createElement('option')
					option.value = item.year
					option.innerHTML = item.year
					yearSelect.append(option)
				})

				HoldOn.close()
			}
		})
	}

	function semChange() {
		HoldOn.open(holdonOptions)

		let stationID = document.getElementById('station').value
		let year = document.getElementById('year').value
		let sem = ""

		if (document.getElementById('sem1').checked) {
			sem = document.getElementById('sem1').value
		}

		if (document.getElementById('sem2').checked) {
			sem = document.getElementById('sem2').value
		}

		if (year != "Select Year" && sem != "") {
			$.ajax({
				type: 'POST',
				url: "{{route('dashboard.varieties_planted')}}",
				data: {
					_token: "{{csrf_token()}}",
					stationID: stationID,
					year: year,
					sem: sem
				},
				dataType: 'JSON',
				success: (res) => {
					let varietySelect = document.getElementById('variety')
					varietySelect.innerHTML = ""

					let option = document.createElement('option')
					option.innerHTML = 'Select Variety'
					option.setAttribute('disabled', 'disabled')
					option.setAttribute('selected', 'selected')
					varietySelect.append(option)

					if (res.length > 0) {
						option = document.createElement('option')
						option.value = 'All Varieties'
						option.innerHTML = 'All Varieties'
						varietySelect.append(option)
					}

					res.forEach(function(item, index) {
						let option = document.createElement('option')
						option.value = item.variety
						option.innerHTML = item.variety
						varietySelect.append(option)
					})

					HoldOn.close()
				}
			})
		} else {
			HoldOn.close()
		}
	}

	function showActivities() {
		HoldOn.open(holdonOptions)

		let stationID = document.getElementById('station').value
		let year = document.getElementById('year').value
		let variety = document.getElementById('variety').value
		let sem = ""

		if (document.getElementById('sem1').checked) {
			sem = document.getElementById('sem1').value
		}

		if (document.getElementById('sem2').checked) {
			sem = document.getElementById('sem2').value
		}

		if (stationID == "Select Station" || variety == "Select Variety" || year == "Select Year" || sem == "") {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		HoldOn.close()
		} else {
			// Clear polygons in LayerGroup
			if (layerGroup) {
				layerGroup.clearLayers()
			}
			
			$.ajax({
				type: 'POST',
				url: "{{route('dashboard.show_activities')}}",
				data: {
					_token: "{{csrf_token()}}",
					stationID: stationID,
					year: year,
					sem: sem,
					variety: variety
				},
				dataType: 'JSON',
				success: (res) => {
					console.log(res)

					setView(stationID)

					// Clear polygons in LayerGroup
					if (layerGroup) {
						layerGroup.clearLayers()
					}

					let plots = res.plots

					plots.forEach(function(item, index) {
						let polygon = new Array()

						let plotCoordinates = item.coordinates
						plotCoordinates = plotCoordinates.split(';')

						for (let i=0; i<plotCoordinates.length; i++) {
							let point = plotCoordinates[i].split(",")
							polygon.push(L.latLng(parseFloat(point[0]), parseFloat(point[1])))
						}

						let plot = L.polygon(polygon, {
							color: '#E1E100'
						}).addTo(plotMap)
						layerGroup.addLayer(plot)

						let plotDetails = '<table class="table table-bordered table-striped">'
						plotDetails += '<tr><td style="width: 40%;">Variety Planted:</td>'
						plotDetails += '<td><strong>'+item.variety+'</strong></td></tr>'
						plotDetails += '<tr><td>Seed Class Planted:</td>'
						plotDetails += '<td><strong>'+item.seedClass+'</strong></td></tr>'
						plotDetails += '<tr><td>Plot Name:</td>'
						plotDetails += '<td><strong>'+item.plotName+'</strong></td></tr>'
						plotDetails += '<tr><td>Plot Area:</td>'
						plotDetails += '<td><strong>'+parseFloat(item.plotArea)+' ha</strong></td></tr>'
						plotDetails += '</table>'

						plot.bindPopup(plotDetails)
					})

					let markerCoordinates

					// Seedling Management
					let seedlingManagement = res.seedlingManagement

					seedlingManagement.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Activity:</td>'
							activityDetails += '<td><strong>'+item.activity+'</strong></td></tr>'
							activityDetails += '<tr><td>Status:</td>'
							activityDetails += '<td><strong>'+item.status+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time:</td>'
							activityDetails += '<td><strong>'+item.timestamp+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Land Preparation
					let landPreparation = res.landPreparation

					landPreparation.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Crop Phase:</td>'
							activityDetails += '<td><strong>'+item.cropPhase+'</strong></td></tr>'
							activityDetails += '<tr><td>Activity:</td>'
							activityDetails += '<td><strong>'+item.activity+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time Start:</td>'
							activityDetails += '<td><strong>'+item.datetimeStart+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time End:</td>'
							activityDetails += '<td><strong>'+item.datetimeEnd+'</strong></td></tr>'
							activityDetails += '<tr><td>Labor Cost:</td>'
							activityDetails += '<td><strong>'+item.laborCost+'</strong></td></tr>'
							activityDetails += '<tr><td>No. of Workers:</td>'
							activityDetails += '<td><strong>'+item.workersNo+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Crop Establishment
					let cropEstablishment = res.cropEstablishment

					cropEstablishment.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Activity:</td>'
							activityDetails += '<td><strong>'+item.activity+'</strong></td></tr>'
							activityDetails += '<tr><td>Transplanting Method:</td>'
							activityDetails += '<td><strong>'+item.transplantingMethod+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time Start:</td>'
							activityDetails += '<td><strong>'+item.datetimeStart+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time End:</td>'
							activityDetails += '<td><strong>'+item.datetimeEnd+'</strong></td></tr>'
							activityDetails += '<tr><td>Labor Cost:</td>'
							activityDetails += '<td><strong>'+item.laborCost+'</strong></td></tr>'
							activityDetails += '<tr><td>No. of Workers:</td>'
							activityDetails += '<td><strong>'+item.workersNo+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Water Management
					let waterManagement = res.waterManagement

					waterManagement.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Crop Phase:</td>'
							activityDetails += '<td><strong>'+item.cropPhase+'</strong></td></tr>'
							activityDetails += '<tr><td>Crop Stage:</td>'
							activityDetails += '<td><strong>'+item.cropStage+'</strong></td></tr>'
							activityDetails += '<tr><td>Activity:</td>'
							activityDetails += '<td><strong>'+item.activity+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time Start:</td>'
							activityDetails += '<td><strong>'+item.datetimeStart+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time End:</td>'
							activityDetails += '<td><strong>'+item.datetimeEnd+'</strong></td></tr>'
							activityDetails += '<tr><td>Labor Cost:</td>'
							activityDetails += '<td><strong>'+item.laborCost+'</strong></td></tr>'
							activityDetails += '<tr><td>No. of Workers:</td>'
							activityDetails += '<td><strong>'+item.workersNo+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Nutrient Management
					let nutrientManagement = res.nutrientManagement

					nutrientManagement.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Crop Phase:</td>'
							activityDetails += '<td><strong>'+item.cropPhase+'</strong></td></tr>'
							activityDetails += '<tr><td>Technology Used:</td>'
							activityDetails += '<td><strong>'+item.technologyUsed+'</strong></td></tr>'
							activityDetails += '<tr><td>Fertilizer Used:</td>'
							
							if (item.fertilizerUsed == "Others") {
								activityDetails += '<td><strong>'+item.otherFertilizer+'</strong></td></tr>'
							} else {
								activityDetails += '<td><strong>'+item.fertilizerUsed+'</strong></td></tr>'
							}

							activityDetails += '<tr><td>Formulation:</td>'
							activityDetails += '<td><strong>'+item.formulation+'</strong></td></tr>'
							activityDetails += '<tr><td>Unit:</td>'
							activityDetails += '<td><strong>'+item.unit+'</strong></td></tr>'

							if (item.formulation == "Granular") {
								activityDetails += '<tr><td>Total Chemical Used:</td>'
								activityDetails += '<td><strong>'+item.totalChemicalUsed+'</strong></td></tr>'
							} else {
								activityDetails += '<tr><td>No. of Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadNo+'</strong></td></tr>'
								activityDetails += '<tr><td>Volume Per Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadVolume+'</strong></td></tr>'
								activityDetails += '<tr><td>Rate Per Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadRate+'</strong></td></tr>'
							}

							activityDetails += '<tr><td>Date & Time Start:</td>'
							activityDetails += '<td><strong>'+item.datetimeStart+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time End:</td>'
							activityDetails += '<td><strong>'+item.datetimeEnd+'</strong></td></tr>'
							activityDetails += '<tr><td>Labor Cost:</td>'
							activityDetails += '<td><strong>'+item.laborCost+'</strong></td></tr>'
							activityDetails += '<tr><td>No. of Workers:</td>'
							activityDetails += '<td><strong>'+item.workersNo+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '<tr><td>Has available water in field during time of application?:</td>'
							activityDetails += '<td><strong>'+item.isWaterAvailable+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Disease Management
					let diseaseManagement = res.diseaseManagement

					diseaseManagement.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Crop Phase:</td>'
							activityDetails += '<td><strong>'+item.cropPhase+'</strong></td></tr>'
							activityDetails += '<tr><td>Disease Type:</td>'

							if (item.diseaseType == "Others") {
								activityDetails += '<td><strong>'+item.otherDisease+'</strong></td></tr>'
							} else {
								activityDetails += '<td><strong>'+item.diseaseType+'</strong></td></tr>'
							}

							activityDetails += '<tr><td>Type of Control:</td>'
							activityDetails += '<td><strong>'+item.controlType+'</strong></td></tr>'
							
							if (item.controlType == "Chemical") {
								activityDetails += '<tr><td>Chemical Used:</td>'
								activityDetails += '<td><strong>'+item.chemicalUsed+'</strong></td></tr>'
								activityDetails += '<tr><td>Active Ingredient:</td>'
								activityDetails += '<td><strong>'+item.activeIngredient+'</strong></td></tr>'
								activityDetails += '<tr><td>Mode of Application:</td>'
								activityDetails += '<td><strong>'+item.applicationMode+'</strong></td></tr>'
								activityDetails += '<tr><td>Brand Name:</td>'
								activityDetails += '<td><strong>'+item.brandName+'</strong></td></tr>'
								activityDetails += '<tr><td>Formulation:</td>'
								activityDetails += '<td><strong>'+item.formulation+'</strong></td></tr>'
								activityDetails += '<tr><td>Unit:</td>'
								activityDetails += '<td><strong>'+item.unit+'</strong></td></tr>'
								activityDetails += '<tr><td>No. of Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadNo+'</strong></td></tr>'
								activityDetails += '<tr><td>Volume Per Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadVolume+'</strong></td></tr>'
								activityDetails += '<tr><td>Rate Per Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadRate+'</strong></td></tr>'
							} else {
								activityDetails += '<tr><td>Specify Control:</td>'
								activityDetails += '<td><strong>'+item.controlSpec+'</strong></td></tr>'
							}

							activityDetails += '<tr><td>Date & Time Start:</td>'
							activityDetails += '<td><strong>'+item.datetimeStart+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time End:</td>'
							activityDetails += '<td><strong>'+item.datetimeEnd+'</strong></td></tr>'
							activityDetails += '<tr><td>Labor Cost:</td>'
							activityDetails += '<td><strong>'+item.laborCost+'</strong></td></tr>'
							activityDetails += '<tr><td>No. of Workers:</td>'
							activityDetails += '<td><strong>'+item.workersNo+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Pest Management
					let pestManagement = res.pestManagement

					pestManagement.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Crop Phase:</td>'
							activityDetails += '<td><strong>'+item.cropPhase+'</strong></td></tr>'
							activityDetails += '<tr><td>Pest Type:</td>'
							activityDetails += '<td><strong>'+item.pestType+'</strong></td></tr>'
							activityDetails += '<tr><td>Specify Pest:</td>'
							activityDetails += '<td><strong>'+item.pestSpec+'</strong></td></tr>'
							activityDetails += '<tr><td>Type of Control:</td>'
							activityDetails += '<td><strong>'+item.controlType+'</strong></td></tr>'
							
							if (item.controlType == "Chemical") {
								activityDetails += '<tr><td>Chemical Used:</td>'
								activityDetails += '<td><strong>'+item.chemicalUsed+'</strong></td></tr>'
								activityDetails += '<tr><td>Active Ingredient:</td>'
								activityDetails += '<td><strong>'+item.activeIngredient+'</strong></td></tr>'
								activityDetails += '<tr><td>Mode of Application:</td>'
								activityDetails += '<td><strong>'+item.applicationMode+'</strong></td></tr>'
								activityDetails += '<tr><td>Brand Name:</td>'
								activityDetails += '<td><strong>'+item.brandName+'</strong></td></tr>'
								activityDetails += '<tr><td>Formulation:</td>'
								activityDetails += '<td><strong>'+item.formulation+'</strong></td></tr>'
								activityDetails += '<tr><td>Unit:</td>'
								activityDetails += '<td><strong>'+item.unit+'</strong></td></tr>'
								activityDetails += '<tr><td>No. of Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadNo+'</strong></td></tr>'
								activityDetails += '<tr><td>Volume Per Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadVolume+'</strong></td></tr>'
								activityDetails += '<tr><td>Rate Per Tank Load:</td>'
								activityDetails += '<td><strong>'+item.tankLoadRate+'</strong></td></tr>'
							} else {
								activityDetails += '<tr><td>Specify Control:</td>'
								activityDetails += '<td><strong>'+item.controlSpec+'</strong></td></tr>'
							}

							activityDetails += '<tr><td>Date & Time Start:</td>'
							activityDetails += '<td><strong>'+item.datetimeStart+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time End:</td>'
							activityDetails += '<td><strong>'+item.datetimeEnd+'</strong></td></tr>'
							activityDetails += '<tr><td>Labor Cost:</td>'
							activityDetails += '<td><strong>'+item.laborCost+'</strong></td></tr>'
							activityDetails += '<tr><td>No. of Workers:</td>'
							activityDetails += '<td><strong>'+item.workersNo+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Roguing
					let roguing = res.roguing

					roguing.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Crop Phase:</td>'
							activityDetails += '<td><strong>'+item.cropPhase+'</strong></td></tr>'
							activityDetails += '<tr><td>No. of offtypes removed:</td>'
							activityDetails += '<td><strong>'+item.offtypesRemovedCount+'</strong></td></tr>'
							activityDetails += '<tr><td>Kind of offtypes:</td>'
							activityDetails += '<td><strong>'+item.offtypesKind+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time:</td>'
							activityDetails += '<td><strong>'+item.timestamp+'</strong></td></tr>'
							activityDetails += '<tr><td>Laborers:</td>'
							activityDetails += '<td><strong>'+item.laborers+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Harvesting
					let harvesting = res.harvesting

					harvesting.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Harvesting Method:</td>'
							activityDetails += '<td><strong>'+item.harvestingMethod+'</strong></td></tr>'
							activityDetails += '<tr><td>Date & Time:</td>'
							activityDetails += '<td><strong>'+item.timestamp+'</strong></td></tr>'
							activityDetails += '<tr><td>No. of Bags:</td>'
							activityDetails += '<td><strong>'+parseInt(item.bagsNo)+'</strong></td></tr>'
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					// Damage Assessment
					let damageAssessment = res.damageAssessment

					damageAssessment.forEach(function(item, index) {
						if (item.locationPoint) {
							markerCoordinates = item.locationPoint
							markerCoordinates = markerCoordinates.split(',')

							let marker = L.marker([markerCoordinates[0], markerCoordinates[1]])
							layerGroup.addLayer(marker)

							let activityDetails = '<table class="table table-bordered table-striped">'
							activityDetails += '<tr><td style="width: 40%;">Date & Time:</td>'
							activityDetails += '<td><strong>'+item.timestamp+'</strong></td></tr>'
							activityDetails += '<tr><td>Cause of Damage:</td>'

							if (item.damageCause == "Others") {
								activityDetails += '<td><strong>'+item.damageSpec+'</strong></td></tr>'
							} else {
								activityDetails += '<td><strong>'+item.damageCause+'</strong></td></tr>'
							}
							
							activityDetails += '<tr><td>Remarks:</td>'
							activityDetails += '<td><strong>'+item.remarks+'</strong></td></tr>'
							activityDetails += '</table>'

							marker.bindPopup(activityDetails)
						}
					})

					HoldOn.close()
				}
			})
		}
	}

	function setView(stationID) {
		// Set View
		switch (parseInt(stationID)) {
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
	}

</script>