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
			<li><span>Edit Production Plan</span></li>
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

					<h2 class="panel-title">Edit Production Plan</h2>
				</header>
				{!!Form::open(['method' => 'PATCH', 'route' => ['production_plans.update', $productionPlan->production_plan_id]])!!}

				<input type="hidden" name="oldYear" value="{{$productionPlan->year}}">
				<input type="hidden" name="oldSem" value="{{$productionPlan->sem}}">
				<input type="hidden" name="oldVariety" value="{{$productionPlan->variety}}">
				<input type="hidden" name="oldSeedClass" value="{{$productionPlan->seed_class}}">
				<input type="hidden" name="oldSourceSeedLot" value="{{$productionPlan->source_seed_lot}}">
				<input type="hidden" name="oldSeedQuantity" value="{{$productionPlan->seed_quantity}}">
				<input type="hidden" name="oldSeedProductionInCharge" value="{{$productionPlan->seed_production_in_charge}}">
				<input type="hidden" name="oldRegion" value="{{$productionPlan->region}}">
				<input type="hidden" name="oldProvince" value="{{$productionPlan->province}}">
				<input type="hidden" name="oldMunicipality" value="{{$productionPlan->municipality}}">
				<input type="hidden" name="oldBarangay" value="{{$productionPlan->barangay}}">
				<input type="hidden" name="oldSitio" value="{{$productionPlan->sitio}}">
				<input type="hidden" name="oldRiceProgram" value="{{$productionPlan->rice_program}}">

				<div class="panel-body" style="max-height: 600px; overflow-y: scroll;">
					<!-- start: year input -->
					<div class="form-group {{($errors->has('year')) ? 'has-error' : ''}}">
						<label class="control-label">Year</label>
						<input type="number" name="year" id="year" class="form-control" min="2021" value="{{$productionPlan->year}}">
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
								<input type="radio" name="sem" id="sem1" value="1" {{($productionPlan->sem == 1) ? 'checked' : ''}}>
								1st Semester (Sept 16-Mar 15)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem2" value="2" {{($productionPlan->sem == 2) ? 'checked' : ''}}>
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
						<select name="variety" id="variety" class="form-control mb-md">
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
						<select name="seedClass" id="seedClass" class="form-control mb-md">
							<option></option>
							<option value="Breeder">Breeder</option>
							<option value="Foundation">Foundation</option>
							<option value="Registered">Registered</option>
						</select>
						@if($errors->has('seedClass'))
							<label for="seedClass" class="error">{{$errors->first('seedClass')}}</label>
						@endif
					</div>
					<!-- end: seed class input -->

					<!-- start: source seed lot input -->
					<div class="form-group {{($errors->has('sourceSeedLot')) ? 'has-error' : ''}}">
						<label class="control-label">Source Seed Lot</label>
						<input type="text" name="sourceSeedLot" id="sourceSeedLot" class="form-control" value="{{$productionPlan->source_seed_lot}}">
						@if($errors->has('sourceSeedLot'))
							<label for="sourceSeedLot" class="error">{{$errors->first('sourceSeedLot')}}</label>
						@endif
					</div>
					<!-- end: source seed lot input -->

					<!-- start: seed production in charge input -->
					<div class="form-group {{($errors->has('seedProductionInCharge')) ? 'has-error' : ''}}">
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
					</div>
					<!-- end: seed production in charge input -->

					<!-- start: field workers input -->
					<div class="form-group {{($errors->has('fieldWorkers')) ? 'has-error' : ''}}">
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
					</div>
					<!-- end: field workers input -->

					<!-- start: region input hidden -->
						<input type="hidden" name="region" id="region" value="{{$productionPlan->region}}">
					<!-- end: province input -->

					<!-- start: province input -->
					<div class="form-group {{($errors->has('province')) ? 'has-error' : ''}}">
						<label class="control-label">Province</label>
						<select name="province" id="province" class="form-control mb-md" onchange="showMunicipalities()">
							<option disabled selected>SELECT PROVINCE</option>
							@foreach($provinces as $province)
								@if($province->prov_code == $productionPlan->province)
									<option value="{{$province->prov_code}}" selected>{{$province->name}}</option>
								@else
									<option value="{{$province->prov_code}}">{{$province->name}}</option>
								@endif
							@endforeach
						</select>
						@if($errors->has('province'))
							<label for="province" class="error">{{$errors->first('province')}}</label>
						@endif
					</div>
					<!-- end: province input -->

					<!-- start: municipality input -->
					<div class="form-group {{($errors->has('municipality')) ? 'has-error' : ''}}">
						<label class="control-label">Municipality</label>
						<select name="municipality" id="municipality" class="form-control mb-md">
							<option disabled selected>SELECT MUNICIPALITY</option>
							@foreach($municipalities as $municipality)
								@if($municipality->mun_code == $productionPlan->municipality)
									<option value="{{$municipality->mun_code}}" selected>{{$municipality->name}}</option>
								@else
									<option value="{{$municipality->mun_code}}">{{$municipality->name}}</option>
								@endif
							@endforeach
						</select>
						@if($errors->has('municipality'))
							<label for="municipality" class="error">{{$errors->first('municipality')}}</label>
						@endif
					</div>
					<!-- end: municipality input -->

					<!-- start: barangay input -->
					<div class="form-group {{($errors->has('barangay')) ? 'has-error' : ''}}">
						<label class="control-label">Barangay</label>
						<input type="text" name="barangay" id="barangay" class="form-control" min="2021" value="{{$productionPlan->barangay}}">
						@if($errors->has('barangay'))
							<label for="barangay" class="error">{{$errors->first('barangay')}}</label>
						@endif
					</div>
					<!-- end: barangay input -->

					<!-- start: sitio input -->
					<div class="form-group {{($errors->has('sitio')) ? 'has-error' : ''}}">
						<label class="control-label">Sitio</label>
						<input type="text" name="sitio" id="sitio" class="form-control" min="2021" value="{{$productionPlan->sitio}}">
						@if($errors->has('sitio'))
							<label for="sitio" class="error">{{$errors->first('sitio')}}</label>
						@endif
					</div>
					<!-- end: sitio input -->

					<!-- start: plots input -->
					<div class="form-group {{($errors->has('plots')) ? 'has-error' : ''}}">
						<label class="control-label">Plots</label>
						<select name="plots[]" id="plots" class="form-control mb-md" multiple="multiple" onchange="showPlotsOnMap()">
							<option></option>
							@foreach($activePlots as $plot)
								<option value="{{$plot->plot_id}}">{{$plot->name}}</option>
							@endforeach
						</select>
						@if($errors->has('plots'))
							<label for="plots" class="error">{{$errors->first('plots')}}</label>
						@endif
					</div>
					<!-- end: plots input -->

					<!-- start: seed quantity input -->
					<div class="form-group {{($errors->has('seedQuantity')) ? 'has-error' : ''}}">
						<label class="control-label">Seed Quantity To Be Used (kg)</label>
						<input type="number" name="seedQuantity" id="seedQuantity" class="form-control" min="20" value="{{$productionPlan->seed_quantity}}">
						@if($errors->has('seedQuantity'))
							<label for="seedQuantity" class="error">{{$errors->first('seedQuantity')}}</label>
						@endif
					</div>
					<!-- end: seed quantity input -->

					<!-- start: plots area -->
					<div class="form-group">
						<label class="control-label">Plots Total Area (ha)</label>
						<input type="text" name="plotsTotalArea" id="plotsTotalArea" class="form-control" readonly="readonly" value="{{$totalArea}}">
					</div>
					<!-- end: plots input -->

					<!-- start: rice program input -->
					<div class="form-group {{($errors->has('rice_program')) ? 'has-error' : ''}}">
						<label class="control-label">Rice Program</label>
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

				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-success">Save Changes</button>
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

			$('#seedProductionInCharge').select2({
				placeholder: "Select Seed Production In-Charge"
			})

			$('#fieldWorkers').select2({
				placeholder: "Select Field Workers"
			})

			$('#plots').select2({
				placeholder: "Select Plots"
			})

			$('#variety').val("{{$productionPlan->variety}}").trigger('change')
			$('#seedClass').val("{{$productionPlan->seed_class}}").trigger('change')
			$('#seedProductionInCharge').val("{{$productionPlan->seed_production_in_charge}}").trigger('change')
			$('#rice_program').val("{{$productionPlan->rice_program}}").trigger('change')
			
			let selectedLaborers = []
			@foreach($selectedLaborers as $laborer)
				selectedLaborers.push({{$laborer->personnel_id}})
			@endforeach

			$('#fieldWorkers').val(selectedLaborers).trigger('change')

			let selectedPlots = []
			@foreach($selectedPlots as $plot)
				selectedPlots.push({{$plot->plot_id}})
			@endforeach

			$('#plots').val(selectedPlots).trigger('change')
		})
	</script>

	@include('production_plans.js.plotMap')
	@include('production_plans.js.address')
@endpush