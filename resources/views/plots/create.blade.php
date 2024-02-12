@extends('layouts.index')

@push('styles')
	<style>
		.inner-body {
			position: relative;
		}

		#createPlotMap {
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			width: 100%;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Plots</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('plots.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Plots</span></li>
			<li><span>Add New Plot</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<section class="content-with-menu">
		<div class="content-with-menu-container">
			<div class="inner-menu-toggle">
				<a href="#" class="inner-menu-expand" data-open="inner-menu">
					Show Options <i class="fa fa-chevron-right"></i>
				</a>
			</div>

			<menu id="content-menu" class="inner-menu" role="menu">
				<div class="nano">
					<div class="nano-content">
						<div class="inner-menu-content">
							<a href="{{route('plots.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

							<p class="title">Add New Plot</p>

							{!!Form::open(['route' => 'plots.store'])!!}

							<div class="form-group {{($errors->has('farmer')) ? 'has-error' : ''}}">
								<div class="row">
									<label class="col-xs-12 control-label" for="name">Farmer</label>
									<div class="col-xs-12">
										<select name="farmer" id="farmer" class="form-control select2" select2>
											<option></option>
											@foreach($farmers as $farmer)
												<option value="{{$farmer->farmer_id}}">{{$farmer->first_name}} {{$farmer->last_name}}</option>
											@endforeach
										</select>
										@if($errors->has('farmer'))
											<label for="farmer" class="error">{{$errors->first('farmer')}}</label>
										@endif
									</div>
								</div>
							</div>

							<div class="form-group {{($errors->has('name')) ? 'has-error' : ''}}">
								<div class="row">
									<label class="col-xs-12 control-label" for="name">Plot Name</label>
									<div class="col-xs-12">
										<input id="name" name="name" class="form-control" type="text" value="{{old('name')}}">
										@if($errors->has('name'))
											<label for="name" class="error">{{$errors->first('name')}}</label>
										@endif
									</div>
								</div>
							</div>

							<div class="form-group {{($errors->has('area')) ? 'has-error' : ''}}">
								<div class="row">
									<label class="col-xs-12 control-label" for="area">Area (ha)</label>
									<div class="col-xs-12">
										<input id="area" name="area" class="form-control {{($errors->has('area')) ? 'is-invalid' : ''}}" type="number" min="0" value="{{old('area')}}">
										@if($errors->has('area'))
											<label for="area" class="error">{{$errors->first('area')}}</label>
										@endif
									</div>
								</div>
							</div>

							<div class="form-group {{($errors->has('coordinates')) ? 'has-error' : ''}}">
								<div class="row">
									<label class="col-xs-12 control-label" for="coordinates">Coordinates</label>
									<div class="col-xs-12">
										<input id="coordinates" name="coordinates" class="form-control {{($errors->has('coordinates')) ? 'is-invalid' : ''}}" type="text" data-builder-field="coordinates" readonly="readonly" value="{{old('coordinates')}}">
										@if($errors->has('coordinates'))
											<label for="coordinates" class="error">{{$errors->first('coordinates')}}</label>
										@endif
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<button class="btn btn-success btn-block mb-lg" type="button" onclick="addPlot()">Submit</button>
								</div>
							</div>

							{!!Form::close()!!}

							<hr class="separator" />

							<p class="title">Active Plots</p>

							<ol id="activePlots">

							@foreach($activePlots as $item)
								<li>{{$item->name}}</li>
							@endforeach
							
							</ol>
						</div>
					</div>
				</div>
			</menu>

			<div class="inner-body">
				<div id="createPlotMap"></div>
			</div>
		</div>
	</section>
@endsection

@push('scripts')
	@include('plots.js.addPlotMap')
	@include('plots.js.addPlot')

	<script>
		$('#farmer').select2({
			placeholder: "--Select Farmer--"
		});
	</script>
@endpush