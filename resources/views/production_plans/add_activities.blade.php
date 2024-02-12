@extends('layouts.index')

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
			<li><span>Add Activities</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('production_plans.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Production Plan</h2>
				</header>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Variety</label>
								<input type="text" name="variety" id="variety" class="form-control" value="{{$variety->variety}}" readonly>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Maturity (DAS)</label>
								<input type="text" name="maturity" id="maturity" class="form-control" value="{{$variety->maturity}}" readonly>
							</div>
						</div>
						@if(!empty($productionTechs))
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Production Technology</label>
									<select name="prodTech" id="prodTech" class="form-control" onchange="selectProdTech()">
										<option value="0" selected disabled>Select Production Technology</option>
										@foreach($productionTechs as $prodTech)
											<option value="{{$prodTech['techID']}}">{{$prodTech['prodPlan']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						@endif
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Seedling Age</label>
								<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
									<div class="input-group input-small">
										<input type="text" name="seedlingAge" id="seedlingAge" class="spinner-input form-control" onblur="inputChange('seedlingAge')">
										<div class="spinner-buttons input-group-btn">
											<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedlingAge')">
												<i class="fa fa-angle-up"></i>
											</button>
											<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedlingAge')">
												<i class="fa fa-angle-down"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="tabs tabs-vertical tabs-left tabs-success">
				<ul class="nav nav-tabs col-sm-3 col-xs-5">
					<li class="active" id="seedlingManagementTab">
						<a><span class="badge hidden-xs">1</span> Seedling Management</a>
					</li>
					<li id="landPreparationTab">
						<a><span class="badge hidden-xs">2</span> Land Preparation</a>
					</li>
					<li id="cropEstablishmentTab">
						<a><span class="badge hidden-xs">3</span> Crop Establishment</a>
					</li>
					<li id="waterManagementTab">
						<a><span class="badge hidden-xs">4</span> Water Management (Production)</a>
					</li>
					<li id="nutrientManagementTab">
						<a><span class="badge hidden-xs">5</span> Nutrient Management</a>
					</li>
					<li id="roguingTab">
						<a><span class="badge hidden-xs">6</span> Roguing</a>
					</li>
					<li id="pestManagementTab">
						<a><span class="badge hidden-xs">7</span> Pest Management</a>
					</li>
					<li id="harvestingTab">
						<a><span class="badge hidden-xs">8</span> Harvesting</a>
					</li>
				</ul>
				<div class="tab-content">
					@include('production_plans.activity_forms.seedlingManagement')
					@include('production_plans.activity_forms.landPreparation')
					@include('production_plans.activity_forms.cropEstablishment')
					@include('production_plans.activity_forms.waterManagement')
					@include('production_plans.activity_forms.nutrientManagement')
					@include('production_plans.activity_forms.roguing')
					@include('production_plans.activity_forms.pestManagement')
					@include('production_plans.activity_forms.harvesting')
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	@include('production_plans.js.calculate')
	@include('production_plans.js.activitiesTabToggle')
	@include('production_plans.js.storeActivities')
	@include('production_plans.js.saveAxInputs')
@endpush