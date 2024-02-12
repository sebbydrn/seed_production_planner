@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}

		.form-inline .form-control {
			width:  25rem;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Certification Tracker</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('certification_tracker.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Reports</span></li>
			<li><span>Certification Tracker</span></li>
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

					<h2 class="panel-title">Certification Tracker</h2>
				</header>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<h5>Search:</h5>
						</div>
					</div>

					<div class="row mt-sm">
						<div class="col-md-12">
							<form class="form-inline">
								<div class="form-group">
									<select name="variety" id="variety" class="form-control mb-md mr-sm" data-plugin-selectTwo data-plugin-options='{ "placeholder": "Select variety", "allowClear": true }'>
										<option selected disabled></option>
										@foreach($varieties as $v)
											<option value="{{$v->variety}}">{{$v->variety}}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<input type="text" name="serial_number" id="serial_number" class="form-control mb-md mr-sm" placeholder="Enter serial number (optional)">
								</div>

								<div class="form-group">
									<input type="text" name="lot_no" id="lot_no" class="form-control mb-md mr-sm" placeholder="Enter lot number (optional)">
								</div>

								<div class="form-group">
									<input type="text" name="lab_no" id="lab_no" class="form-control mb-md mr-sm" placeholder="Enter lab number (optional)">
								</div>

								<button id="search" type="button" class="btn btn-primary mb-md" onclick="trackCertification()">Search</button>
							</form>

							<table class="table table-bordered mt-md" id="certification_tracker_table" style="width: 100%; display: none;">
								<thead>
									<tr class="success">
										<th class="text-center" rowspan="2">Variety</th>
										<th class="text-center" rowspan="2">Seed Class Planted</th>
										<th class="text-center" rowspan="2">Seed Class After</th>
										<th class="text-center" rowspan="2">Lot No.</th>
										<th class="text-center" rowspan="2">Lab No.</th>
										<th class="text-center" rowspan="2">GrowApp Tracking No.</th>
										<th class="text-center" rowspan="2">Serial No.</th>
										<th class="text-center" rowspan="2">Date Planted</th>
										<th class="text-center" colspan="3">Seed Source</th>
										<th class="text-center" rowspan="2">Prelim Inspection Status</th>
										<th class="text-center" rowspan="2">Final Inspection Status</th>
										<th class="text-center" rowspan="2">Lab Test Status</th>
									</tr>
									<tr class="success">
										<th class="text-center">Source</th>
										<th class="text-center">Lot No.</th>
										<th class="text-center">Lab No.</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
@endsection

@push('scripts')
	@include('reports.certification_tracker.js.scripts')
@endpush