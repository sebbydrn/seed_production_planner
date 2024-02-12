@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Nutrient Management</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('nutrient_management.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>SeedTrace Geotag Forms</span></li>
			<li><span>Nutrient Management</span></li>
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
				Nutrient Management

				@if(Entrust::can('add_seedtrace_geotag_form'))
					<!-- Add button -->
					<a href="{{route('nutrient_management.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-pencil"></i> Fill-up Nutrient Management Form</a>	
				@endif
			</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered" id="nutrientManagementTable">
				<thead>
					<tr>
						<th>Production Plot Code</th>
						<th>Date & Time Start</th>
						<th>Date & Time End</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</section>

	@include('seed_trace_geotag.nutrient_management.modals.viewForm')
@endsection

@push('scripts')
	@include('seed_trace_geotag.nutrient_management.js.datatable')
	@include('seed_trace_geotag.nutrient_management.js.modals')
@endpush