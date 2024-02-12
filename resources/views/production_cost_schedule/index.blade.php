@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Production Cost Schedule</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('production_cost_schedule.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Production Cost Schedule</span></li>
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

			<h2 class="panel-title">Production Cost Schedule</h2>
		</header>
		<div class="panel-body">
			<a href="{{route('production_cost_schedule.create')}}" class="btn btn-success mb-lg">Create Production Cost Schedule</a>

			<table class="table table-bordered" id="production_cost_schedule_table" style="width: 100%;">
				<thead>
					<tr>
						<th>Station</th>
						<th class="text-center">Year</th>
						<th class="text-center">Status</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
			</table>
		</div>
	</section>
@endsection

@push('scripts')
	@include('production_cost_schedule.js.datatable')

	<script>
		function delete_schedule(production_cost_id) {
			if (confirm("Delete Production Cost Schedule?") == true) {
				$.ajax({
					type: "DELETE",
					url: "production_cost_schedule/"+production_cost_id,
					data: {
						_token: "{{csrf_token()}}"
					},
					success: (res) => {
						if (res == "success") {
							alert('Success');
							location.reload();
						}
					}
				});
			}
		}
	</script>
@endpush