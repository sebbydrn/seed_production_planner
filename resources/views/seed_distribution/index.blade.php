@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Seed Distribution</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('seed_distribution.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Seed Distribution</span></li>
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
				Seed Distribution List
				
				<a href="{{route('seed_distribution.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-plus"></i> Seed Distribution Form</a>
			</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered" id="seed_distribution_table">
				<thead>
					<tr>
						<th>Name</th>
						<th>RSBSA ID No.</th>
						<th>Year</th>
						<th>Sem</th>
						<th>Variety</th>
						<th>Area</th>
						<th>Quantity</th>
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
            $('#seed_distribution_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    type: 'POST',
                    url: "{{route('seed_distribution.datatable')}}",
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'rsbsa_no', name: 'rsbsa_no'},
                    {data: 'year', name: 'year'},
                    {data: 'sem', name: 'sem'},
                    {data: 'variety', name: 'variety'},
                    {data: 'area', name: 'area'},
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
                        url: "{{route('seed_distribution.delete')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            seed_distribution_list_id: id
                        },
                        success: function(response) {
                            // check if response has success status
                            if (response.status == 'success') {
                                // reload datatables
                                $('#seed_distribution_table').DataTable().ajax.reload()
                            }
                        }
                    });
                }
            })
        })
    </script>
@endpush