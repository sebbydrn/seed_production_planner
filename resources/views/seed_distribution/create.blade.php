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
	<h2>Seed Distribution</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('seed_distribution.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Seed Distribution</span></li>
			<li><span>Seed Distribution Form</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('seed_distribution.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Seed Distribution Form</h2>
				</header>
				{!!Form::open(['route' => 'seed_distribution.store'])!!}

				<div class="panel-body">
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

					<div class="form-group {{($errors->has('farmer')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="name">Farmer</label>
                            <div class="col-xs-12">
                                <select name="farmer" id="farmer" class="form-control select2" select2>
                                    <option></option>
                                    @foreach($farmers as $farmer)
                                        <option value="{{$farmer->farmer_id}}">{{$farmer->rsbsa_no}} - {{$farmer->first_name}} {{$farmer->last_name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('farmer'))
                                    <label for="farmer" class="error">{{$errors->first('farmer')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{($errors->has('variety')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="name">Variety</label>
                            <div class="col-xs-12">
                                <select name="variety" id="variety" class="form-control select2" select2>
                                    <option></option>
                                    @foreach($variety as $variety)
                                        <option value="{{$variety->variety}}">{{$variety->variety}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('variety'))
                                    <label for="variety" class="error">{{$errors->first('variety')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>

					<input type="hidden" name="remaining_area" id="remaining_area" value="{{old('area')}}">

					<div class="form-group {{($errors->has('area')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="area">Area (ha)</label>
                            <div class="col-xs-12">
                                <input id="area" name="area" class="form-control {{($errors->has('area')) ? 'is-invalid' : ''}}" type="number" min="0" value="{{old('area')}}" readonly>
                                @if($errors->has('area'))
                                    <label for="area" class="error">{{$errors->first('area')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{($errors->has('qunatity')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="qunatity">Quantity (bags)</label>
                            <div class="col-xs-12">
                                <input id="quantity" name="quantity" class="form-control {{($errors->has('quantity')) ? 'is-invalid' : ''}}" type="number" min="0" value="{{old('quantity')}}">
                                @if($errors->has('quantity'))
                                    <label for="quantity" class="error">{{$errors->first('quantity')}}</label>
                                @endif
                            </div>
                        </div>
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
	</div>
@endsection

@push('scripts')
	<script>
		$('#farmer').select2({
			placeholder: "--Select Farmer--"
		});

        $('#variety').select2({
			placeholder: "--Select Variety--"
		});

		// on select farmer, get the farmer's area using ajax
		$('#farmer').on('change', function() {
			var farmer_id = $(this).val();
			var year = $('#year').val();
			var sem = $('input[name="sem"]:checked').val();

			$.ajax({
				url: "{{route('seed_distribution.get_farmer_area')}}",
				method: "POST",
				data: {
					_token: "{{csrf_token()}}",
					farmer_id: farmer_id,
					year: year,
					sem: sem
				},
				success: function(data) {
					$('#area').val(data.area_remaining);
					$('#remaining_area').val(data.area_remaining);
				}
			});
		});

		// on change quantity, if a 1 area = 2 bags subtract the computed area to the area remaining and set the area field to the remaining area
		$('#quantity').on('change', function() {
			var remaining_area = $('#remaining_area').val();
			var area = $('#area').val();
			var quantity = $(this).val();

			// if the area field is 0 or empty, do not allow the user to input quantity
			if(area <= 0) {
				var new_quantity = remaining_area * 2;
				$(this).val(new_quantity);
				$('#area').val(0);
				return false;
			} 

			var new_remaining_area = remaining_area - (quantity * 0.5);
			console.log(remaining_area);

			$('#area').val(new_remaining_area);
		});
	</script>
@endpush