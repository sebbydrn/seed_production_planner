<script type="text/javascript">
	let personnelTable

	$(document).ready(function() {
		// Personnel Datatable
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

		// Multiple row select
		$('#personnelTable tbody').on('click', 'tr', function() {
			$(this).toggleClass('dark')
		})
	})
</script>