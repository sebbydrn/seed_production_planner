<script>
	function gen_prod_eff_report() {
		let station = document.getElementById('station').value;
		let year = document.getElementById('year').value;
		let semInput = document.getElementsByName('sem');
		let sem;
		Array.from(semInput).map(currElement => {
			if (currElement.checked) {
				sem = currElement.value;
			}
		});

		if (station && year && sem) {
			HoldOn.open(holdonOptions)

			$.ajax({
				type: 'POST',
				url: "{{route('production_efficiency_report.generate')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'stationID': station,
					'year': year,
					'sem': sem
				},
				dataType: 'JSON',
				success: (production_efficiency) => {
					console.log(production_efficiency);

					// Destroy production efficiency report table datatable
					if ($.fn.DataTable.isDataTable('#production_efficiency_report_table')) {
						$('#production_efficiency_report_table').DataTable().destroy();
					}

					// Empty processing report tbody
					$('#production_efficiency_report_table tbody').empty();

					// Initiate production efficiency report table datatable
					let production_efficiency_report_table = $('#production_efficiency_report_table').DataTable({
						columns: [
							{
								'name': 'variety',
								'data': 'variety',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'seed_class',
								'data': 'seed_class',
								'width': '10%',
								'className': 'text-center'
							},
							{
								'name': 'lot_no',
								'data': 'lot_no',
								'width': '6%',
								'className': 'text-center'
							},
							{
								'name': 'date_harvested',
								'data': 'date_harvested',
								'width': '7%',
								'className': 'text-center'
							},
							{
								'name': 'date_sampled',
								'data': 'date_sampled',
								'width': '7%',
								'className': 'text-center'
							},
							{
								'name': 'lab_no',
								'data': 'lab_no',
								'width': '7%',
								'className': 'text-center'
							},
							{
								'name': 'produced_by',
								'data': 'produced_by',
								'width': '6%',
								'className': 'text-center'
							},
							{
								'name': 'foundation',
								'data': 'foundation',
								'width': '8%',
								'className': 'text-right'
							},
							{
								'name': 'registered',
								'data': 'registered',
								'width': '8%',
								'className': 'text-right'
							},
							{
								'name': 'certified',
								'data': 'certified',
								'width': '8%',
								'className': 'text-right'
							},
							{
								'name': 'reject',
								'data': 'reject',
								'width': '8%',
								'className': 'text-right'
							},
							{
								'name': 'total',
								'data': 'total',
								'width': '8%',
								'className': 'text-right'
							},
							{
								'name': 'date_released',
								'data': 'date_released',
								'width': '7%',
								'className': 'text-center'
							}
						],
						searching: false,
						bSort: false
					});

					var fs_total = 0;
					var rs_total = 0;
					var cs_total = 0;
					var reject_total = 0;
					var grand_total = 0;

					var fs_weight_sampled_total = 0;
					var rs_weight_sampled_total = 0;

					// loop the production efficiency report object
					production_efficiency.forEach((item, index) => {
						// add row to datatable
						production_efficiency_report_table.row.add({
							'variety': item['variety'],
							'seed_class': item['seed_class_planted'],
							'lot_no': item['lot_no'],
							'date_harvested': item['date_harvested'],
							'date_sampled': item['date_sampled'],
							'lab_no': item['lab_no'],
							'produced_by': item['produced_by'],
							'foundation': to_locale_string(item['fs']),
							'registered': to_locale_string(item['rs']),
							'certified': to_locale_string(item['cs']),
							'reject': to_locale_string(item['reject']),
							'total': to_locale_string(item['total']),
							'date_released': item['date_released']
						});

						// add totals
						fs_total += item['fs'];
						rs_total += item['rs'];
						cs_total += item['cs'];
						reject_total += item['reject'];
						grand_total += item['total'];

						fs_weight_sampled_total += item['fs_weight_sampled'];
						rs_weight_sampled_total += item['rs_weight_sampled'];
					});

					var fs_seed_eff = (fs_total / fs_weight_sampled_total) * 100;
					var rs_seed_eff = (rs_total / rs_weight_sampled_total) * 100;

					// set totals values
					document.getElementById('fs_total').innerHTML = to_locale_string(fs_total);
					document.getElementById('rs_total').innerHTML = to_locale_string(rs_total);
					document.getElementById('cs_total').innerHTML = to_locale_string(cs_total);
					document.getElementById('reject_total').innerHTML = to_locale_string(reject_total);
					document.getElementById('grand_total').innerHTML = to_locale_string(grand_total);

					document.getElementById('fs_efficiency').innerHTML = to_locale_string(fs_seed_eff);
					document.getElementById('rs_efficiency').innerHTML = to_locale_string(rs_seed_eff);

					// Draw table
					production_efficiency_report_table.draw();

					// Display table
					document.getElementById('production_efficiency_report_table').style.display = "table";

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

		if (station && year && sem) {
			// Create form
			let form = document.createElement('form')
			form.method = 'POST'
			form.action = "{{route('production_efficiency.exportToPDF')}}"
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

			form.appendChild(tokenField)
			form.appendChild(stationField)
			form.appendChild(yearField)
			form.appendChild(semField)

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

		if (station && year && sem) {
			// Create form
			let form = document.createElement('form')
			form.method = 'POST'
			form.action = "{{route('production_efficiency_report.export')}}"

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

			form.appendChild(tokenField)
			form.appendChild(stationField)
			form.appendChild(yearField)
			form.appendChild(semField)

			// Append form to DOM
			document.body.appendChild(form)

			// Submit form
			form.submit()
		}
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