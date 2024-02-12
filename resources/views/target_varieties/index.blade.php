@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}

		.badge_primary {
			background-color: #0088cc;
		}

		.badge_success {
			background-color: #47a447;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Target Varieties</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('production_plans.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Target Varieties</span></li>
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
				Target Varieties
			</h2>
		</header>
		<div class="panel-body">
			<div class="row" style="margin-bottom: 30px; margin-top: 10px;">
				<div class="col-md-12">
					{{-- @if(Entrust::can('add_seed_production_plan')) --}}
						<!-- Add button -->
						<button class="btn btn-success" onclick="show_add_target_variety()"><i class="fa fa-plus"></i> Add Target Variety To Be Planted</button>
					{{-- @endif --}}					
				</div>
			</div>

			<div class="row">
				@if(Entrust::can('view_all_seed_production_plans'))
				<div class="col-md-4 mb-lg">
					<label>Filter Table by PhilRice Station:</label>
					<select data-plugin-selectTwo name="philriceStation" id="philriceStation" class="form-control" data-plugin-options='{ "placeholder": "Select PhilRice Station"}' onchange="filterTableByStation()">
						<option value="" selected disabled></option>
						<option value="1">All Stations</option>
						@foreach ($philriceStations as $station)
							<option value="{{$station->philrice_station_id}}">{{$station->name}}</option>
						@endforeach
					</select>
				</div>
				@endif

				<div class="col-md-3 mb-lg">
					<label>Year:</label>
					<select data-plugin-selectTwo name="year_filter" id="year_filter" class="form-control" data-plugin-options='{ "placeholder": "Select Year"}' onchange="filterTableByYearSem()">
						<option value="" selected disabled></option>
						@foreach ($years as $year)
							@if($year->year > 2022)
								<option value="{{$year->year}}">{{$year->year}}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="col-md-3 mb-lg">
					<label for="">Sem:</label>
					<select data-plugin-selectTwo name="sem_filter" id="sem_filter" class="form-control" data-plugin-options='{ "placeholder": "Select Sem"}' onchange="filterTableByYearSem()">
						<option value="" selected disabled></option>
						<option value="1">1st Semester (Sept 16-Mar 15)</option>
						<option value="2">2nd Semester (Mar 16-Sept 15)</option>
					</select>
				</div>

				<div class="col-md-2 mb-lg">
					<!-- Remove filter button-->
					<button type="button" class="btn btn-primary mt-xl" id="removeFilter" onclick="removeFilter()" style="display: none;"><i class="fa fa-ban"></i> Remove Filter</button>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered" id="target_varieties_tbl" style="width: 100%;">
						<thead>
							<tr>
								<th class="text-center">Station</th>
								<th class="text-center">Year & Sem</th>
								<th class="text-center">Variety</th>
								<th class="text-center">Seed Class To Be Planted</th>
								<th class="text-center">Target Area To Be Planted (ha)</th>
								<th class="text-center">Area Inputted in Seed Production Planner (ha)</th>
								<th class="text-center">Progress of Area Inputted in Seed Production Planner</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	@include('target_varieties.add_target_modal')
@endsection

@push('scripts')
	@include('target_varieties.js.script')
	@include('target_varieties.js.datatable')
	@include('target_varieties.js.filter_table')
@endpush