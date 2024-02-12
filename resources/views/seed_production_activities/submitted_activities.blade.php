@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Seed Production App Data</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('seed_production_activities.submitted_activities')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Seed Production App Data</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Submitted Activities from Seed Production App</h2>
				</header>
				<div class="panel-body">
					<div class="row">
						@if(Entrust::can('view_all_seed_production_plans'))
						<div class="col-md-3 mb-lg">
							<select data-plugin-selectTwo name="philriceStation" id="philriceStation" class="form-control" data-plugin-options='{ "placeholder": "Filter by branch station"}' onchange="filterTableByStation()">
								<option value="" selected disabled></option>
								<option value="1">All Stations</option>
								@foreach ($stations as $station)
									<option value="{{$station->philrice_station_id}}">{{$station->name}}</option>
								@endforeach
							</select>
						</div>
						@endif

						<div class="col-md-2 mb-lg">
							<select data-plugin-selectTwo name="year_filter" id="year_filter" class="form-control" data-plugin-options='{ "placeholder": "Filter by year"}' onchange="filterTableByYearSem()">
								<option value="" selected disabled></option>
								@foreach ($years as $year)
									<option value="{{$year->year}}">{{$year->year}}</option>
								@endforeach
							</select>
						</div>

						<div class="col-md-2 mb-lg">
							<select data-plugin-selectTwo name="sem_filter" id="sem_filter" class="form-control" data-plugin-options='{ "placeholder": "Filter by sem"}' onchange="filterTableByYearSem()">
								<option value="" selected disabled></option>
								<option value="1">1st Semester (Sept 16-Mar 15)</option>
								<option value="2">2nd Semester (Mar 16-Sept 15)</option>
							</select>
						</div>

						<div class="col-md-2 mb-lg">
							<!-- Remove filter button-->
							<button type="button" class="btn btn-primary" id="removeFilter" onclick="removeFilter()" style="display: none;"><i class="fa fa-ban"></i> Remove Filter</button>
						</div>
					</div>

					<table class="table table-bordered " id="submitted_activities" style="width: 100%;">
						<thead>
							<tr>
								<th class="text-center" style="width: 10%;">Date</th>
								<th class="text-center" style="width: 15%;">Variety</th>
								<th class="text-center" style="width: 15%;">Seed Class Planted</th>
								<th class="text-center" style="width: 30%;">Activity</th>
								<th class="text-center" style="width: 10%;">Station</th>
								<th class="text-center" style="width: 20%;">Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>

	@include('seed_production_activities.modals.land_preparation')
	@include('seed_production_activities.modals.seedling_management')
	@include('seed_production_activities.modals.crop_establishment')
	@include('seed_production_activities.modals.water_management')
	@include('seed_production_activities.modals.nutrient_management')
	@include('seed_production_activities.modals.roguing')
	@include('seed_production_activities.modals.pest_management')
	@include('seed_production_activities.modals.harvesting')
	@include('seed_production_activities.modals.field_map')
@endsection

@push('scripts')
	@include('seed_production_activities.js.datatable')
	@include('seed_production_activities.js.view_activity_data')
@endpush