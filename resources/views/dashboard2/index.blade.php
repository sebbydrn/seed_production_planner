@extends('layouts.index')

@push('styles')
	<style>
		
	</style>
@endpush

@section('pageHeader')
	<h2>Dashboard</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('dashboard2.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Dashboard</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">
						Area Planned vs Area Planted ({{$area_planned_data->year}} SEM {{$area_planned_data->sem}})
					</h2>
				</header>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div id="area_planned_vs_planted" style=""></div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<p style="text-align: right; margin-bottom: 0;">Data as of {{date('M d, Y h:i A', strtotime($area_planned_data->timestamp))}}</p>
				</div>
			</section>
		</div>
	</div>
@endsection

@push('scripts')
	@include('dashboard2.js.area_planned_vs_planted')
@endpush