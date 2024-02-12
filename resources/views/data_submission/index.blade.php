@extends('layouts.index')

@section('pageHeader')
	<h2>Data Submissions</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('plots.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Data Submissions</span></li>
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
				Total Planned Area
			</h2>
		</header>
		<div class="panel-body">
			<h4 style="margin-top: 0px;">Year: {{$data2['year']}}</h4>
			<h4>Semester: {{($data2['sem'] == 1) ? "1st" : "2nd"}}</h4>

			<table class="table table-bordered table-responsive" style="margin-top: 10px;">
				<thead>
					<tr>
						<th style="width: 30%; text-align: center;">Station</th>
						<th style="width: 15%; text-align: center;">Code</th>
						<th style="width: 20; text-align: center;">Total Plots Area (ha)</th>
						<th style="width: 20%; text-align: center;">Total Planned Area (ha)</th>
						<th style="width: 15%; text-align: center;">Percent Completed</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data2['data'] as $item)
						<tr>
							<td>{{$item['station']}}</td>
							<td>{{$item['stationCode']}}</td>
							<td style="text-align: right;">{{$item['totalArea']}}</td>
							<td style="text-align: right;">
								@if($item['totalAreaPlanned'])
									{{$item['totalAreaPlanned']}}
								@else
									0
								@endif
							</td>
							<td style="text-align: right;">
								@if($item['totalAreaPlanned'])
									{{round(($item['totalAreaPlanned'] / $item['totalArea']) * 100)}}%
								@else
									{{round((0 / $item['totalArea']) * 100)}}%
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</section>

	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
				<a href="#" class="fa fa-times"></a>
			</div>

			<h2 class="panel-title">
				Total Transplanted Area
			</h2>
		</header>
		<div class="panel-body">
			<h4 style="margin-top: 0px;">Year: {{$data2['year']}}</h4>
			<h4>Semester: {{($data2['sem'] == 1) ? "1st" : "2nd"}}</h4>

			<table class="table table-bordered table-responsive" style="margin-top: 10px;">
				<thead>
					<tr>
						<th style="width: 30%; text-align: center;">Station</th>
						<th style="width: 15%; text-align: center;">Code</th>
						<th style="width: 20; text-align: center;">Total Plots Area (ha)</th>
						<th style="width: 20%; text-align: center;">Total Transplanted <br /> Area (ha)</th>
						<th style="width: 15%; text-align: center;">Percent Completed</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data2['data'] as $item)
						<tr>
							<td>{{$item['station']}}</td>
							<td>{{$item['stationCode']}}</td>
							<td style="text-align: right;">{{$item['totalArea']}}</td>
							<td style="text-align: right;">
								@if(array_key_exists('totalAreaTransplanted', $item))
									{{$item['totalAreaTransplanted']}}
								@else
									0
								@endif
							</td>
							<td style="text-align: right;">
								@if(array_key_exists('totalAreaTransplanted', $item))
									{{round(($item['totalAreaTransplanted'] / $item['totalArea']) * 100)}}%
								@else
									{{round((0 / $item['totalArea']) * 100)}}%
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</section>
@endsection