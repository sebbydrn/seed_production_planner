<script type="text/javascript">
	let farmers_table

	$(document).ready(function() {
		// Farmers Datatable
		farmers_table = $('#farmers_table').DataTable({
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

        $('#filter').submit(function(e) {
            e.preventDefault()

            let barangay = $('#barangay').val()
            let sex = $('#sex').val()

            if ($.fn.DataTable.isDataTable('#farmers_table')) {
                $('#farmers_table').DataTable().destroy()
            }

            $('#farmers_table tbody').empty()

            farmers_table = $('#farmers_table').DataTable({
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
                    url: "{{route('farmers.datatable')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        barangay: barangay,
                        sex: sex
                    },
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
        })
	})
</script>