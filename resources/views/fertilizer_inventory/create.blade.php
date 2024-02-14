@extends('layouts.index')


@section('pageHeader')
	<h2>Fertilizer Inventory</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('fertilizer_inventory.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Fertilizer Inventory</span></li>
			<li><span>Add Inventory</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('fertilizer_inventory.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

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

					<h2 class="panel-title">Add Inventory</h2>
				</header>
				{!!Form::open(['route' => 'fertilizer_inventory.store'])!!}

				<div class="panel-body">
					<div class="form-group {{($errors->has('fertilizer')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="fertilizer">Fertilizer</label>
                            <div class="col-xs-12">
                                <input type="text" name="fertilizer" id="fertilizer" class="form-control {{($errors->has('fertilizer')) ? 'is-invalid' : ''}}" value="{{old('fertilizer')}}">
								@if($errors->has('fertilizer'))
                                    <label for="fertilizer" class="error">{{$errors->first('fertilizer')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{($errors->has('quantity')) ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-xs-12 control-label" for="quantity">Quantity (bags)</label>
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
        $('#variety').select2({
			placeholder: "--Select Variety--"
		});
	</script>
@endpush