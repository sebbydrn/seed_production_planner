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
			<li><span>Input production plan</span></li>
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
					{!!Form::open(['route' => 'production_plans.store_input_production_plan'])!!}
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
						</div>

						<input type="hidden" name="productionPlanID" value="{{$productionPlan->production_plan_id}}">

						<div class="row mt-lg">
							<div class="col-sm-3">
								<!-- start: seed soaking start date input -->
								<div class="form-group">
									<label class="control-label">Soaking Date</label>
									<input type="text" name="soakingDate" id="soakingDate" class="form-control" placeholder="Date" autocomplete="off" data-plugin-datepicker>
								</div>
								<!-- end: seed soaking start date input -->
							</div>
							<div class="col-sm-3">
								<!-- start: seed sowing duration input -->
								<div class="form-group">
									<label class="control-label">Expected Sowing Date</label>
									<input type="text" name="sowingDate" id="sowingDate" class="form-control" placeholder="Date" autocomplete="off" data-plugin-datepicker onfocusout="calculateHarvestingDate()">
								</div>
								<!-- end: seed sowing duration input -->
							</div>
							<div class="col-sm-3">
								<!-- start: transplanting date input -->
								<div class="form-group">
									<label class="control-label">Expected Transplanting Date</label>
									<input type="text" name="transplantingDate" id="transplantingDate" class="form-control" placeholder="Date" autocomplete="off" data-plugin-datepicker>
								</div>
								<!-- end: transplanting date input -->
							</div>
							<div class="col-sm-3">
								<!-- start: harvesting date input -->
								<div class="form-group">
									<label class="control-label">Expected Harvesting Date</label>
									<input type="text" name="harvestingDate" id="harvestingDate" class="form-control" placeholder="Date" data-plugin-datepicker readonly>
								</div>
								<!-- end: harvesting date input -->
							</div>
						</div>

						<div class="row mt-lg">
							<div class="col-sm-12">
								<button type="submit" id="storeProductionPlan" class="btn btn-md btn-success"><i class="fa fa-check-circle"></i> Submit & Finalize Production Plan</button>
							</div>
						</div>
					{!!Form::close()!!}
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		
		function calculateHarvestingDate() {
			
			let sowingDate = document.getElementById('sowingDate').value
			let maturity = document.getElementById('maturity').value 
			sowingDate = new Date(sowingDate)

			let harvestingDate = new Date(sowingDate)
			harvestingDate.setDate(harvestingDate.getDate() + parseInt(maturity))

			document.getElementById('harvestingDate').value = year(harvestingDate) + "/" + month(harvestingDate) + "/" + dayDate(harvestingDate)

		}

		function year(date) {
			return date.getFullYear()
		}

		function month(date) {
			return `${date.getMonth() + 1}`.padStart(2, '0')
		}

		function dayDate(date) {
			return `${date.getDate()}`.padStart(2, '0')
		}

	</script>
@endpush