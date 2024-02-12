@extends('layouts.index')

@push('styles')
	<style>
		#plotMap {
			height: 620px;
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
			<li><span>Add New Production Plan</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('production_plans.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Add New Production Plan</h2>
				</header>
				{!!Form::open(['route' => 'production_plans.store'])!!}

				<div class="panel-body" style="max-height: 600px; overflow-y: scroll;">
					<!-- start: year input -->
					<div class="form-group {{($errors->has('year')) ? 'has-error' : ''}}">
						<label class="control-label">Year</label>
						<input type="number" name="year" id="year" class="form-control" min="2021" value="{{old('year')}}" oninput="check_target()">
						@if($errors->has('year'))
							<label for="year" class="error">{{$errors->first('year')}}</label>
						@endif
					</div>
					<!-- end: year input -->

					<!-- start: semester input -->
					<div class="form-group {{($errors->has('sem')) ? 'has-error' : ''}}">
						<label class="control-label">Semester</label>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem1" value="1" {{(old('sem') == 1) ? 'checked' : ''}} oninput="check_target()">
								1st Semester (Sept 16-Mar 15)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem2" value="2" {{(old('sem') == 2) ? 'checked' : ''}} oninput="check_target()">
								2nd Semester (Mar 16-Sept 15)
							</label>
						</div>
						@if($errors->has('sem'))
							<label for="sem" class="error">{{$errors->first('sem')}}</label>
						@endif
					</div>
					<!-- end: semester input -->

					<!-- start: variety input -->
					<div class="form-group {{($errors->has('variety')) ? 'has-error' : ''}}">
						<label class="control-label">Variety</label>
						<select name="variety" id="variety" class="form-control mb-md" onchange="check_target_seed_class()">
							<option></option>
							@foreach($varieties as $variety)
								<option value="{{$variety->variety}}">{{$variety->variety}}</option>
							@endforeach
						</select>
						@if($errors->has('variety'))
							<label for="variety" class="error">{{$errors->first('variety')}}</label>
						@endif
					</div>
					<!-- end: variety input -->

					<!-- start: seed class input -->
					<div class="form-group {{($errors->has('seedClass')) ? 'has-error' : ''}}">
						<label class="control-label">Seed Class To Be Planted</label>
						<select name="seedClass" id="seedClass" class="form-control mb-md" onchange="calculate_seed_quantity()">
							<option></option>
							{{-- <option value="Nucleus">Nucleus</option> --}}
							{{-- <option value="Breeder">Breeder</option> --}}
							<option value="Foundation">Foundation</option>
							<option value="Registered">Registered</option>
							<option value="Certified">Certified</option>
							{{-- <option value="SQR">SQR</option> --}}

						</select>
						@if($errors->has('seedClass'))
							<label for="seedClass" class="error">{{$errors->first('seedClass')}}</label>
						@endif
					</div>
					<!-- end: seed class input -->

					<!-- start: source seed lot input -->
					<div class="form-group {{($errors->has('sourceSeedLot')) ? 'has-error' : ''}}">
						<label class="control-label">Source Seed Lot</label>
						<input type="text" name="sourceSeedLot" id="sourceSeedLot" class="form-control" value="{{old('sourceSeedLot')}}">
						@if($errors->has('sourceSeedLot'))
							<label for="sourceSeedLot" class="error">{{$errors->first('sourceSeedLot')}}</label>
						@endif
					</div>
					<!-- end: source seed lot input -->

					<!-- start: seed production in charge input -->
					{{-- <div class="form-group {{($errors->has('seedProductionInCharge')) ? 'has-error' : ''}}">
						<label class="control-label">Seed Production In-Charge</label>
						<select name="seedProductionInCharge" id="seedProductionInCharge" class="form-control mb-md">
							<option></option>
							@foreach($seedProductionInCharge as $item)
								<option value="{{$item->personnel_id}}">{{$item->first_name}} {{$item->last_name}}</option>
							@endforeach
						</select>
						@if($errors->has('seedProductionInCharge'))
							<label for="seedProductionInCharge" class="error">{{$errors->first('seedProductionInCharge')}}</label>
						@endif
					</div> --}}
					<!-- end: seed production in charge input -->

					<!-- start: field workers input -->
					{{-- <div class="form-group {{($errors->has('fieldWorkers')) ? 'has-error' : ''}}">
						<label class="control-label">Field Workers</label>
						<select name="fieldWorkers[]" id="fieldWorkers" class="form-control mb-md" multiple="multiple">
							<option></option>
							@foreach($laborers as $laborer)
								<option value="{{$laborer->personnel_id}}">{{$laborer->first_name}} {{$laborer->last_name}}</option>
							@endforeach
						</select>
						@if($errors->has('fieldWorkers'))
							<label for="fieldWorkers" class="error">{{$errors->first('fieldWorkers')}}</label>
						@endif
					</div> --}}
					<!-- end: field workers input -->

					<!-- start: region input hidden -->
						<input type="hidden" name="region" id="region">
					<!-- end: province input -->

					<!-- start: province input -->
					{{-- <div class="form-group {{($errors->has('province')) ? 'has-error' : ''}}">
						<label class="control-label">Province <small>(Will Be Used In Application For Seed Certification)</small></label>
						<select name="province" id="province" class="form-control mb-md" onchange="showMunicipalities()">
							<option disabled selected>SELECT PROVINCE</option>
							@foreach($provinces as $province)
								<option value="{{$province->prov_code}}">{{$province->name}}</option>
							@endforeach
						</select>
						@if($errors->has('province'))
							<label for="province" class="error">{{$errors->first('province')}}</label>
						@endif
					</div> --}}
					<!-- end: province input -->

					<!-- start: municipality input -->
					{{-- <div class="form-group {{($errors->has('municipality')) ? 'has-error' : ''}}">
						<label class="control-label">Municipality <small>(Will Be Used In Application For Seed Certification)</small></label>
						<select name="municipality" id="municipality" class="form-control mb-md">
							<option disabled selected>SELECT MUNICIPALITY</option>
						</select>
						@if($errors->has('municipality'))
							<label for="municipality" class="error">{{$errors->first('municipality')}}</label>
						@endif
					</div> --}}
					<!-- end: municipality input -->

					<!-- start: barangay input -->
					<div class="form-group {{($errors->has('barangay')) ? 'has-error' : ''}}">
						<label class="control-label">Barangay</label>
						<input type="text" name="barangay" id="barangay" class="form-control" min="2021" value="{{old('barangay')}}">
						@if($errors->has('barangay'))
							<label for="barangay" class="error">{{$errors->first('barangay')}}</label>
						@endif
					</div>
					<!-- end: barangay input -->

					<!-- start: sitio input -->
					{{-- <div class="form-group {{($errors->has('sitio')) ? 'has-error' : ''}}">
						<label class="control-label">Sitio <small>(Will Be Used In Application For Seed Certification)</small></label>
						<input type="text" name="sitio" id="sitio" class="form-control" min="2021" value="{{old('sitio')}}">
						@if($errors->has('sitio'))
							<label for="sitio" class="error">{{$errors->first('sitio')}}</label>
						@endif
					</div> --}}
					<!-- end: sitio input -->

					<!-- start: farmer input -->
					<div class="form-group {{($errors->has('farmer')) ? 'has-error' : ''}}">
						<label class="control-label">Farmer</label>
						<select name="farmer" id="farmer" class="form-control mb-md" onchange="getPlots()">
							<option></option>
							@foreach($farmers as $farmer)
								<option value="{{$farmer->farmer_id}}">{{$farmer->first_name}} {{$farmer->last_name}}</option>
							@endforeach
						</select>
						@if($errors->has('farmer'))
							<label for="farmer" class="error">{{$errors->first('farmer')}}</label>
						@endif
					</div>
					<!-- end: farmer input -->

					<!-- start: plots input -->
					<div class="form-group {{($errors->has('plots')) ? 'has-error' : ''}}">
						<label class="control-label">Plots</label>
						<select name="plots[]" id="plots" class="form-control mb-md" multiple="multiple" onchange="showPlotsOnMap()">
							<option></option>
							
						</select>
						@if($errors->has('plots'))
							<label for="plots" class="error">{{$errors->first('plots')}}</label>
						@endif
					</div>
					<!-- end: plots input -->

					<!-- start: seed quantity input -->
					<div class="form-group {{($errors->has('seedQuantity')) ? 'has-error' : ''}}">
						<label class="control-label">Seed Quantity To Be Used (kg)</label>
						<input type="number" name="seedQuantity" id="seedQuantity" class="form-control" min="0" value="{{old('seedQuantity')}}">
						@if($errors->has('seedQuantity'))
							<label for="seedQuantity" class="error">{{$errors->first('seedQuantity')}}</label>
						@endif
					</div>
					<!-- end: seed quantity input -->

					<!-- start: plots area -->
					<div class="form-group">
						<label class="control-label">Plots Total Area (ha)</label>
						<input type="text" name="plotsTotalArea" id="plotsTotalArea" class="form-control" readonly="readonly">
					</div>
					<!-- end: plots input -->

					<!-- start: rice program input -->
					<div class="form-group {{($errors->has('rice_program')) ? 'has-error' : ''}}">
						<label class="control-label">Rice Program <small>(Will Be Used In Application For Seed Certification)</small></label>
						<select name="rice_program" id="rice_program" class="form-control mb-md">
							<option disabled selected>SELECT RICE PROGRAM</option>
							<option value="1">National Rice Program</option>
							<option value="2">RCEF</option>
							<option value="3">Golden Rice</option>
							<option value="0">None</option>
						</select>
						@if($errors->has('rice_program'))
							<label for="rice_program" class="error">{{$errors->first('rice_program')}}</label>
						@endif
					</div>
					<!-- end: rice program input -->

					<!-- start: remarks input -->
					<div class="form-group">
						<label class="control-label">Remarks</label>
						<textarea name="remarks" id="remarks" class="form-control" rows="4"></textarea>
					</div>
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

					<h2 class="panel-title">Selected Plots</h2>
				</header>
				<div class="panel-body">
					<div id="plotMap"></div>
				</div>
			</section>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		// Initiate select2
		$().ready(() => {
			$('#variety').select2({
				placeholder: "Select Variety"
			})

			$('#seedClass').select2({
				placeholder: "Select Seed Class"
			})

			$('#farmer').select2({
				placeholder: "Select Farmer"
			})

			$('#fieldWorkers').select2({
				placeholder: "Select Field Workers"
			})

			$('#plots').select2({
				placeholder: "Select Plots"
			})

			// If form has error retain variety dropdown input
			if ("{{old('variety')}}") {
				$('#variety').val("{{old('variety')}}").trigger('change')
			}

			// If form has error retain seed class dropdown input
			if ("{{old('seedClass')}}") {
				$('#seedClass').val("{{old('seedClass')}}").trigger('change')
			}

			// If form has error retain seed production in-charge dropdown input
			if ("{{old('seedProductionInCharge')}}") {
				$('#seedProductionInCharge').val("{{old('seedProductionInCharge')}}").trigger('change')
			}
		})

		function getPlots()
		{
			$.ajax({
			type: 'POST',
			url: "{{route('production_plans.get_plots')}}",
			data: {
				_token: "{{csrf_token()}}",
				farmer_id: $('#farmer').val()
			},
			dataType: 'JSON',
			success: (res) => {
				console.log(res);

				// append options to plots dropdown using the plot_id and plot_name in the response
				$('#plots').empty();
				$('#plots').append('<option></option>');
				$.each(res, function (key, value) {
					$('#plots').append('<option value=' + value.plot_id + '>' + value.name + '</option>');
				});
			}
		})
		}
	</script>

	@include('production_plans.js.plotMap')
	@include('production_plans.js.address')
@endpush