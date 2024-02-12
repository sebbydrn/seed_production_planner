@extends('layouts.index')

@push('styles')
	<style>
		#plotMap {
			height: 700px;
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
			<li><span>View All Active Lots in Map</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('plots.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
				<a href="#" class="fa fa-times"></a>
			</div>

			<h2 class="panel-title">Active Lots Map</h2>
		</header>
		<div class="panel-body">
			<div id="plotMap"></div>
		</div>
	</section>
@endsection

@push('scripts')
	@include('plots.js.plotMap')
@endpush