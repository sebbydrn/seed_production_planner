@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Personnel</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('personnel.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Personnel</span></li>
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
				Personnel
				
				@if(Entrust::can('add_personnel'))
					<!-- Add button -->
					<a href="{{route('personnel.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-plus"></i> Add New Personnel</a>
				@endif

				<!-- Remove filter button -->
				<button type="button" class="btn btn-primary" id="removeFilter" onclick="removeFilter()" style="display: none;"><i class="fa fa-ban"></i> Remove Filter</button>
			</h2>
		</header>
		<div class="panel-body">
			<!-- Sort buttons -->
			<button type="button" class="mb-lg mt-xs mr-xs btn btn-success" onclick="filterTable(1)"><i class="fa fa-filter"></i> Only Show Active Personnel</button>
			<button type="button" class="mb-lg mt-xs mr-xs btn btn-danger" onclick="filterTable(0)"><i class="fa fa-filter"></i> Only Show Deactivated Personnel</button>

			@if(Entrust::can('update_personnel_status'))
				<!-- Multiple rows action buttons -->
				<button type="button" class="mb-lg mt-xs mr-xs btn btn-success" onclick="updateSelectedRowsStatus(1)"><i class="fa fa-check-circle"></i> Activate Selected Rows</button>
				<button type="button" class="mb-lg mt-xs mr-xs btn btn-danger" onclick="updateSelectedRowsStatus(0)"><i class="fa fa-ban"></i> Deactivate Selected Rows</button>
			@endif

			@if(Entrust::can('view_all_personnel'))
				<div class="row">
					<div class="col-md-4 mb-lg">
						<label>Filter Table by PhilRice Station:</label>
						<select name="philriceStation" id="philriceStation" class="form-control" onchange="filterTableByStation()">
							<option value="1" selected disabled>Select PhilRice Station</option>
							<option value="1">All Stations</option>
							@foreach ($philriceStations as $station)
								<option value="{{$station->philrice_station_id}}">{{$station->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			@endif

			<table class="table table-bordered" id="personnelTable">
				<thead>
					<tr>
						<th>Emp ID No.</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Role</th>
						<th>Status</th>
						<th>Station</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</section>

	@include('personnel.modals.viewPersonnel')
@endsection

@push('scripts')
	@include('personnel.js.datatable')
	@include('personnel.js.modals')
	@include('personnel.js.updateStatus')
	@include('personnel.js.filterTable')
	@include('personnel.js.deletePersonnel')
@endpush