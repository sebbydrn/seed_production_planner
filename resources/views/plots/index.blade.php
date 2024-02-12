@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Plots</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('plots.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Plots</span></li>
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
				Plots

				@if(Entrust::can('add_plots'))
					<!-- Add button -->
					<a href="{{route('plots.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-plus"></i> Add New Plot</a>
				@endif

				<!-- Remove filter button -->
				<button type="button" class="btn btn-primary" id="removeFilter" onclick="removeFilter()" style="display: none;"><i class="fa fa-ban"></i> Remove Filter</button>
			</h2>
		</header>
		<div class="panel-body">
			<!-- View all active plots -->
			<a href="{{route('plots.view_all_plots')}}" class="mb-lg mt-xs mr-xs btn btn-info"><i class="fa fa-map-marker"></i> View All Active Lots in Map</a>

			<!-- Sort buttons -->
			<button type="button" class="mb-lg mt-xs mr-xs btn btn-success" onclick="filterTable(1)"><i class="fa fa-filter"></i> Only Show Active Lots</button>
			<button type="button" class="mb-lg mt-xs mr-xs btn btn-danger" onclick="filterTable(0)"><i class="fa fa-filter"></i> Only Show Deactivated Lots</button>
			
			@if(Entrust::can('update_plot_status'))
				<!-- Multiple rows action buttons -->
				<button type="button" class="mb-lg mt-xs mr-xs btn btn-success" onclick="updateSelectedRowsStatus(1)"><i class="fa fa-check-circle"></i> Activate Selected Rows</button>
				<button type="button" class="mb-lg mt-xs mr-xs btn btn-danger" onclick="updateSelectedRowsStatus(0)"><i class="fa fa-ban"></i> Deactivate Selected Rows</button>
			@endif

			<table class="table table-bordered" id="plotsTable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Farmer</th>
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

	@include('plots.modals.viewPlot')
@endsection

@push('scripts')
	@include('plots.js.datatable')
	@include('plots.js.modals')
	@include('plots.js.updateStatus')
	@include('plots.js.filterTable')
@endpush