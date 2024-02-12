@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Processing Report</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('processing_report.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Reports</span></li>
			<li><span>Processing Report</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<div class="row">
		<div class="col-md-4">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Processing Report Generator</h2>
				</header>
				<div class="panel-body">
					@if(Entrust::can('view_all_planting_plans'))
						<!-- start: station input -->
						<div class="form-group">
							<label class="control-label">PhilRice Station</label>
							<select name="station" id="station" class="form-control mb-md">
								<option selected disabled>Select Station</option>
								<option value="0">All PhilRice Branch and Satellite Stations</option>
								@foreach($stations as $station)
									<option value="{{$station->philrice_station_id}}">{{$station->name}}</option>
								@endforeach
							</select>
						</div>
						<!-- end: station input -->
					@else
						<input type="hidden" name="station" id="station" value="{{$philriceStationID}}">
					@endif

					<!-- start: year input -->
					<div class="form-group">
						<label class="control-label">Year</label>
						<select name="year" id="year" class="form-control mb-md">
							<option selected disabled>Select Year</option>
							@foreach($years as $year)
								<option value="{{$year->year}}">{{$year->year}}</option>
							@endforeach
						</select>
					</div>
					<!-- end: year input -->

					<!-- start: semester input -->
					<div class="form-group">
						<label class="control-label">Semester</label>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem1" value="1">
								1st Semester (Sept 16-Mar 15)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem2" value="2">
								2nd Semester (Mar 16-Sept 15)
							</label>
						</div>
					</div>
					<!-- end: semester input -->

					<!-- start: seed class planted input -->
					<div class="form-group">
						<label class="control-label">Seed Class Planted</label>
						<div class="radio">
							<label>
								<input type="radio" name="seedClass" id="breeder" value="Breeder">
								Breeder
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="seedClass" id="foundation" value="Foundation">
								Foundation
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="seedClass" id="all" value="All">
								All
							</label>
						</div>
					</div>
					<!-- end: seed class planted input -->
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary" onclick="gen_processing_report()"><i class="fa fa-refresh"></i> Generate Processing Report</button>
						</div>
					</div>
				</footer>
			</section>
		</div>

		<div class="col-md-8">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Processing Report</h2>
				</header>
				<div class="panel-body" style="min-height: 700px;">
					<button class="btn btn-success mb-lg" id="exportToExcelButton" onclick="exportToExcel()" style="display: none"><i class="fa fa-file-excel-o"></i> Export to Excel</button> &nbsp;

					<a class="btn btn-danger mb-lg" target="_blank" id="exportToPDFButton" onclick="exportToPDF()" style="display: none"><i class="fa fa-file-pdf-o"></i> Export to PDF</a>

					<table class="table table-bordered " id="processing_report_table" style="display: none; width: 100%;">
						<thead>
							<tr class="success">
								<th style="width: 6%;" class="text-center" rowspan="2">Station</th>
								<th style="width: 13%;" class="text-center" rowspan="2">Variety</th>
								<th style="width: 11%;" class="text-center" rowspan="2">Seed Class <br> Planted</th>
								<th style="width: 20%;" class="text-center" colspan="2">Fresh</th>
								<th style="width: 20%;" class="text-center" colspan="2">Dried</th>
								<th style="width: 30%;" class="text-center" colspan="3">Weight After Cleaning</th>
							</tr>
							<tr class="success">
								<th style="width: 10%;" class="text-center">Wt., kg</th>
								<th style="width: 10%;" class="text-center">MC, %</th>
								<th style="width: 10%;" class="text-center">Wt., kg</th>
								<th style="width: 10%;" class="text-center">MC, %</th>
								<th style="width: 10%;" class="text-center">Filled, kg</th>
								<th style="width: 10%;" class="text-center">Half-filled, kg</th>
								<th style="width: 10%;" class="text-center">Unfilled, kg</th>
							</tr>
						</thead>
						
					</table>
				</div>
			</section>
		</div>
	</div>
@endsection

@push('scripts')
	@include('reports.processing_report.scripts')
@endpush