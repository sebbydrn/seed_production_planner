<script type="text/javascript">
	let plotsTable

	$(document).ready(function() {
		// Plots Datatable
		plotsTable = $('#plotsTable').DataTable({
			dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (actions)
                    }
                }
            ],
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('plots.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'name', name: 'name', width: '25%'},
				{data: 'farmer', name: 'farmer', width: '25%'},
				{data: 'area', name: 'area', width: '20%'},
				{data: 'status', name: 'status', orderable: false, searchable: false, width: '10%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
			],
			order: [[0, 'asc']]
		})

		// Multiple row select
		$('#plotsTable tbody').on('click', 'tr', function() {
			$(this).toggleClass('dark')
		})
	})
</script>