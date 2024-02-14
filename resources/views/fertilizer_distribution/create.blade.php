@extends('layouts.index')

@section('pageHeader')
	<h2>Fertilizer Distribution</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('fertilizer_distribution.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Fertilizer Distribution</span></li>
			<li><span>Fertilizer Distribution Form</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('fertilizer_distribution.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Fertilizer Distribution Form</h2>
				</header>
				{!!Form::open(['route' => 'fertilizer_distribution.store'])!!}

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

                    <div class="form-group {{($errors->has('fertilizer')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="name">Fertilizer</label>
                            <div class="col-xs-12">
                                <select name="fertilizer" id="fertilizer" class="form-control select2" select2>
                                    <option></option>
                                    @foreach($fertilizers as $fertilizer)
                                        <option value="{{$fertilizer->fertilizer}}" data-remaining-bags="{{$fertilizer->remaining_bags}}">{{$fertilizer->fertilizer}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('fertilizer'))
                                    <label for="fertilizer" class="error">{{$errors->first('fertilizer')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{($errors->has('quantity')) ? 'has-error' : ''}}">
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

        $('#fertilizer').select2({
			placeholder: "--Select Fertilizer--"
		});

        // on change fertilizer, make sure that the quantity max input is the remaining bags
        $('#fertilizer').on('change', function() {
            var remaining_bags = $(this).find('option:selected').data('remaining-bags');
            $('#quantity').attr('max', remaining_bags);
        });

	</script>
@endpush