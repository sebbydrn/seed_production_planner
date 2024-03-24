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
				{!!Form::open(['route' => 'seed_distribution.store', 'id' => 'seed_distribution_form'])!!}

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
                                        <option value="{{$variety->variety}}" data-seed-type="{{$variety->seed_type}}" data-remaining={{($variety->seed_type == "Inbred") ? '' . $variety->remaining_bags . ' bags' : '' . $variety->kilograms_remaining . ' kg'}} data-seed-inventory-id="{{$variety->seed_inventory_id}}">{{$variety->seed_type}} - {{$variety->variety}} ({{date('d/m/Y', strtotime($variety->date_created))}})</option>
                                    @endforeach
                                </select>
                                @if($errors->has('variety'))
                                    <label for="variety" class="error">{{$errors->first('variety')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>

					<div class="form-group">
						<div class="row">
							<label for="remaining" class="col-xs-12 control-label">Remaining</label>
							<div class="col-xs-12">
								<input type="text" id="remaining" class="form-control" readonly>
							</div>
						</div>
					</div>

					<input type="hidden" name="seed_inventory_id" id="seed_inventory_id">

					<input type="hidden" name="seed_type" id="seed_type">

					<input type="hidden" name="remaining_area" id="remaining_area" value="{{old('area')}}">

					<div class="form-group {{($errors->has('area')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="area">Area (ha)</label>
                            <div class="col-xs-12">
                                <input id="area" name="area" class="form-control {{($errors->has('area')) ? 'is-invalid' : ''}}" type="text" min="0" value="{{old('area')}}" readonly>
                                @if($errors->has('area'))
                                    <label for="area" class="error">{{$errors->first('area')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{($errors->has('quantity')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="qunatity">Quantity</label>
                            <div class="col-xs-12">
                                <input id="quantity" name="quantity" class="form-control {{($errors->has('quantity')) ? 'is-invalid' : ''}}" type="text" min="0" value="{{old('quantity')}}">
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

		// on change variety, get the seed type and set the hidden seed type field
		$('#variety').on('change', function() {
			var seed_type = $(this).find(':selected').data('seed-type');
			$('#seed_type').val(seed_type);

			// change the step value of the quantity field
			// if seed type is Inbred set the step value to 1
			// if seed type is Hybrid set the step value to 5
			if(seed_type == 'Inbred') {
				$('#quantity').attr('step', 1);
			} else {
				$('#quantity').attr('step', 5);
			}

			// put remaining quantity in the remaining field
			$('#remaining').val($(this).find(':selected').data('remaining'));

			// put seed inventory id in seed inventory id field
			$('#seed_inventory_id').val($(this).find(':selected').data('seed-inventory-id'));
		});

		// on change quantity,
		// if seed type is Inbred, 0.1 to 0.5 ha = 1 bag, subtract the computed area to the area remaining and set the area field to the remaining area
		// if seed type is Hybrid, 0.1 to 0.35 ha = 5 kg, 0.36 to 0.70 ha = 10 kg, every 0.35 hectares increase with a 5 kilogram subtract the computed area to the area remaining and set the area field to the remaining area
		$('#quantity').on('keyup', function() {
			var remaining_area = $('#remaining_area').val();
			var area = $('#area').val();
			var quantity = $(this).val();
			var seed_type = $('#seed_type').val();

			// if the area field is 0 or empty, do not allow the user to input quantity
			/*if(area <= 0) {
				if (seed_type == 'Inbred') {
					var new_quantity = remaining_area * 2;
				}
				
				if (seed_type == 'Hybrid') {
					var new_quantity = remaining_area * 0.35;
				}

				$(this).val(new_quantity);

				$('#area').val(0);

				return false;
			} */

			if (seed_type == 'Inbred') {
				var new_remaining_area = remaining_area - (quantity * 0.5);
				// round off two decimal places
				new_remaining_area = new_remaining_area.toFixed(2);
			}

			if (seed_type == 'Hybrid') {
				var new_remaining_area = remaining_area - ((quantity / 5) * 0.35);
				// round off two decimal places
				new_remaining_area = new_remaining_area.toFixed(2);
			}

			$('#area').val(new_remaining_area);
		});
		

		// on change quantity, if a 1 area = 2 bags subtract the computed area to the area remaining and set the area field to the remaining area
		// $('#quantity').on('change', function() {
		// 	var remaining_area = $('#remaining_area').val();
		// 	var area = $('#area').val();
		// 	var quantity = $(this).val();

		// 	// if the area field is 0 or empty, do not allow the user to input quantity
		// 	if(area <= 0) {
		// 		var new_quantity = remaining_area * 2;
		// 		$(this).val(new_quantity);
		// 		$('#area').val(0);
		// 		return false;
		// 	} 

		// 	var new_remaining_area = remaining_area - (quantity * 0.5);
		// 	console.log(remaining_area);

		// 	$('#area').val(new_remaining_area);
		// });

		// on submit form check if area is negative and if negative, do not submit form
		$('#seed_distribution_form').on('submit', function() {
			var area = $('#area').val();

			if(area < 0) {
				alert('Area cannot be negative');
				return false;
			} else {
				return true;
			}
		});
	</script>
@endpush