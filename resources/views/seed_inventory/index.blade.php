@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Seed Inventory</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('seed_inventory.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Seed Inventory</span></li>
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
				Seed Inventory
				
				<a href="{{route('seed_inventory.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-plus"></i> Add Inventory</a>
			</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered" id="seed_inventory_table">
				<thead>
					<tr>
						<th>Variety</th>
						<th>Seed Type</th>
						<th>Quantity</th>
						<th>Date Created</th>
						<th>Date Updated</th>
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
            $('#seed_inventory_table').DataTable({
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
                    url: "{{route('seed_inventory.datatable')}}",
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                },
                columns: [
                    {data: 'variety', name: 'variety'},
                    {data: 'seed_type', name: 'seed_type'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'date_created', name: 'date_created'},
                    {data: 'date_updated', name: 'date_updated'},
                ]
            });
        })
    </script>
@endpush