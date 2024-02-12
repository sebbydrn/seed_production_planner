@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Planting Report</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('planting_report.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Reports</span></li>
			<li><span>Planting Report</span></li>
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

					<h2 class="panel-title">Planting Report Generator</h2>
				</header>
				<div class="panel-body">
					@if(Entrust::can('view_all_planting_reports'))
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
								<input type="radio" name="seedClass" id="nucleus" value="Nucleus">
								Nucleus
							</label>
						</div>
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
							<button class="btn btn-primary" onclick="generatePlantingReport()"><i class="fa fa-refresh"></i> Generate Planting Report</button>
						</div>
					</div>
				</footer>
			</section>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Planting Report</h2>
				</header>
				<div class="panel-body" style="min-height: 700px;">
					<button class="btn btn-success mb-lg" id="exportToExcelButton" onclick="exportToExcel()" style="display: none"><i class="fa fa-file-excel-o"></i> Export to Excel</button> &nbsp;

					<a class="btn btn-danger mb-lg" target="_blank" id="exportToPDFButton" onclick="exportToPDF()" style="display: none"><i class="fa fa-file-pdf-o"></i> Export to PDF</a>

					<table class="table table-bordered " id="plantingReportTable" style="display: none; width: 100%;">
						<thead>
							<tr class="success">
								<th style="width: 10%; text-align: center;">Station</th>
								<th style="width: 10%; text-align: center;">Variety</th>
								<th style="width: 21%; text-align: center;" colspan="3">Seed Source</th>
								<th style="width: 5%; text-align: center;">Maturity <br /> (DAS)</th>
								<th style="width: 5%; text-align: center;">Seed Class <br /> Planted</th>
								<th style="width: 9%; text-align: center;">Area, ha</th>
								<th style="width: 10%; text-align: center;">Date of <br /> Sowing</th>
								<th style="width: 10%; text-align: center;">Date of <br /> Transplanting</th>
								<th style="width: 10%; text-align: center;">Expected Date of <br /> Harvest</th>
							</tr>
							<tr class="success">
								<th></th>
								<th></th>
								<th style="width: 7%; text-align: center;">Source</th>
								<th style="width: 7%; text-align: center;">Lot No.</th>
								<th style="width: 7%; text-align: center;">Lab No.</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tfoot>
							<tr class="success" id="totalBSRow" style="display: none;">
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th colspan="2" style="text-align: right;">Total Area for BS Production</th>
								<th id="totalAreaBS" class="text-right"></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr class="success" id="totalFSRow" style="display: none;">
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th colspan="2" style="text-align: right;">Total Area for FS Production</th>
								<th id="totalAreaFS" class="text-right"></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr class="success" id="totalRSRow" style="display: none;">
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th colspan="2" style="text-align: right;">Total Area for RS Production</th>
								<th id="totalAreaRS" class="text-right"></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr class="primary">
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th colspan="2" class="table-success" style="text-align: right;">Total Area Planted</th>
								<th id="totalArea" class="text-right"></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</section>
		</div>
	</div>
@endsection

@push('scripts')
	@include('reports.planting_report.scripts')
@endpush