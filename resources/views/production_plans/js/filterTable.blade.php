<script>
	function filterTable(status) {
		var year_filter = document.getElementById('year_filter').value
		var sem_filter = document.getElementById('sem_filter').value
		var philriceStation = document.getElementById('philriceStation')

		// Destroy production plans DataTable
		if ($.fn.DataTable.isDataTable('#productionPlansTable')) {
			$('#productionPlansTable').DataTable().destroy()
		}

		// Empty production plans tbody
		$('#productionPlansTable tbody').empty()

		// Production Plans Datatable
		if (philriceStation) {
			productionPlansTable = $('#productionPlansTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('production_plans.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						is_finalized: status,
						year_filter: year_filter,
						sem_filter: sem_filter,
						philriceStation: (philriceStation) ? philriceStation.value : null
					}
				},
				columns: [
				{data: 'station', name: 'station', width: '5%', className: 'text-center', orderable: false},
				{data: 'production_plot_code', name: 'production_plot_code', width: '10%', orderable: false, className: 'text-center'},
				{data: 'year_sem', name: 'year_sem', width: '5%', orderable: false, className: 'text-center'},
				{data: 'variety', name: 'variety', width: '10%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '5%', orderable: false, className: 'text-center'},
				{data: 'seed_production_in_charge', name: 'seed_production_in_charge', orderable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots', name: 'planned_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots_area', name: 'planned_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'actual_plots', name: 'actual_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'actual_plots_area', name: 'actual_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '5%', className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
			]
			})
		} else {
			productionPlansTable = $('#productionPlansTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('production_plans.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						year_filter: year_filter,
						sem_filter: sem_filter,
						is_finalized: status
					}
				},
				columns: [
				{data: 'station', name: 'station', width: '5%', className: 'text-center', orderable: false},
				{data: 'production_plot_code', name: 'production_plot_code', width: '10%', orderable: false, className: 'text-center'},
				{data: 'year_sem', name: 'year_sem', width: '5%', orderable: false, className: 'text-center'},
				{data: 'variety', name: 'variety', width: '10%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '5%', orderable: false, className: 'text-center'},
				{data: 'seed_production_in_charge', name: 'seed_production_in_charge', orderable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots', name: 'planned_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots_area', name: 'planned_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'actual_plots', name: 'actual_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'actual_plots_area', name: 'actual_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '5%', className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
			]
			})
		}

		// Show the remove filter button
		document.getElementById('removeFilter').style.display = 'inline-block'
	}

	function removeFilter() {
		let philriceStation = document.getElementById('philriceStation')

		// Destroy production plans DataTable
		if ($.fn.DataTable.isDataTable('#productionPlansTable')) {
			$('#productionPlansTable').DataTable().destroy()
		}

		// Empty production plans tbody
		$('#productionPlansTable tbody').empty()

		if (philriceStation) {
			// Production Plans Datatable
			productionPlansTable = $('#productionPlansTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('production_plans.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						philriceStation: philriceStation.value
					}
				},
				columns: [
				{data: 'station', name: 'station', width: '5%', className: 'text-center', orderable: false},
				{data: 'production_plot_code', name: 'production_plot_code', width: '10%', orderable: false, className: 'text-center'},
				{data: 'year_sem', name: 'year_sem', width: '5%', orderable: false, className: 'text-center'},
				{data: 'variety', name: 'variety', width: '10%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '5%', orderable: false, className: 'text-center'},
				{data: 'seed_production_in_charge', name: 'seed_production_in_charge', orderable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots', name: 'planned_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots_area', name: 'planned_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'actual_plots', name: 'actual_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'actual_plots_area', name: 'actual_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '5%', className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
			]
			})
		} else {
			// Production Plans Datatable
			productionPlansTable = $('#productionPlansTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('production_plans.datatable')}}",
					data: {
						_token: "{{csrf_token()}}"
					}
				},
				columns: [
				{data: 'station', name: 'station', width: '5%', className: 'text-center', orderable: false},
				{data: 'production_plot_code', name: 'production_plot_code', width: '10%', orderable: false, className: 'text-center'},
				{data: 'year_sem', name: 'year_sem', width: '5%', orderable: false, className: 'text-center'},
				{data: 'variety', name: 'variety', width: '10%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '5%', orderable: false, className: 'text-center'},
				{data: 'seed_production_in_charge', name: 'seed_production_in_charge', orderable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots', name: 'planned_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots_area', name: 'planned_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'actual_plots', name: 'actual_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'actual_plots_area', name: 'actual_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '5%', className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
			]
			})
		}
	
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

		document.getElementById('area_summaries').style.display = "none"
	}

	function filterTableByStation() {
		var year_filter = document.getElementById('year_filter').value
		var sem_filter = document.getElementById('sem_filter').value
		var philriceStation = document.getElementById('philriceStation')

		// Destroy production plans DataTable
		if ($.fn.DataTable.isDataTable('#productionPlansTable')) {
			$('#productionPlansTable').DataTable().destroy()
		}

		// Empty production plans tbody
		$('#productionPlansTable tbody').empty()

		// Production Plans Datatable
		productionPlansTable = $('#productionPlansTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('production_plans.datatable')}}",
				data: {
					_token: "{{csrf_token()}}",
					year_filter: year_filter,
					sem_filter: sem_filter,
					philriceStation: philriceStation
				}
			},
			columns: [
				{data: 'station', name: 'station', width: '5%', className: 'text-center', orderable: false},
				{data: 'production_plot_code', name: 'production_plot_code', width: '10%', orderable: false, className: 'text-center'},
				{data: 'year_sem', name: 'year_sem', width: '5%', orderable: false, className: 'text-center'},
				{data: 'variety', name: 'variety', width: '10%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '5%', orderable: false, className: 'text-center'},
				{data: 'seed_production_in_charge', name: 'seed_production_in_charge', orderable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots', name: 'planned_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'planned_plots_area', name: 'planned_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'actual_plots', name: 'actual_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
				{data: 'actual_plots_area', name: 'actual_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '5%', className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
			]
		})

		showTotalArea()
	}

	function filterTableByYearSem() {
		var year_filter = document.getElementById('year_filter').value
		var sem_filter = document.getElementById('sem_filter').value
		var philriceStation = document.getElementById('philriceStation')

		if (year_filter != "" && sem_filter != "") {
			// Destroy production plans DataTable
			if ($.fn.DataTable.isDataTable('#productionPlansTable')) {
				$('#productionPlansTable').DataTable().destroy()
			}

			// Empty production plans tbody
			$('#productionPlansTable tbody').empty()

			// Production Plans Datatable
			productionPlansTable = $('#productionPlansTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					type: 'POST',
					url: "{{route('production_plans.datatable')}}",
					data: {
						_token: "{{csrf_token()}}",
						year_filter: year_filter,
						sem_filter: sem_filter,
						philriceStation: (philriceStation) ? philriceStation.value : null
					}
				},
				columns: [
					{data: 'station', name: 'station', width: '5%', className: 'text-center', orderable: false},
					{data: 'production_plot_code', name: 'production_plot_code', width: '10%', orderable: false, className: 'text-center'},
					{data: 'year_sem', name: 'year_sem', width: '5%', orderable: false, className: 'text-center'},
					{data: 'variety', name: 'variety', width: '10%', orderable: false, className: 'text-center'},
					{data: 'seed_class', name: 'seed_class', width: '5%', orderable: false, className: 'text-center'},
					{data: 'seed_production_in_charge', name: 'seed_production_in_charge', orderable: false, width: '10%', className: 'text-center'},
					{data: 'planned_plots', name: 'planned_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
					{data: 'planned_plots_area', name: 'planned_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
					{data: 'actual_plots', name: 'actual_plots', orderable: false, searchable: false, width: '10%', className: 'text-center'},
					{data: 'actual_plots_area', name: 'actual_plots_area', orderable: false, searchable: false, width: '10%', className: 'text-right'},
					{data: 'status', name: 'status', orderable: false, searchable: false, width: '5%', className: 'text-center'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '10%', className: 'text-center'}
				]
			})
		}

		showTotalArea()
	}

	function showTotalArea() {
		var year_filter = document.getElementById('year_filter').value
		var sem_filter = document.getElementById('sem_filter').value
		var philriceStation = document.getElementById('philriceStation')

		if (year_filter != "" && sem_filter != "") {
			$.ajax({
				type: 'POST',
				url: "{{route('production_plans.area_summary')}}",
				data: {
					_token: "{{csrf_token()}}",
					year_filter: year_filter,
					sem_filter: sem_filter,
					philriceStation: (philriceStation) ? philriceStation.value : null
				},
				dataType: 'JSON',
				success: (res) => {
					document.getElementById('planned_area_value').innerHTML = (res.planned_area).toFixed(4)
					document.getElementById('planted_area_value').innerHTML = (res.planted_area).toFixed(4)
					document.getElementById('area_summaries').style.display = "block"
				}
			})
		}
	}
</script>