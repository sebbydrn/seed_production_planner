@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Land Preparation</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('land_preparation.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>SeedTrace Geotag Forms</span></li>
			<li><span>Land Preparation</span></li>
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
				Land Preparation

				@if(Entrust::can('add_seedtrace_geotag_form'))
					<!-- Add button -->
					<a href="{{route('land_preparation.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-pencil"></i> Fill-up Land Preparation Form</a>
				@endif
			</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered" id="landPreparationTable">
				<thead>
					<tr>
						<th>Production Plot Code</th>
						<th>Cropping Phase</th>
						<th>Activity</th>
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

	@include('seed_trace_geotag.land_preparation.modals.viewForm')
@endsection

@push('scripts')
	@include('seed_trace_geotag.land_preparation.js.datatable')
	@include('seed_trace_geotag.land_preparation.js.modals')
@endpush