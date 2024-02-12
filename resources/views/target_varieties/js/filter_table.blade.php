<script>
	function filterTableByStation() {
		var year_filter = document.getElementById('year_filter').value
		var sem_filter = document.getElementById('sem_filter').value
		var philriceStation = document.getElementById('philriceStation')

		// Destroy target varieties DataTable
		if ($.fn.DataTable.isDataTable('#target_varieties_tbl')) {
			$('#target_varieties_tbl').DataTable().destroy()
		}

		// Empty target varieties tbody
		$('#target_varieties_tbl tbody').empty()

		// Target Varieties Datatable
		target_varieties_tbl = $('#target_varieties_tbl').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('target_varieties.datatable')}}",
				data: {
					_token: "{{csrf_token()}}",
					year_filter: year_filter,
					sem_filter: sem_filter,
					philriceStation: (philriceStation) ? philriceStation.value : null
				}
			},
			columns: [
				{data: 'station', name: 'station', width: '9%', className: 'text-center', orderable: false},
				{data: 'year_sem', name: 'year_sem', width: '9%', orderable: false, className: 'text-center'},
				{data: 'variety', name: 'variety', width: '13%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '13%', orderable: false, className: 'text-center'},
				{data: 'area', name: 'area', orderable: false, searchable: false, width: '15%', className: 'text-right'},
				{data: 'area_inputted', name: 'area_inputted', orderable: false, searchable: false, width: '15%', className: 'text-right'},
				{data: 'progress', name: 'progress', orderable: false, searchable: false, width: '15%', className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
			]
		})

		// Show the remove filter button
		document.getElementById('removeFilter').style.display = 'inline-block'
	}

	function filterTableByYearSem() {
		var year_filter = document.getElementById('year_filter').value
		var sem_filter = document.getElementById('sem_filter').value
		var philriceStation = document.getElementById('philriceStation')

		if (year_filter != "" && sem_filter != "") {
			// Destroy target varieties DataTable
			if ($.fn.DataTable.isDataTable('#target_varieties_tbl')) {
				$('#target_varieties_tbl').DataTable().destroy()
			}

			// Empty target varieties tbody
			$('#target_varieties_tbl tbody').empty()

			// Target Varieties Datatable
			target_varieties_tbl = $('#target_varieties_tbl').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('target_varieties.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						year_filter: year_filter,
						sem_filter: sem_filter,
						philriceStation: (philriceStation) ? philriceStation.value : null
					}
				},
				columns: [
					{data: 'station', name: 'station', width: '9%', className: 'text-center', orderable: false},
					{data: 'year_sem', name: 'year_sem', width: '9%', orderable: false, className: 'text-center'},
					{data: 'variety', name: 'variety', width: '13%', orderable: false, className: 'text-center'},
					{data: 'seed_class', name: 'seed_class', width: '13%', orderable: false, className: 'text-center'},
					{data: 'area', name: 'area', orderable: false, searchable: false, width: '15%', className: 'text-right'},
					{data: 'area_inputted', name: 'area_inputted', orderable: false, searchable: false, width: '15%', className: 'text-right'},
					{data: 'progress', name: 'progress', orderable: false, searchable: false, width: '15%', className: 'text-center'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
				]
			})
		}

		// Show the remove filter button
		document.getElementById('removeFilter').style.display = 'inline-block'
	}

	function removeFilter() {
		var philriceStation = document.getElementById('philriceStation')

		// Destroy target varieties DataTable
		if ($.fn.DataTable.isDataTable('#target_varieties_tbl')) {
			$('#target_varieties_tbl').DataTable().destroy()
		}

		// Empty target varieties tbody
		$('#target_varieties_tbl tbody').empty()

		// Target varieties table
		target_varieties_table = $('#target_varieties_tbl').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('target_varieties.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'station', name: 'station', width: '9%', className: 'text-center', orderable: false},
				{data: 'year_sem', name: 'year_sem', width: '9%', orderable: false, className: 'text-center'},
				{data: 'variety', name: 'variety', width: '13%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '13%', orderable: false, className: 'text-center'},
				{data: 'area', name: 'area', orderable: false, searchable: false, width: '15%', className: 'text-right'},
				{data: 'area_inputted', name: 'area_inputted', orderable: false, searchable: false, width: '15%', className: 'text-right'},
				{data: 'progress', name: 'progress', orderable: false, searchable: false, width: '15%', className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
			]
		})
	
		// Hide the remove filter button
		document.getElementById('removeFilter').style.display = 'none'

		// Remove selected options in dropdowns
		$('#year_filter').select2('destroy').val('')
		$('#year_filter').select2({placeholder: "Select Year"})

		$('#sem_filter').select2('destroy').val('')
		$('#sem_filter').select2({placeholder: "Select Sem"})

		if (philriceStation) {
			$('#philriceStation').select2('destroy').val('')
			$('#philriceStation').select2({placeholder: "Select PhilRice Station"})
		}
	}
</script>