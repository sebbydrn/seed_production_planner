<script>
	let landPreparationTable

	$(document).ready(function() {
		// Land Preparation Datatable
		landPreparationTable = $('#landPreparationTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('land_preparation.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'production_plot_code', name: 'production_plot_code', width: '15%'},
				{data: 'crop_phase', name: 'crop_phase', width: '15%'},
				{data: 'activity', name: 'activity', width: '15%'},
				{data: 'datetime_start', name: 'datetime_start', width: '15%'},
				{data: 'datetime_end', name: 'datetime_end', width: '15%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '25%'}
			],
			order: [[0, 'asc']]
		})
	})
</script>