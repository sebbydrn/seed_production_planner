@extends('layouts.index')

@push('styles')
	<style>
		#geotagMap {
			height: 700px;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Disease Management</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('disease_management.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>SeedTrace Geotag Forms</span></li>
			<li><span>Disease Management</span></li>
			<li><span>Fill-up Disease Management Form</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('disease_management.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Fill-up Disease Management Form</h2>
				</header>
				{!!Form::open(['route' => 'disease_management.store'])!!}

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
							<option value="Vegetative">Vegetative</option>
						</select>
					</div>
					<!-- end: crop phase input -->

					<!-- start: disease type input -->
					<div class="form-group">
						<label class="control-label">Disease Type</label>
						<select name="disease" id="disease" class="form-control mb-md" onchange="diseaseChange()">
							<option selected disabled>Select Disease</option>
							<option value="Others">Others</option>
							<option value="Bacterial blight">Bacterial blight</option>
							<option value="Bacterial leaf streak">Bacterial leaf streak</option>
							<option value="Bacterial sheath brown rot">Bacterial sheath brown rot</option>
							<option value="Bakanae">Bakanae</option>
							<option value="Blast (leaf and collar)">Blast (leaf and collar)</option>
							<option value="Blast (node and neck)">Blast (node and neck)</option>
							<option value="Brown spot">Brown spot</option>
							<option value="False smut">False smut</option>
							<option value="Leaf Scald">Leaf Scald</option>
							<option value="Narrow brown spot">Narrow brown spot</option>
							<option value="Nematodes">Nematodes</option>
							<option value="Red stripe">Red stripe</option>
							<option value="Rice Yellow Motte Virus">Rice Yellow Motte Virus</option>
							<option value="Rice grassy stunt">Rice grassy stunt</option>
							<option value="Rice ragged stunt">Rice ragged stunt</option>
							<option value="Rice stripe virus">Rice stripe virus</option>
							<option value="Sheath blight">Sheath blight</option>
							<option value="Sheath rot">Sheath rot</option>
							<option value="Stem rot">Stem rot</option>
							<option value="Tungro">Tungro</option>
						</select>
					</div>
					<!-- end: disease type input -->

					<!-- start: specify disease -->
					<div class="form-group" id="otherDiseaseInput" style="display: none">
						<label class="control-label">Specify Disease</label>
						<input type="text" name="otherDisease" id="otherDisease" class="form-control">
					</div>
					<!-- end: specify disease -->

					<!-- start: type of control input -->
					<div class="form-group">
						<label class="control-label">Type of Control</label>
						<select name="controlType" id="controlType" class="form-control mb-md" onchange="controlTypeChange()">
							<option selected disabled>Select Control Type</option>
							<option value="Chemical">Chemical</option>
							<option value="Cultural">Cultural</option>
							<option value="Mechanical">Mechanical</option>
						</select>
					</div>
					<!-- end: type of control input -->

					<!-- start: specify control -->
					<div class="form-group" id="controlSpecInput" style="display: none">
						<label class="control-label">Specify Control</label>
						<input type="text" name="controlSpec" id="controlSpec" class="form-control">
					</div>
					<!-- end: specify control -->

					<!-- start: chemical used input -->
					<div class="form-group" id="chemicalUsedInput" style="display: none">
						<label class="control-label">Chemical Used</label>
						<input type="text" name="chemicalUsed" id="chemicalUsed" class="form-control">
					</div>
					<!-- end: chemical used input -->

					<!-- start: active ingredient input -->
					<div class="form-group" id="activeIngredientInput" style="display: none">
						<label class="control-label">Active Ingredient</label>
						<input type="text" name="activeIngredient" id="activeIngredient" class="form-control">
					</div>
					<!-- end: active ingredient input -->

					<!-- start: mode of application input -->
					<div class="form-group" id="applicationModeInput" style="display: none">
						<label class="control-label">Mode of Application</label>
						<select name="applicationMode" id="applicationMode" class="form-control mb-md" onchange="applicationModeChange()">
							<option selected disabled>Select Mode of Application</option>
							<option value="Broadcast">Broadcast</option>
							<option value="Spray">Spray</option>
						</select>
					</div>
					<!-- end: mode of application input -->

					<!-- start: brand name input -->
					<div class="form-group" id="brandNameInput" style="display: none">
						<label class="control-label">Brand Name</label>
						<input type="text" name="brandName" id="brandName" class="form-control">
					</div>
					<!-- end: brand name input -->

					<!-- start: formulation input -->
					<div class="form-group" id="formulationInput" style="display: none">
						<label class="control-label">Formulation</label>
						<select name="formulation" id="formulation" class="form-control mb-md" onchange="formulationChange()">
							<option selected disabled>Select Formulation</option>
							<option value="Granular">Granular</option>
							<option value="Liquid">Liquid</option>
						</select>
					</div>
					<!-- end: formulation input -->

					<!-- start: unit input -->
					<div class="form-group" id="unitInput" style="display: none">
						<label class="control-label">Unit</label>
						<select name="unit" id="unit" class="form-control mb-md">
							<option selected disabled>Select Unit</option>
						</select>
					</div>
					<!-- end: unit input -->

					<!-- start: total chemical used input -->
					<div class="form-group" id="totalChemicalUsedInput" style="display: none">
						<label class="control-label">Total Chemical Used</label>
						<input type="text" name="totalChemicalUsed" id="totalChemicalUsed" class="form-control">
					</div>
					<!-- end: total chemical used input -->

					<!-- start: no. of tank load input -->
					<div class="form-group" id="tankLoadNoInput" style="display: none">
						<label class="control-label">No. of Tank Load</label>
						<input type="text" name="tankLoadNo" id="tankLoadNo" class="form-control">
					</div>
					<!-- end: no. of tank load input -->

					<!-- start: volume per tank load input -->
					<div class="form-group" id="tankLoadVolumeInput" style="display: none">
						<label class="control-label">Volume Per Tank Load</label>
						<input type="text" name="tankLoadVolume" id="tankLoadVolume" class="form-control">
					</div>
					<!-- end: volume per tank load input -->

					<!-- start: rate pr tank load input -->
					<div class="form-group" id="tankLoadRateInput" style="display: none">
						<label class="control-label">Rate Per Tank Load</label>
						<input type="text" name="tankLoadRate" id="tankLoadRate" class="form-control">
					</div>
					<!-- end: rate pr tank load input -->

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
	@include('seed_trace_geotag.disease_management.js.options')
@endpush