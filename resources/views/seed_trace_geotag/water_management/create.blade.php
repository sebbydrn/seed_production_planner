@extends('layouts.index')

@push('styles')
	<style>
		#geotagMap {
			height: 700px;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Water Management</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('water_management.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>SeedTrace Geotag Forms</span></li>
			<li><span>Water Management</span></li>
			<li><span>Fill-up Water Management Form</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('water_management.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

	@if($message = Session::get('success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<strong>Well done!</strong> {{$message}}
		</div>
	@endif

	@if($message = Session::get('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<strong>Oh snap!</strong> {{$message}}
		</div>
	@endif

	<div class="row">
		<div class="col-md-4">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Fill-up Water Management Form</h2>
				</header>
				{!!Form::open(['route' => 'water_management.store'])!!}

				<div class="panel-body">
					<!-- start: year input -->
					<div class="form-group">
						<label class="control-label">Year</label>
						<select name="year" id="year" class="form-control mb-md" onchange="getVarieties()">
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
								<input type="radio" name="sem" id="sem1" value="1" onchange="getVarieties()">
								1st Semester (Sept 16-Mar 15)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem2" value="2" onchange="getVarieties()">
								2nd Semester (Mar 16-Sept 15)
							</label>
						</div>
					</div>
					<!-- end: semester input -->

					<!-- start: variety input -->
					<div class="form-group">
						<label class="control-label">Variety</label>
						<select name="variety" id="variety" class="form-control mb-md" onchange="getPlots()">
							<option selected disabled>Select Variety</option>
						</select>

						<div class="mt-4">
							<label>Production Plots:</label>

							<div id="productionPlots" style="font-size: 14px; color: red;">
								
							</div>
						</div>
					</div>
					<!-- end: variety input -->

					<!-- start: production plot code input -->
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label class="control-label">Production Plot Code</label>
								<input type="text" name="productionPlotCode" id="productionPlotCode" class="form-control" readonly>
							</div>
							{{-- <div class="col-sm-6">
								<video id="qrcodeScanner" style="width: 100%;"></video>
							</div> --}}
						</div>
					</div>
					<!-- end: production plot code input -->

					<!-- start: crop phase input -->
					<div class="form-group">
						<label class="control-label">Crop Phase</label>
						<select name="cropPhase" id="cropPhase" class="form-control mb-md" onchange="cropPhaseChange()">
							<option selected disabled>Select Crop Phase</option>
							<option value="Reproductive">Reproductive</option>
							<option value="Ripening">Ripening</option>
							<option value="Vegetative">Vegetative</option>
						</select>
					</div>
					<!-- end: crop phase input -->

					<!-- start: crop stage input -->
					<div class="form-group">
						<label class="control-label">Crop Stage</label>
						<select name="cropStage" id="cropStage" class="form-control mb-md">
							<option selected disabled>Select Crop Stage</option>
						</select>
					</div>
					<!-- end: crop stage input -->

					<!-- start: activity input -->
					<div class="form-group">
						<label class="control-label">Activity</label>
						<div class="radio">
							<label>
								<input type="radio" name="activity" id="drainWater" value="Drain Water">
								Drain Water
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="activity" id="irrigate" value="Irrigate">
								Irrigate
							</label>
						</div>
					</div>
					<!-- end: activity input -->


					<!-- start: date start input -->
					<div class="form-group">
						<label class="control-label">Date & Time Start</label>
						<div class="row">
							<div class="col-sm-6">
								<input type="text" name="dateStart" id="dateStart" class="form-control" placeholder="Date Start" data-plugin-datepicker>
							</div>
							<div class="col-sm-6">
								<input type="text" name="timeStart" id="timeStart" class="form-control" placeholder="Time Start" data-plugin-timepicker>
							</div>
						</div>
					</div>
					<!-- end: date start input -->

					<!-- start: date end input -->
					<div class="form-group">
						<label class="control-label">Date & Time End</label>
						<div class="row">
							<div class="col-sm-6">
								<input type="text" name="dateEnd" id="dateEnd" class="form-control" placeholder="Date End" data-plugin-datepicker>
							</div>
							<div class="col-sm-6">
								<input type="text" name="timeEnd" id="timeEnd" class="form-control" placeholder="Time End" data-plugin-timepicker>
							</div>
						</div>
					</div>
					<!-- end: date end input -->

					<!-- start: labor cost input -->
					<div class="form-group">
						<label class="control-label">Labor Cost</label>
						<input type="text" name="laborCost" id="laborCost" class="form-control">
					</div>
					<!-- end: labor cost input -->

					<!-- start: no. of workers input -->
					<div class="form-group">
						<label class="control-label">No. of workers</label>
						<input type="text" name="workersNo" id="workersNo" class="form-control">
					</div>
					<!-- end: no. of workers input -->

					<!-- start: remarks input -->
					<div class="form-group">
						<label class="control-label">Remarks</label>
						<textarea name="remarks" id="remarks" class="form-control" rows="5"></textarea>
					</div>
					<!-- end: remarks input -->

					<!-- start: location point input -->
					<div class="form-group">
						<label class="control-label">Location Point</label>
						<input type="text" name="locationPoint" id="locationPoint" class="form-control" readonly>
					</div>
					<!-- end: location point input -->
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-success">Submit</button>
						</div>
					</div>
				</footer>

				{!!Form::close()!!}
			</section>
		</div>
		<div class="col-md-8">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Geotag Map</h2>
				</header>
				<div class="panel-body">
					<div id="geotagMap"></div>
				</div>
			</section>
		</div>
	</div>
@endsection

@push('scripts')
	@include('seed_trace_geotag.js.geotagMap')
	@include('seed_trace_geotag.js.scripts')
	@include('seed_trace_geotag.water_management.js.options')
@endpush