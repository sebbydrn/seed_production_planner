<script>
	let activitiesTable

	$(document).ready(function() {
		// Activities Datatable
		activitiesTable = $('#activitiesTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('activities.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'name', name: 'name', width: '50%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '50%'}
			],
			order: [[0, 'asc']]
		})
	})
</script>