<script>
	function filterTable(status) {
		let philriceStation = document.getElementById('philriceStation')

		// Destroy personnel DataTable
		if ($.fn.DataTable.isDataTable('#personnelTable')) {
			$('#personnelTable').DataTable().destroy()
		}

		// Empty personnel tbody
		$('#personnelTable tbody').empty()

		// Personnel Datatable
		if (philriceStation) {
			personnelTable = $('#personnelTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('personnel.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						is_active: status,
						philriceStation: philriceStation.value
					}
				},
				columns: [
					{data: 'emp_idno', name: 'emp_idno', width: '10%'},
					{data: 'last_name', name: 'last_name', width: '15%'},
					{data: 'first_name', name: 'first_name', width: '15%'},
					{data: 'role', name: 'role', width: '15%'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
					{data: 'station', name: 'station', width: '15%'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
				],
				order: [[0, 'asc']]
			})
		} else {
			personnelTable = $('#personnelTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('personnel.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						is_active: status
					}
				},
				columns: [
					{data: 'emp_idno', name: 'emp_idno', width: '10%'},
					{data: 'last_name', name: 'last_name', width: '15%'},
					{data: 'first_name', name: 'first_name', width: '15%'},
					{data: 'role', name: 'role', width: '15%'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
					{data: 'station', name: 'station', width: '15%'},
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

		// Destroy personnel DataTable
		if ($.fn.DataTable.isDataTable('#personnelTable')) {
			$('#personnelTable').DataTable().destroy()
		}

		// Empty personnel tbody
		$('#personnelTable tbody').empty()

		if (philriceStation) {
			personnelTable = $('#personnelTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('personnel.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						philriceStation: philriceStation.value
					}
				},
				columns: [
					{data: 'emp_idno', name: 'emp_idno', width: '10%'},
					{data: 'last_name', name: 'last_name', width: '15%'},
					{data: 'first_name', name: 'first_name', width: '15%'},
					{data: 'role', name: 'role', width: '15%'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
					{data: 'station', name: 'station', width: '15%'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
				],
				order: [[0, 'asc']]
			})
		} else {
			personnelTable = $('#personnelTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('personnel.datatable')}}",
					data: {
						_token: "{{csrf_token()}}"
					}
				},
				columns: [
					{data: 'emp_idno', name: 'emp_idno', width: '10%'},
					{data: 'last_name', name: 'last_name', width: '15%'},
					{data: 'first_name', name: 'first_name', width: '15%'},
					{data: 'role', name: 'role', width: '15%'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
					{data: 'station', name: 'station', width: '15%'},
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

		// Destroy personnel DataTable
		if ($.fn.DataTable.isDataTable('#personnelTable')) {
			$('#personnelTable').DataTable().destroy()
		}

		// Empty personnel tbody
		$('#personnelTable tbody').empty()

		// Personnel Datatable
		personnelTable = $('#personnelTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('personnel.datatable')}}",
				data: {
					_token: "{{csrf_token()}}",
					philriceStation: philriceStation
				}
			},
			columns: [
				{data: 'emp_idno', name: 'emp_idno', width: '10%'},
				{data: 'last_name', name: 'last_name', width: '15%'},
				{data: 'first_name', name: 'first_name', width: '15%'},
				{data: 'role', name: 'role', width: '15%'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
				{data: 'station', name: 'station', width: '15%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
			],
			order: [[0, 'asc']]
		})
	}
</script>