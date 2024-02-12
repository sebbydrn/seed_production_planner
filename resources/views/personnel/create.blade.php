@extends('layouts.index')

@section('pageHeader')
	<h2>Personnel</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('personnel.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Personnel</span></li>
			<li><span>Add New Personnel</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('personnel.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Add New Personnel</h2>
				</header>
				{!!Form::open(['route' => 'personnel.store'])!!}

				<div class="panel-body">
					<!-- start: emp ID No. input -->
					<div class="form-group {{($errors->has('empIDNo')) ? 'has-error' : ''}}">
						<label class="control-label">ID No.</label>
						<input type="text" name="empIDNo" id="empIDNo" class="form-control" data-plugin-masked-input data-input-mask="99-9999" placeholder="__-____" value="{{old('empIDNo')}}">
						@if($errors->has('empIDNo'))
							<label for="empIDNo" class="error">{{$errors->first('empIDNo')}}</label>
						@endif
					</div>
					<!-- end: emp ID No. input -->

					<!-- start: first name input -->
					<div class="form-group {{($errors->has('firstName')) ? 'has-error' : ''}}">
						<label class="control-label">First Name</label>
						<input type="text" name="firstName" id="firstName" class="form-control" value="{{old('firstName')}}">
						@if($errors->has('firstName'))
							<label for="firstName" class="error">{{$errors->first('firstName')}}</label>
						@endif
					</div>
					<!-- end: first name input -->

					<!-- start: last name input -->
					<div class="form-group {{($errors->has('lastName')) ? 'has-error' : ''}}">
						<label class="control-label">Last Name</label>
						<input type="text" name="lastName" id="lastName" class="form-control" value="{{old('lastName')}}">
						@if($errors->has('lastName'))
							<label for="lastName" class="error">{{$errors->first('lastName')}}</label>
						@endif
					</div>
					<!-- end: last name input -->

					<!-- start: role input -->
					<div class="form-group {{($errors->has('role')) ? 'has-error' : ''}}">
						<label class="control-label">Role</label>
						<select name="role" id="role" class="form-control mb-md">
							<option selected disabled>Select Role</option>
							<option value="Seed Production In-Charge" {{(old('role') == "Seed Production In-Charge") ? "selected" : ""}}>Seed Production In-Charge</option>
							<option value="Laborer" {{(old('role') == "Laborer") ? "selected" : ""}}>Laborer</option>
						</select>
						@if($errors->has('role'))
							<label for="role" class="error">{{$errors->first('role')}}</label>
						@endif
					</div>
					<!-- end: role input -->
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