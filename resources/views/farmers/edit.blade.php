@extends('layouts.index')

@section('pageHeader')
	<h2>Farmers</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('farmers.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Farmers</span></li>
			<li><span>Edit Farmer</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('farmers.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Edit New Farmer</h2>
				</header>
				{!!Form::open(['method' => 'PATCH', 'route' => ['farmers.update', $farmer->farmer_id]])!!}

				<div class="panel-body">
					<!-- start: first name input -->
					<div class="form-group {{($errors->has('first_name')) ? 'has-error' : ''}}">
						<label class="control-label">First Name</label>
						<input type="text" name="first_name" id="first_name" class="form-control" value="{{$farmer->first_name}}">
						@if($errors->has('first_name'))
							<label for="first_name" class="error">{{$errors->first('first_name')}}</label>
						@endif
					</div>
					<!-- end: first name input -->

					<!-- start: last name input -->
					<div class="form-group {{($errors->has('last_name')) ? 'has-error' : ''}}">
						<label class="control-label">Last Name</label>
						<input type="text" name="last_name" id="last_name" class="form-control" value="{{$farmer->last_name}}">
						@if($errors->has('last_name'))
							<label for="last_name" class="error">{{$errors->first('last_name')}}</label>
						@endif
					</div>
					<!-- end: last name input -->

                    <!-- start: middle name input -->
					<div class="form-group {{($errors->has('middle_name')) ? 'has-error' : ''}}">
						<label class="control-label">Middle Name</label>
						<input type="text" name="middle_name" id="middle_name" class="form-control" value="{{$farmer->middle_name}}">
						@if($errors->has('middle_name'))
							<label for="middle_name" class="error">{{$errors->first('middle_name')}}</label>
						@endif
					</div>
					<!-- end: middle name input -->

                    <!-- start: suffix input -->
					<div class="form-group {{($errors->has('suffix')) ? 'has-error' : ''}}">
						<label class="control-label">Suffix</label>
						<input type="text" name="suffix" id="suffix" class="form-control" value="{{$farmer->suffix}}">
						@if($errors->has('suffix'))
							<label for="suffix" class="error">{{$errors->first('suffix')}}</label>
						@endif
					</div>
					<!-- end: suffix input -->

					<!-- start: birthdate input -->
					<div class="form-group {{($errors->has('birthdate')) ? 'has-error' : ''}}">
						<label class="control-label">Birthdate</label>
						<input type="date" name="birthdate" id="birthdate" class="form-control" value="{{$farmer->birthdate}}">
						@if($errors->has('birthdate'))
							<label for="birthdate" class="error">{{$errors->first('birthdate')}}</label>
						@endif
					</div>
					<!-- end: birthdate input -->

                    <!-- start: sex input -->
                    <div class="form-group {{($errors->has('sex')) ? 'has-error' : ''}}">
                        <label class="control-label">Sex</label><br>
                        <input type="radio" name="sex" value="1" <?=($farmer->sex == 1) ? 'checked' : ''?>> Female <br>
                        <input type="radio" name="sex" value="2" <?=($farmer->sex == 2) ? 'checked' : ''?>> Male
                    </div>
                    <!-- end: sex input -->

                    <!-- start: barangay input -->
                    <div class="form-group {{($errors->has('barangay')) ? 'has-error' : ''}}">
                        <label class="control-label">Barangay</label>
                        <input type="text" name="barangay" id="barangay" class="form-control" value="{{$farmer->barangay}}">
						@if($errors->has('barangay'))
							<label for="barangay" class="error">{{$errors->first('barangay')}}</label>
						@endif
                    </div>
                    <!-- end: barangay input -->

					<!-- start: RSBSA No. input -->
                    <div class="form-group {{($errors->has('rsbsa_no')) ? 'has-error' : ''}}">
                        <label class="control-label">RSBSA No.</label>
                        <input type="text" name="rsbsa_no" id="rsbsa_no" class="form-control" value="{{$farmer->rsbsa_no}}">
						@if($errors->has('rsbsa_no'))
							<label for="rsbsa_no" class="error">{{$errors->first('rsbsa_no')}}</label>
						@endif
                    </div>
                    <!-- end: RSBSA No. input -->
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