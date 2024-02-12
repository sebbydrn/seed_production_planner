@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

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
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
				<a href="#" class="fa fa-times"></a>
			</div>

			<h2 class="panel-title">
				Activities
				
				@if(Entrust::can('add_seed_production_activity')) 
					<!-- Add button -->
					<a href="{{route('activities.create')}}" class="btn btn-success" style="margin-left: 10px;"><i class="fa fa-plus"></i> Add New Activity</a>
				@endif
			</h2>
		</header>
		<div class="panel-body">

			<table class="table table-bordered" id="activitiesTable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</section>
@endsection

@push('scripts')
	@include('activities.js.datatable')
@endpush