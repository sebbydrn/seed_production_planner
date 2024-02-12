<script>
	let nutrientManagementTable

	$(document).ready(function() {
		// Nutrient Management Datatable
		nutrientManagementTable = $('#nutrientManagementTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('nutrient_management.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'production_plot_code', name: 'production_plot_code', width: '25%'},
				{data: 'datetime_start', name: 'datetime_start', width: '25%'},
				{data: 'datetime_end', name: 'datetime_end', width: '25%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '25%'}
			],
			order: [[0, 'asc']]
		})
	})
</script>