@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}

		/* Dates */
		.dayofmonth {
		  width: 40px;
		  font-size: 36px;
		  line-height: 36px;
		  float: left;
		  text-align: right;
		  margin-right: 10px; 
		}
		
		.shortdate {
		  font-size: 0.75em; 
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Activities Viewer</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('seed_production_activities.activities_viewer')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Activities Viewer</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<div class="row">
		<div class="col-md-4">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Seed Production Activities Viewer</h2>
				</header>
				<div class="panel-body">
					@if(Entrust::can('view_all_planting_plans'))
						<!-- start: station input -->
						<div class="form-group">
							<label class="control-label">PhilRice Station</label>
							<select name="station" id="station" class="form-control mb-md">
								<option selected disabled>Select Station</option>
								<option value="0">All PhilRice Branch and Satellite Stations</option>
								@foreach($stations as $station)
									<option value="{{$station->philrice_station_id}}">{{$station->name}}</option>
								@endforeach
							</select>
						</div>
						<!-- end: station input -->
					@else
						<input type="hidden" name="station" id="station" value="{{$philriceStationID}}">
					@endif

					<!-- start: year input -->
					<div class="form-group">
						<label class="control-label">Year</label>
						<select name="year" id="year" class="form-control mb-md">
							<option selected disabled>Select Year</option>
							@foreach($years as $year)
								<option value="{{$year->year}}">{{$year->year}}</option>
							@endforeach
						</select>
					</div>
					<!-- end: year input -->

					<!-- start: semester input -->
					<div class="form-group">
						<label class="control-label">Semester</label>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem1" value="1">
								1st Semester (Sept 16-Mar 15)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem2" value="2">
								2nd Semester (Mar 16-Sept 15)
							</label>
						</div>
					</div>
					<!-- end: semester input -->
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary" onclick="show_seed_prod_ax()"><i class="fa fa-refresh"></i> Show Seed Production Activities</button>
						</div>
					</div>
				</footer>
			</section>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Seed Production Activities</h2>
				</header>
				<div class="panel-body" style="min-height: 700px;">
					<table class="table table-bordered " id="seed_production_activities" style="display: none; width: 100%;">
						<thead>
							<tr class="success">
								<th class="text-center" style="width: 10%;">Date</th>
								<th class="text-center" style="width: 15%;">Variety</th>
								<th class="text-center" style="width: 15%;">Seed Class Planted</th>
								<th class="text-center" colspan="2" style="width: 40%;">Activity</th>
								<th class="text-center" style="width: 10%;">Station</th>
								<th class="text-center" style="width: 10%;"></th>
							</tr>
						</thead>
						<tbody id="tbody_activities">
							
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>

	@include('seed_production_activities.modals.view_map')
@endsection

@push('scripts')
	@include('seed_production_activities.js.activity_viewer')
@endpush