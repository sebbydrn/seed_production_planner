<script>
	var production_cost_schedule_table

	$(document).ready(function() {
		// Production cost schedule table
		production_cost_schedule_table = $('#production_cost_schedule_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('production_cost_schedule.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'station', name: 'station', width: '30%', orderable: false},
				{data: 'year', name: 'year', width: '15%', orderable: false, className: 'text-center'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '20%', className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '25%', className: 'text-center'}
			]
		})
	})
</script>