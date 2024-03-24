@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Farmers</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('farmers.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Farmers</span></li>
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
				Farmers

                <!-- Add button -->
                <a href="{{route('farmers.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-plus"></i> Add Farmer</a>
			
				<!-- Remove filter button -->
				<button type="button" class="btn btn-primary" id="removeFilter" onclick="removeFilter()" style="display: none;"><i class="fa fa-ban"></i> Remove Filter</button>
			</h2>
		</header>
		<div class="panel-body">
			<!-- Sort buttons -->
			{{-- <button type="button" class="mb-lg mt-xs mr-xs btn btn-success" onclick="filterTable(1)"><i class="fa fa-filter"></i> Only Show Active Farmers</button> --}}
			{{-- <button type="button" class="mb-lg mt-xs mr-xs btn btn-danger" onclick="filterTable(0)"><i class="fa fa-filter"></i> Only Show Deactivated Farmers</button> --}}
			
			<!-- Multiple rows action buttons -->
			{{-- <button type="button" class="mb-lg mt-xs mr-xs btn btn-success" onclick="updateSelectedRowsStatus(1)"><i class="fa fa-check-circle"></i> Activate Selected Rows</button> --}}
			{{-- <button type="button" class="mb-lg mt-xs mr-xs btn btn-danger" onclick="updateSelectedRowsStatus(0)"><i class="fa fa-ban"></i> Deactivate Selected Rows</button> --}}

			<table class="table table-bordered" id="farmers_table">
				<thead>
					<tr>
						<th>RSBSA No.</th>
						<th>Name</th>
                        <th>Barangay</th>
                        <th>Sex</th>
						<th>Area (ha)</th>
						<th>Status</th>
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
	@include('farmers.js.datatable')
@endpush