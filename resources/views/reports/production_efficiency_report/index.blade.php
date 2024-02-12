@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Production Efficiency Report</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('production_efficiency_report.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Reports</span></li>
			<li><span>Production Efficiency Report</span></li>
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

					<h2 class="panel-title">Production Efficiency Report Generator</h2>
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
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary" onclick="gen_prod_eff_report()"><i class="fa fa-refresh"></i> Generate Production Efficiency Report</button>
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

					<h2 class="panel-title">Production Efficiency Report</h2>
				</header>
				<div class="panel-body" style="min-height: 700px;">
					<button class="btn btn-success mb-lg" id="exportToExcelButton" onclick="exportToExcel()" style="display: none"><i class="fa fa-file-excel-o"></i> Export to Excel</button> &nbsp;

					<a class="btn btn-danger mb-lg" target="_blank" id="exportToPDFButton" onclick="exportToPDF()" style="display: none"><i class="fa fa-file-pdf-o"></i> Export to PDF</a>

					<table class="table table-bordered " id="production_efficiency_report_table" style="display: none; width: 100%;">
						<thead>
							<tr class="success">
								<th style="width: 10%;" class="text-center" rowspan="2">Variety</th>
								<th style="width: 10%;" class="text-center" rowspan="2">Seed Class <br> Planted</th>
								<th style="width: 6%;" class="text-center" rowspan="2">Lot No.</th>
								<th style="width: 7%;" class="text-center" rowspan="2">Date of Harvest</th>
								<th style="width: 7%;" class="text-center" rowspan="2">Date <br> Sampled</th>
								<th style="width: 7%;" class="text-center" rowspan="2">RSO No. <br> by NSQCS</th>
								<th style="width: 6%;" class="text-center" rowspan="2">Produced <br> by</th>
								<th style="width: 40%;" class="text-center" colspan="5">RESULT, kg</th>
								<th style="width: 7%;" class="text-center" rowspan="2">Date Released</th>
							</tr>
							<tr class="success">
								<th style="width: 8%;" class="text-center">FS</th>
								<th style="width: 8%;" class="text-center">RS</th>
								<th style="width: 8%;" class="text-center">CS</th>
								<th style="width: 8%;" class="text-center">Reject</th>
								<th style="width: 8%;" class="text-center">Total</th>
							</tr>
						</thead>
						<tfoot>
							<tr class="success">
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th class="text-right">Total</th>
								<th class="text-right" id="fs_total"></th>
								<th class="text-right" id="rs_total"></th>
								<th class="text-right" id="cs_total"></th>
								<th class="text-right" id="reject_total"></th>
								<th class="text-right" id="grand_total"></th>
								<th></th>
							</tr>
							<tr class="primary">
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th colspan="2" class="text-right">Seed production efficiency %</th>
								<th class="text-right" id="fs_efficiency"></th>
								<th class="text-right" id="rs_efficiency"></th>
								<th></th>
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
	@include('reports.production_efficiency_report.scripts')
@endpush