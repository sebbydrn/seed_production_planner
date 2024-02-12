@extends('layouts.index')

@push('styles')
	<style>
		#plotMap {
			height: 700px;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Dashboard</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('dashboard.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Dashboard</span></li>
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
				Seed Production Activity Monitoring
			</h2>
		</header>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-3">
					@if(Entrust::can('view_all_planting_plans'))
						<!-- start: station input -->
						<div class="form-group">
							<label class="control-label">PhilRice Station</label>
							<select name="station" id="station" class="form-control mb-md" onchange="stationChange()">
								<option selected disabled>Select Station</option>
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
						<select name="year" id="year" class="form-control mb-md" onchange="semChange()">
							<option selected disabled>Select Year</option>
						</select>
					</div>
					<!-- end: year input -->

					<!-- start: semester input -->
					<div class="form-group">
						<label class="control-label">Semester</label>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem1" value="1" onclick="semChange()">
								1st Semester (Sept 16-Mar 15)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem2" value="2" onclick="semChange()">
								2nd Semester (Mar 16-Sept 15)
							</label>
						</div>
					</div>
					<!-- end: semester input -->

					<!-- start: variety input -->
					<div class="form-group">
						<label class="control-label">Variety</label>
						<select name="variety" id="variety" class="form-control mb-md">
							<option selected disabled>Select Variety</option>
							@if(!Entrust::can('view_all_planting_plans'))
								@if(count($varietiesPlanted) > 0)
									<option value="All Varieties">All Varieties</option>
								@endif

								@foreach($varietiesPlanted as $variety)
									<option value="{{$variety->variety}}">{{$variety->variety}}</option>
								@endforeach
							@endif
						</select>
					</div>
					<!-- end: variety input -->

					<button class="btn btn-primary" onclick="showActivities()">Show Activities</button>
				</div>

				<div class="col-lg-9">
					<div id="plotMap"></div>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('scripts')
	@include('dashboard.scripts')
	@include('dashboard.js.plotMap')
@endpush