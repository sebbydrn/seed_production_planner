@extends('layouts.index')

@section('pageHeader')
	<h2>Activities</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('activities.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Activities</span></li>
			<li><span>Add New Activity</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('activities.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Add New Activity</h2>
				</header>
				{!!Form::open(['route' => 'activities.store'])!!}

				<div class="panel-body">
					<!-- start: activity name input -->
					<div class="form-group {{($errors->has('name')) ? 'has-error' : ''}}">
						<label class="control-label">Activity Name</label>
						<input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
						@if($errors->has('name'))
							<label for="name" class="error">{{$errors->first('name')}}</label>
						@endif
					</div>
					<!-- end: activity name input -->
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