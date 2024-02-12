<script type="text/javascript">
	let farmers_table

	$(document).ready(function() {
		// Farmers Datatable
		farmers_table = $('#farmers_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('farmers.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'rsbsa_no', name: 'rsbsa_no'},
				{data: 'name', name: 'name'},
				{data: 'barangay', name: 'barangay'},
                {data: 'sex', name: 'sex'},
                {data: 'area', name:'area'},
				{data: 'status', name: 'status', orderable: false, searchable: false},
				{data: 'actions', name: 'actions', orderable: false, searchable: false}
			],
			order: [[0, 'asc']]
		})

		// Multiple row select
		$('#farmers_table tbody').on('click', 'tr', function() {
			$(this).toggleClass('dark')
		})
	})
</script>