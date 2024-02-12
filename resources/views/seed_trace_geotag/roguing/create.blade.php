@extends('layouts.index')

@push('styles')
	<style>
		#geotagMap {
			height: 700px;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Roguing</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('roguing.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>SeedTrace Geotag Forms</span></li>
			<li><span>Roguing</span></li>
			<li><span>Fill-up Roguing Form</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('roguing.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Fill-up Roguing Form</h2>
				</header>
				{!!Form::open(['route' => 'roguing.store'])!!}

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
						<select name="cropPhase" id="cropPhase" class="form-control mb-md">
							<option selected disabled>Select Crop Phase</option>
							<option value="Reproductive">Reproductive</option>
							<option value="Ripening">Ripening</option>
							<option value="Seedling">Seedling</option>
							<option value="Vegetative">Vegetative</option>
						</select>
					</div>
					<!-- end: crop phase input -->


					<!-- start: no. of offtypes removed input -->
					<div class="form-group">
						<label class="control-label">No. of offtypes removed</label>
						<input type="text" name="offtypesRemovedCount" id="offtypesRemovedCount" class="form-control">
					</div>
					<!-- end: no. of offtypes removed input -->

					<!-- start: offtype kind input -->
					<div class="form-group">
						<label class="control-label">Kind of offtypes</label>
						<select name="offtypeKind[]" id="offtypeKind" class="form-control mb-md" multiple="multiple">
							<option value="Absence of awn from majority">Absence of awn from majority</option>
							<option value="Color of apiculum">Color of apiculum</option>
							<option value="Color of grains">Color of grains</option>
							<option value="Color of leaves">Color of leaves</option>
							<option value="Early panicle exsertion">Early panicle exsertion</option>
							<option value="Flag leaf different from majority">Flag leaf different from majority</option>
							<option value="Outside row">Outside row</option>
							<option value="Presence of awn from majority">Presence of awn from majority</option>
							<option value="Smaller">Smaller</option>
							<option value="Taller">Taller</option>
							<option value="Within row">Within row</option>
						</select>
					</div>
					<!-- end: offtype kind input -->

					<!-- start: date input -->
					<div class="form-group">
						<label class="control-label">Date & Time</label>
						<div class="row">
							<div class="col-sm-6">
								<input type="text" name="date" id="date" class="form-control" placeholder="Date" data-plugin-datepicker>
							</div>
							<div class="col-sm-6">
								<input type="text" name="time" id="time" class="form-control" placeholder="Time" data-plugin-timepicker>
							</div>
						</div>
					</div>
					<!-- end: date input -->

					<!-- start: laborers input -->
					<div class="form-group">
						<label class="control-label">Laborers</label>
						<input type="text" name="laborers" id="laborers" class="form-control">
					</div>
					<!-- end: laborers input -->

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

	<script>
		// Initiate select2
		$().ready(() => {
			$('#offtypeKind').select2({
				placeholder: "Select Offtype Kind"
			})
		})
	</script>
@endpush