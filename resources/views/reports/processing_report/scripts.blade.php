<script>
	function gen_processing_report() {
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
				url: "{{route('processing_report.generate')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'stationID': station,
					'year': year,
					'sem': sem,
					'seedClass': seedClass
				},
				dataType: 'JSON',
				success: (processing_report) => {
					console.log(processing_report);

					// Destroy processing report table datatable
					if ($.fn.DataTable.isDataTable('#processing_report_table')) {
						$('#processing_report_table').DataTable().destroy();
					}

					// Empty processing report tbody
					$('#processing_report_table tbody').empty();

					// Initiate processing report table datatable
					let processing_report_table = $('#processing_report_table').DataTable({
						columns: [
							{
								'name': 'station',
								'data': 'station',
								'width': '5%',
								'className': 'text-center'
							},
							{
								'name': 'variety',
								'data': 'variety',
								'width': '12%',
								'className': 'text-center'
							},
							{
								'name': 'seed_class',
								'data': 'seed_class',
								'width': '12%',
								'className': 'text-center'
							},
							{
								'name': 'fresh_weight',
								'data': 'fresh_weight',
								'width': '11%',
								'className': 'text-right'
							},
							{
								'name': 'fresh_moisture_content',
								'data': 'fresh_moisture_content',
								'width': '11%',
								'className': 'text-right'
							},
							{
								'name': 'dried_weight',
								'data': 'dried_weight',
								'width': '11%',
								'className': 'text-right'
							},
							{
								'name': 'dried_moisture_content',
								'data': 'dried_moisture_content',
								'width': '11%',
								'className': 'text-right'
							},
							{
								'name': 'filled_weight',
								'data': 'filled_weight',
								'width': '11%',
								'className': 'text-right'
							},
							{
								'name': 'half_filled_weight',
								'data': 'half_filled_weight',
								'width': '11%',
								'className': 'text-right'
							},
							{
								'name': 'unfilled_weight',
								'data': 'unfilled_weight',
								'width': '11%',
								'className': 'text-right'
							}
						],
						searching: false,
						bSort: false
					});

					// loop the processing report object
					for (var key in processing_report) {
						var station = key;
						var variety_array = processing_report[station];

						// loop the variety array object
						for (var key in variety_array) {
							var variety = key;
							var seed_class_array = variety_array[variety];

							// loop the seed class array object
							for (var key in seed_class_array) {
								var seed_class = key;
								var data = seed_class_array[seed_class];

								var fresh_moisture_content = moisture_content_value(data['fresh_moisture_content']);
								var dried_moisture_content = moisture_content_value(data['dried_moisture_content']);

								// add row to datatable
								processing_report_table.row.add({
									'station': station,
									'variety': variety,
									'seed_class': seed_class,
									'fresh_weight': to_locale_string(data['fresh_weight']),
									'fresh_moisture_content': fresh_moisture_content,
									'dried_weight': to_locale_string(data['dried_weight']),
									'dried_moisture_content': dried_moisture_content,
									'filled_weight': to_locale_string(parseFloat(data['filled_weight'])),
									'half_filled_weight': to_locale_string(parseFloat(data['half_filled_weight'])),
									'unfilled_weight': to_locale_string(parseFloat(data['unfilled_weight']))
								});
							}
						}
					}

					// Draw table
					processing_report_table.draw();

					// Display table
					document.getElementById('processing_report_table').style.display = "table";

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
			form.action = "{{route('processing_report.exportToPDF')}}"
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
			form.action = "{{route('processing_report.export')}}"
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

	function moisture_content_value(data) {
		// get the average of moisture content if values are more than 1
		var moisture_content_len = data.length;
		var moisture_content = 0;

		if (moisture_content_len > 1) {
			data.forEach((item, index) => {
				moisture_content += parseFloat(item);
			});

			moisture_content = moisture_content / moisture_content_len;
		} else if (moisture_content_len == 1) {
			moisture_content = parseFloat(data[0]);
		} else {
			moisture_content = 0;
		}

		return to_locale_string(moisture_content);
	}

	function to_locale_string(value) {
		if (value == null || isNaN(value)) {
			return '-';
		} else {
			return value.toLocaleString('en-US', {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2,
				roundingIncrement: 5
			});
		}
	}
</script>