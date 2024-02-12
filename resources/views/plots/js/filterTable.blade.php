<script>
	function filterTable(status) {
		let philriceStation = document.getElementById('philriceStation')

		// Destroy plots DataTable
		if ($.fn.DataTable.isDataTable('#plotsTable')) {
			$('#plotsTable').DataTable().destroy()
		}

		// Empty plots tbody
		$('#plotsTable tbody').empty()

		if (philriceStation) {
			// Plots Datatable
			plotsTable = $('#plotsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('plots.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						is_active: status,
						philriceStation: philriceStation.value
					}
				},
				columns: [
					{data: 'name', name: 'name', width: '25%'},
					{data: 'area', name: 'area', width: '25%'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
					{data: 'station', name: 'station', width: '20%'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
				],
				order: [[1, 'desc'], [2, 'desc']]
			})
		} else {
			// Plots Datatable
			plotsTable = $('#plotsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('plots.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						is_active: status
					}
				},
				columns: [
					{data: 'name', name: 'name', width: '25%'},
					{data: 'area', name: 'area', width: '25%'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
					{data: 'station', name: 'station', width: '20%'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
				],
				order: [[0, 'asc']]
			})
		}

		// Show the remove filter button
		document.getElementById('removeFilter').style.display = 'inline-block'
	}

	function removeFilter() {
		let philriceStation = document.getElementById('philriceStation')

		// Destroy plots DataTable
		if ($.fn.DataTable.isDataTable('#plotsTable')) {
			$('#plotsTable').DataTable().destroy()
		}

		// Empty plots tbody
		$('#plotsTable tbody').empty()

		if (philriceStation) {
			// Plots Datatable
			plotsTable = $('#plotsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('plots.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						philriceStation: philriceStation.value
					}
				},
				columns: [
					{data: 'name', name: 'name', width: '25%'},
					{data: 'area', name: 'area', width: '25%'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
					{data: 'station', name: 'station', width: '20%'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
				],
				order: [[1, 'desc'], [2, 'desc']]
			})
		} else {
			// Plots Datatable
			plotsTable = $('#plotsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('plots.datatable')}}",
					data: {
						_token: "{{csrf_token()}}"
					}
				},
				columns: [
					{data: 'name', name: 'name', width: '25%'},
					{data: 'area', name: 'area', width: '25%'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
					{data: 'station', name: 'station', width: '20%'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
				],
				order: [[0, 'asc']]
			})
		}

		// Hide the remove filter button
		document.getElementById('removeFilter').style.display = 'none'
	}

	function filterTableByStation() {
		let philriceStation = document.getElementById('philriceStation').value

		// Destroy plots DataTable
		if ($.fn.DataTable.isDataTable('#plotsTable')) {
			$('#plotsTable').DataTable().destroy()
		}

		// Empty plots tbody
		$('#plotsTable tbody').empty()

		// Plots Datatable
		plotsTable = $('#plotsTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('plots.datatable')}}",
				data: {
					_token: "{{csrf_token()}}",
					philriceStation: philriceStation
				}
			},
			columns: [
				{data: 'name', name: 'name', width: '25%'},
				{data: 'area', name: 'area', width: '25%'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
				{data: 'station', name: 'station', width: '20%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
			],
			order: [[1, 'desc'], [2, 'desc']]
		})
	}
</script>