<script>
	function generatePlantingPlan() {
		let station = document.getElementById('station').value
		let year = document.getElementById('year').value
		let semInput = document.getElementsByName('sem')
		let sem
		Array.from(semInput).map(currElement => {
			if (currElement.checked) {
				sem = currElement.value
			}
		})
		let seedClassInput = document.getElementsByName('seedClass')
		let seedClass
		Array.from(seedClassInput).map(currElement => {
			if (currElement.checked) {
				seedClass = currElement.value
			}
		})

		if (station && year && sem && seedClass) {
			HoldOn.open(holdonOptions)

			$.ajax({
				type: 'POST',
				url: "{{route('planting_plan.generate')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'stationID': station,
					'year': year,
					'sem': sem,
					'seedClass': seedClass
				},
				dataType: 'JSON',
				success: (plan) => {
					console.log(plan)

					// Destroy planting plan table datatable
					if ($.fn.DataTable.isDataTable('#plantingPlanTable')) {
						$('#plantingPlanTable').DataTable().destroy()
					}

					// Empty planting plan tbody
					$('#plantingPlanTable tbody').empty()

					// Initiate planting plan table datatable
					let plantingPlanTable = $('#plantingPlanTable').DataTable({
						columns: [
							{
								'name': 'station',
								'data': 'station',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'variety',
								'data': 'variety',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'ecosystem',
								'data': 'ecosystem',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'maturity',
								'data': 'maturity',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'seedClass',
								'data': 'seedClass',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'area',
								'data': 'area',
								'width': '10%',
								'className': 'text-right'
							},
							{
								'name': 'sowingDate',
								'data': 'sowingDate',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'transplantingDate',
								'data': 'transplantingDate',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'harvestingDate',
								'data': 'harvestingDate',
								'width': '10%',
								'className': 'text-center'
							}
						],
						searching: false,
						bSort: false
					})

					let totalAreaBS = 0
					let totalAreaFS = 0
					let totalAreaRS = 0
					let totalArea = 0

					// filter array to Nucleus only
					var breeder = plan.filter(plan => plan.seedClass == "Nucleus");

					if (breeder.length) {
						// Add breeder seed production row header
						let breederRow = plantingPlanTable
							.row.add({
								'station': 'BREEDER SEED PRODUCTION',
								'variety': null,
								'ecosystem': null,
								'maturity': null,
								'seedClass': null,
								'area': null,
								'sowingDate': null,
								'transplantingDate': null,
								'harvestingDate': null
							})
							.node()

						// Set colspan and attributes
						$('td:first', breederRow)
							.attr({
								'colspan': 9
							})
							.addClass('breederHeader')
							.css({
								'font-weight': 'bold',
								'text-align': 'left'
							})

						// Remove other table celss other than the first
						$('td:gt(0)', breederRow).remove()

						// Add breeder seed production data to table
						breeder.map(currElement => {
							plantingPlanTable.row.add({
								'station': currElement['station'],
								'variety': currElement['variety'],
								'ecosystem': currElement['ecosystem'],
								'maturity': currElement['maturity'],
								'seedClass': currElement['seedClass'],
								'area': currElement['area'],
								'sowingDate': currElement['sowingDate'],
								'transplantingDate': currElement['transplantingDate'],
								'harvestingDate': currElement['harvestingDate']
							})

							// Calculate total area of BS seed production area
							totalAreaBS = totalAreaBS + currElement['area']
						})

						// Add total area of BS seed production to total seed production area
						totalArea = totalArea + totalAreaBS

						// Show total area BS row
						document.getElementById('totalBSRow').style.display = "table-row"

						// Set text to total area BS cell
						document.getElementById('totalAreaBS').innerHTML = totalAreaBS.toFixed(5)
					} else {
						// Hide total area BS row if ther is no BS seed production data
						document.getElementById('totalBSRow').style.display = "none"
					}

					// filter array to BS Only
					let foundation = plan.filter(plan => plan.seedClass == "Breeder")

					// If data has Foundation Seed Production
					if (foundation.length) {
						// Add foundation seed production row header
						let foundationRow = plantingPlanTable
							.row.add({
								'station': 'FOUNDATION SEED PRODUCTION',
								'variety': null,
								'ecosystem': null,
								'maturity': null,
								'seedClass': null,
								'area': null,
								'sowingDate': null,
								'transplantingDate': null,
								'harvestingDate': null
							})
							.node()

						// Set colspan and attributes
						$('td:first', foundationRow)
							.attr({
								'colspan': 9
							})
							.addClass('foundationHeader primary')
							.css({
								'font-weight': 'bold',
								'text-align': 'left'
							})

						// Remove other table celss other than the first
						$('td:gt(0)', foundationRow).remove()

						// Add foundation seed production data to table
						foundation.map(currElement => {
							plantingPlanTable.row.add({
								'station': currElement['station'],
								'variety': currElement['variety'],
								'ecosystem': currElement['ecosystem'],
								'maturity': currElement['maturity'],
								'seedClass': currElement['seedClass'],
								'area': currElement['area'],
								'sowingDate': currElement['sowingDate'],
								'transplantingDate': currElement['transplantingDate'],
								'harvestingDate': currElement['harvestingDate']
							})

							// Calculate total area of FS seed production area
							totalAreaFS = totalAreaFS + currElement['area']
						})

						// Add total area of FS seed production to total seed production area
						totalArea = totalArea + totalAreaFS

						// Show total area FS row
						document.getElementById('totalFSRow').style.display = "table-row"

						// Set text to total area FS cell
						document.getElementById('totalAreaFS').innerHTML = totalAreaFS.toFixed(5)
					} else {
						// Hide total area FS row if ther is no FS seed production data
						document.getElementById('totalFSRow').style.display = "none"
					}

					// filter array to FS Only
					let registered = plan.filter(plan => plan.seedClass == "Foundation")

					// If data has Registered Seed Production
					if (registered.length) {
						// Add registered seed production row header
						let registeredRow = plantingPlanTable
							.row.add({
								'station': 'REGISTERED SEED PRODUCTION',
								'variety': null,
								'ecosystem': null,
								'maturity': null,
								'seedClass': null,
								'area': null,
								'sowingDate': null,
								'transplantingDate': null,
								'harvestingDate': null
							})
							.node()

						// Set colspan and attributes
						$('td:first', registeredRow)
							.attr({
								'colspan': 9
							})
							.addClass('registeredHeader primary')
							.css({
								'font-weight': 'bold',
								'text-align': 'left'
							})

						// Remove other table celss other than the first
						$('td:gt(0)', registeredRow).remove()

						// Add registered seed production data to table
						registered.map(currElement => {
							plantingPlanTable.row.add({
								'station': currElement['station'],
								'variety': currElement['variety'],
								'ecosystem': currElement['ecosystem'],
								'maturity': currElement['maturity'],
								'seedClass': currElement['seedClass'],
								'area': currElement['area'],
								'sowingDate': currElement['sowingDate'],
								'transplantingDate': currElement['transplantingDate'],
								'harvestingDate': currElement['harvestingDate']
							})

							// Calculate total area of RS seed production area
							totalAreaRS = totalAreaRS + currElement['area']
						})

						// Add total area of RS seed production to total seed production area
						totalArea = totalArea + totalAreaRS

						// Show total area RS row
						document.getElementById('totalRSRow').style.display = "table-row"

						// Set text to total area RS cell
						document.getElementById('totalAreaRS').innerHTML = totalAreaRS.toFixed(5)
					} else {
						// Hide total area RS row if ther is no FS seed production data
						document.getElementById('totalRSRow').style.display = "none"
					}

					// Set text to total area cell
					document.getElementById("totalArea").innerHTML = totalArea.toFixed(5)

					// Draw table
					plantingPlanTable.draw();

					// Display table
					document.getElementById('plantingPlanTable').style.display = "table"

					// Display export to excel button
					document.getElementById('exportToExcelButton').style.display = "inline-block"

					// Display export to PDF button
					document.getElementById('exportToPDFButton').style.display = "inline-block"

					HoldOn.close()
				}
			})
		}
	}

	function exportToExcel() {
		let station = document.getElementById('station').value
		let year = document.getElementById('year').value
		let semInput = document.getElementsByName('sem')
		let sem
		Array.from(semInput).map(currElement => {
			if (currElement.checked) {
				sem = currElement.value
			}
		})
		let seedClassInput = document.getElementsByName('seedClass')
		let seedClass
		Array.from(seedClassInput).map(currElement => {
			if (currElement.checked) {
				seedClass = currElement.value
			}
		})

		if (station && year && sem && seedClass) {
			// Create form
			let form = document.createElement('form')
			form.method = 'POST'
			form.action = "{{route('planting_plan.export')}}"
			form.target = "_blank"

			// Create fields and append to the created form
			let tokenField = document.createElement('input')
			tokenField.type = 'hidden'
			tokenField.name = '_token'
			tokenField.value = "{{csrf_token()}}"

			let stationField = document.createElement('input')
			stationField.type = 'hidden'
			stationField.name = 'stationID'
			stationField.value = station

			let yearField = document.createElement('input')
			yearField.type = 'hidden'
			yearField.name = 'year'
			yearField.value = year

			let semField = document.createElement('input')
			semField.type = 'hidden'
			semField.name = 'sem'
			semField.value = sem

			let seedClassField = document.createElement('input')
			seedClassField.type = 'hidden'
			seedClassField.name = 'seedClass'
			seedClassField.value = seedClass

			form.appendChild(tokenField)
			form.appendChild(stationField)
			form.appendChild(yearField)
			form.appendChild(semField)
			form.appendChild(seedClassField)

			// Append form to DOM
			document.body.appendChild(form)

			// Submit form
			form.submit()
		}
	}

	function exportToPDF() {
		let station = document.getElementById('station').value
		let year = document.getElementById('year').value
		let semInput = document.getElementsByName('sem')
		let sem
		Array.from(semInput).map(currElement => {
			if (currElement.checked) {
				sem = currElement.value
			}
		})
		let seedClassInput = document.getElementsByName('seedClass')
		let seedClass
		Array.from(seedClassInput).map(currElement => {
			if (currElement.checked) {
				seedClass = currElement.value
			}
		})

		if (station && year && sem && seedClass) {
			// Create form
			let form = document.createElement('form')
			form.method = 'POST'
			form.action = "{{route('planting_plan.exportToPDF')}}"
			form.target = "_blank"

			// Create fields and append to the created form
			let tokenField = document.createElement('input')
			tokenField.type = 'hidden'
			tokenField.name = '_token'
			tokenField.value = "{{csrf_token()}}"

			let stationField = document.createElement('input')
			stationField.type = 'hidden'
			stationField.name = 'stationID'
			stationField.value = station

			let yearField = document.createElement('input')
			yearField.type = 'hidden'
			yearField.name = 'year'
			yearField.value = year

			let semField = document.createElement('input')
			semField.type = 'hidden'
			semField.name = 'sem'
			semField.value = sem

			let seedClassField = document.createElement('input')
			seedClassField.type = 'hidden'
			seedClassField.name = 'seedClass'
			seedClassField.value = seedClass

			form.appendChild(tokenField)
			form.appendChild(stationField)
			form.appendChild(yearField)
			form.appendChild(semField)
			form.appendChild(seedClassField)

			// Append form to DOM
			document.body.appendChild(form)

			// Submit form
			form.submit()
		}
	}
</script>