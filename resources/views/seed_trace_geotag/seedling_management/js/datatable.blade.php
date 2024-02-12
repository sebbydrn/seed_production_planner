<script>
	let seedlingManagementTable

	$(document).ready(function() {
		// Seedling Management Datatable
		seedlingManagementTable = $('#seedlingManagementTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('seedling_management.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'production_plot_code', name: 'production_plot_code', width: '20%'},
				{data: 'activity', name: 'activity', width: '20%'},
				{data: 'status', name: 'status', width: '15%'},
				{data: 'timestamp', name: 'timestamp', width: '20%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '25%'}
			],
			order: [[0, 'asc']]
		})
	})
</script>