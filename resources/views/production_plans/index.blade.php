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
	<h2>Production Plans</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('production_plans.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Production Plans</span></li>
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
				Production Plans

				@if(Entrust::can('add_seed_production_plan'))
					<!-- Add button -->
					<a href="{{route('production_plans.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-plus"></i> Add New Production Plan</a>
				@endif

				<!-- Remove filter button-->
				<button type="button" class="btn btn-primary" id="removeFilter" onclick="removeFilter()" style="display: none;"><i class="fa fa-ban"></i> Remove Filter</button>
			</h2>
		</header>
		<div class="panel-body">
			<!-- Sort buttons -->
			{{-- <button type="button" class="mb-lg mt-xs mr-xs btn btn-success" onclick="filterTable(1)"><i class="fa fa-filter"></i> Only Show Finalized Plans</button>
			<button type="button" class="mb-lg mt-xs mr-xs btn btn-warning" onclick="filterTable(0)"><i class="fa fa-filter"></i> Only Show Pending Plans</button> --}}

			{{-- <div class="row">
				<div class="col-md-3 mb-lg">
					<label>Year:</label>
					<select data-plugin-selectTwo name="year_filter" id="year_filter" class="form-control" data-plugin-options='{ "placeholder": "Select Year"}' onchange="filterTableByYearSem()">
						<option value="" selected disabled></option>
						@foreach ($years as $year)
							<option value="{{$year->year}}">{{$year->year}}</option>
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
			</div> --}}

			<div class="row" style="margin-top: 10px; margin-bottom: 10px; display: none;" id="area_summaries">
				<div class="col-md-3">
					<section class="panel" style="border: 1px solid #e9ecef;">
						<div class="panel-body">
							<div class="small-chart pull-right"></div>
							<div class="h2 text-bold mb-none mt-none text-center text-primary" id="planned_area_value">488</div>
							<p class="text-md text-muted mb-none text-center">Total Area Planned (ha)</p>
						</div>
					</section>
				</div>
				<div class="col-md-3">
					<section class="panel" style="border: 1px solid #e9ecef;">
						<div class="panel-body">
							<div class="small-chart pull-right"></div>
							<div class="h2 text-bold mb-none mt-none text-center text-success" id="planted_area_value">488</div>
							<p class="text-md text-muted mb-none text-center">Total Area Planted (ha)</p>
						</div>
					</section>
				</div>
			</div>

			<table class="table table-bordered" id="productionPlansTable" style="width: 100%;">
				<thead>
					<tr>
						<th class="text-center">Production <br> Plot Code</th>
						<th class="text-center">Year & Sem</th>
						<th class="text-center">Variety</th>
						<th class="text-center">Seed Class Planted</th>
						<th class="text-center">Plots Used in Plan</th>
						<th class="text-center">Planned Plots Area (ha)</th>
						<th class="text-center">Status</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</section>

	@include('production_plans.modals.viewPlots')
@endsection

@push('scripts')
	@include('production_plans.js.datatable')
	@include('production_plans.js.modals')
	@include('production_plans.js.filterTable')
	@include('production_plans.js.deleteProductionPlan')
	@include('production_plans.js.discontinue_production_plan')
@endpush