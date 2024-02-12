<script>
	let target_varieties_table

	$(document).ready(function() {
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
	})
</script>