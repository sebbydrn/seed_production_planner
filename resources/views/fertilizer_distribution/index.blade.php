@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Fertilizer Distribution</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('fertilizer_distribution.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Fertilizer Distribution</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
				<a href="#" class="fa fa-times"></a>
			</div>

			<h2 class="panel-title">
				Fertilizer Distribution List
				
				<a href="{{route('fertilizer_distribution.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-plus"></i> Fertilizer Distribution Form</a>
			</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered" id="fertilizer_distribution_table">
				<thead>
					<tr>
						<th>Name</th>
						<th>RSBSA ID No.</th>
						<th>Year</th>
						<th>Sem</th>
						<th>Fertilizer</th>
						<th>Quantity (bags)</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</section>
@endsection

@push('scripts')
	<script>
        $(document).ready(function() {
            $('#fertilizer_distribution_table').DataTable({
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
                    url: "{{route('fertilizer_distribution.datatable')}}",
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'rsbsa_no', name: 'rsbsa_no'},
                    {data: 'year', name: 'year'},
                    {data: 'sem', name: 'sem'},
                    {data: 'fertilizer', name: 'fertilizer'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'actions', name: 'actions'}
                ]
            })

            // Delete
            $(document).on('click', '.delete', function(e) {
                e.preventDefault()

                var id = $(this).attr('id')

                // javascript confirm box for confirmation
                if (confirm("Are you sure you want to delete this?")) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('fertilizer_distribution.delete')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            fertilizer_distribution_list_id: id
                        },
                        success: function(response) {
                            // check if response has success status
                            if (response.status == 'success') {
                                // reload datatables
                                $('#fertilizer_distribution_table').DataTable().ajax.reload()
                            }
                        }
                    });
                }
            })
        })
    </script>
@endpush