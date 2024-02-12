<script>
	function gen_harvesting_report() {
		let station = document.getElementById('station').value;
		let year = document.getElementById('year').value;
		let semInput = document.getElementsByName('sem');
		let sem;
		Array.from(semInput).map(currElement => {
			if (currElement.checked) {
				sem = currElement.value;
			}
		});
		let seedClassInput = document.getElementsByName('seedClass');
		let seedClass;
		Array.from(seedClassInput).map(currElement => {
			if (currElement.checked) {
				seedClass = currElement.value;
			}
		});

		if (station && year && sem && seedClass) {
			HoldOn.open(holdonOptions)

			$.ajax({
				type: 'POST',
				url: "{{route('harvesting_report.generate')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'stationID': station,
					'year': year,
					'sem': sem,
					'seedClass': seedClass
				},
				dataType: 'JSON',
				success: (harvesting_report) => {
					// console.log(harvesting_report);

					// Destroy harvesting report table datatable
					if ($.fn.DataTable.isDataTable('#harvesting_report_table')) {
						$('#harvesting_report_table').DataTable().destroy();
					}

					// Empty harvesting report tbody
					$('#harvesting_report_table tbody').empty();

					// Initiate planting plan table datatable
					let harvesting_report_table = $('#harvesting_report_table').DataTable({
						columns: [
							{
								'name': 'station',
								'data': 'station',
								'width': '7%',
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
								'width': '7%',
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
								'width': '18%',
								'className': 'text-right'
							},
							{
								'name': 'harvest_date',
								'data': 'harvest_date',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'weight',
								'data': 'weight',
								'width': '18%',
								'className': 'text-right'
							},
							{
								'name': 'moisture_content',
								'data': 'moisture_content',
								'width': '10%',
								'className': 'text-right'
							}
						],
						searching: false,
						bSort: false
					});

					var total_area = 0;
					var total_area_bs = 0;
					var total_area_fs = 0;
					var total_area_rs = 0;
					var total_weight = 0;
					var total_weight_bs = 0;
					var total_weight_fs = 0;
					var total_weight_rs = 0;

					// loop the harvesting report object
					for (var key in harvesting_report) {
						var station = key;
						var variety_array = harvesting_report[station];

						// loop the variety array object
						for (var key in variety_array) {
							var variety = key;
							var seed_class_array = variety_array[variety];

							// loop the seed class array object
							for (var key in seed_class_array) {
								var seed_class = key;
								var data = seed_class_array[seed_class];

								// get the average of moisture content if values are more than 1
								var moisture_content_len = data['moisture_content'].length;
								var moisture_content = 0;

								if (moisture_content_len > 1) {
									data['moisture_content'].forEach((item, index) => {
										moisture_content += parseFloat(item);
									});

									moisture_content = moisture_content / moisture_content_len;
								} else {
									moisture_content = data['moisture_content'][0];
								}

								// add row to datatable
								harvesting_report_table.row.add({
									'station': station,
									'variety': variety,
									'ecosystem': data['ecosystem'],
									'maturity': data['maturity'],
									'seedClass': seed_class,
									'area': to_locale_string(data['area']),
									'harvest_date': data['date_harvest'],
									'weight': to_locale_string(data['weight']),
									'moisture_content': to_locale_string(moisture_content)
								});

								total_area += data['area'];
								total_weight += data['weight'];

								switch (seed_class) {
									case "Nucleus":
										total_area_bs += data['area'];
										total_weight_bs += data['weight'];
										break; 
									case "Breeder":
										total_area_fs += data['area'];
										total_weight_fs += data['weight'];
										break;
									case "Foundation":
										total_area_rs += data['area'];
										total_weight_rs += data['weight'];
										break;
								}
							}
						}
					}

					if (seedClass == "All") {
						// Show total area BS row
						document.getElementById('totalBSRow').style.display = "table-row";
						// Show total area FS row
						document.getElementById('totalFSRow').style.display = "table-row";
						// Show total area RS row
						document.getElementById('totalRSRow').style.display = "table-row";

						// Set text to total area BS cell
						document.getElementById('totalAreaBS').innerHTML =  to_locale_string(total_area_bs);

						// Set text to total weight BS cell
						document.getElementById('totalWeightBS').innerHTML =  to_locale_string(total_weight_bs);

						// Set text to total area FS cell
						document.getElementById('totalAreaFS').innerHTML =  to_locale_string(total_area_fs);

						// Set text to total weight FS cell
						document.getElementById('totalWeightFS').innerHTML =  to_locale_string(total_weight_fs);

						// Set text to total area RS cell
						document.getElementById('totalAreaRS').innerHTML =  to_locale_string(total_area_rs);

						// Set text to total weight RS cell
						document.getElementById('totalWeightRS').innerHTML =  to_locale_string(total_weight_rs);
					}

					if (seedClass == "Nucleus") {
						// Show total area BS row
						document.getElementById('totalBSRow').style.display = "table-row";

						// Set text to total area BS cell
						document.getElementById('totalAreaBS').innerHTML =  to_locale_string(total_area_bs);

						// Set text to total weight BS cell
						document.getElementById('totalWeightBS').innerHTML =  to_locale_string(total_weight_bs);
					}

					if (seedClass == "Breeder") {
						// Show total area FS row
						document.getElementById('totalFSRow').style.display = "table-row";

						// Set text to total area FS cell
						document.getElementById('totalAreaFS').innerHTML =  to_locale_string(total_area_fs);

						// Set text to total weight FS cell
						document.getElementById('totalWeightFS').innerHTML =  to_locale_string(total_weight_fs);
					}

					if (seedClass == "Foundation") {
						// Show total area RS row
						document.getElementById('totalRSRow').style.display = "table-row";

						// Set text to total area RS cell
						document.getElementById('totalAreaRS').innerHTML =  to_locale_string(total_area_rs);

						// Set text to total weight RS cell
						document.getElementById('totalWeightRS').innerHTML =  to_locale_string(total_weight_rs);
					}

					// Set text to total area cell
					document.getElementById('totalArea').innerHTML =  to_locale_string(total_area);

					// Set text to total weight cell
					document.getElementById('totalWeight').innerHTML =  to_locale_string(total_weight);

					// Draw table
					harvesting_report_table.draw();

					// Display table
					document.getElementById('harvesting_report_table').style.display = "table";

					// Display export to excel button
					document.getElementById('exportToExcelButton').style.display = "inline-block";

					// Display export to PDF button
					document.getElementById('exportToPDFButton').style.display = "inline-block";

					HoldOn.close();
				}
			});
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
			form.action = "{{route('harvesting_report.exportToPDF')}}"
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
			form.action = "{{route('harvesting_report.export')}}"
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

	function to_locale_string(value) {
		return value.toLocaleString('en-US', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
			roundingIncrement: 5
		});
	}
</script>