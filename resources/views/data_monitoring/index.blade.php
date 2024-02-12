@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Data Monitoring For Seed Production Planner</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('data_monitoring.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Data Monitoring For Seed Production Planner</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<div class="row">
		<div class="col-md-4">
			<section class="panel panel-featured-left panel-featured-success">
				<div class="panel-body">
					<div class="widget-summary">
						<div class="widget-summary-col">
							<div class="summary">
								<h1 id="totalDailyData">{{$data['totalDailyData']}}</h1>
								<h4 class="title">Data Received Today <br /> ({{date('F d, Y')}})</h4>
							</div>
							<div class="summary-footer">
								<a class="text-muted text-uppercase">PRODUCTION PLAN</a>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="panel panel-featured-left panel-featured-primary">
				<div class="panel-body">
					<div class="widget-summary">
						<div class="widget-summary-col">
							<div class="summary">
								<h1 id="totalData">{{$data['totalData']}}</h1>
								<h4 class="title">Total Data Received</h4>
							</div>
							<div class="summary-footer">
								<a class="text-muted text-uppercase">PRODUCTION PLAN</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-body" id="dailyData" style="background-color: #000; color: #fff; min-height: 405px; font-family: 'Courier New', Courier, monospace; font-size: 12px; padding: 10px;">
						<strong>Data Log Today: {{date('F d, Y')}}</strong> <hr style="background-color: #fff; width: 100%;" class="mt-1 mb-1">

						@if (count($dailyData) > 0)
							@php 
								$count = 1;
							@endphp

							@foreach ($dailyData as $item)
								@if ($count <= 5)
									<p class="mt-0 mb-0"><span style="color: #28a745;">[ {{$item['timestamp']}} ]</span> Data: [ Year:"{{$item['year']}}";Semester:"{{$item['sem']}}";Variety:"{{$item['variety']}}";Seed Class:"{{$item['seed_class']}}";Station:"{{$item['station']}}" ]</p>
								@endif
								@php
									$count++;
								@endphp
							@endforeach
						@else
							<p style="color: red;">--No Data Received--</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
					<a href="#" class="fa fa-times"></a>
				</div>

				<h2 class="panel-title">
					Received Production Plans
				</h2>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4 mb-lg">
						<label>Filter Table by PhilRice Station:</label>
						<select name="philriceStation" id="philriceStation" class="form-control" onchange="filterTableByStation()">
							<option value="0" selected disabled>Select PhilRice Station</option>
							<option value="1">All Stations</option>
							@foreach ($philriceStations as $station)
								<option value="{{$station->philrice_station_id}}">{{$station->name}}</option>
							@endforeach
						</select>
					</div>

					<div class="col-md-8">
						<button type="button" class="btn btn-primary" onclick="refreshTable()" style="float: right;">Refresh Table</button>
					</div>
				</div>

				<table class="table table-bordered" id="receivedProdPlansTable">
					<thead>
						<tr>
							<th>Production Plot Code</th>
							<th>Year</th>
							<th>Semester</th>
							<th>Variety</th>
							<th>Seed Class</th>
							<th>Station</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</section>
		
	</div>
@endsection

@push('scripts')
	@include('data_monitoring.scripts')
@endpush