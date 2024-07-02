@extends('layouts.index')

@push('styles')
	<style>
		#plotMap {
			height: 500px;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Production Plans</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('production_plans.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Production Plans</span></li>
			<li><span>View Production Plan</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<a href="{{route('production_plans.index')}}" class="btn btn-primary mb-lg"><i class="fa fa-arrow-left"></i> Back</a>

	<div class="row">
		<div class="col-md-6">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Production Plan</h2>
				</header>
				<div class="panel-body">
					<table class="table table-bordered" id="productionPlanTable">
						<tbody>
							<tr>
								<th width="40%">Status</th>
								<td>
									@if($productionPlan->is_finalized == 0)
										Pending (No Planned Activities)
									@else
										Finalized
									@endif
								</td>
							</tr>
							<tr>
								<th>Year</th>
								<td>{{$productionPlan->year}}</td>
							</tr>
							<tr>
								<th>Semester</th>
								<td>{{($productionPlan->sem == 1) ? "1st (Sept 16-Mar 15)" : "2nd (Mar 16-Sept 15)"}}</td>
							</tr>
							<tr>
								<th>Variety Planted</th>
								<td>{{$productionPlan->variety}}</td>
							</tr>
							<tr>
								<th>Target Seed Class</th>
								<td>
									@if($productionPlan->seed_class == "Breeder")
										Foundation
									@elseif($productionPlan->seed_class == "Foundation")
										Registered
									@else
										Certified
									@endif
								</td>
							</tr>
							<tr>
								<th>Seed Quantity</th>
								<td>{{$productionPlan->seed_quantity}} kg</td>
							</tr>
							<tr>
								<th>Source Seed Lot</th>
								<td>{{$productionPlan->source_seed_lot}}</td>
							</tr>
							<tr>
								<th>Barangay</th>
								<td>
									{{$productionPlan->barangay}}
								</td>
							</tr>
							<tr>
								<th>Sitio</th>
								<td>
									{{$productionPlan->sitio}}
								</td>
							</tr>
							<tr>
								<th>Rice Program</th>
								<td>
									<?php
										switch ($productionPlan->rice_program) {
											case 0:
												echo "None";
												break;
											case 1:
												echo "National Rice Program";
												break;
											case 2:
												echo "RCEF";
												break;
											case 3:
												echo "Golden Rice";
												break;
											default:
												echo "N/A";
												break;
										}
									?>
								</td>
							</tr>
							<tr>
								<th>Estimated Area</th>
								<td>
									{{ $totalArea }} ha
								</td>
							</tr>
							<tr>
								<th>Remarks</th>
								<td>
									{{($productionPlan->remarks) ? $productionPlan->remarks : "NO REMARKS"}}
								</td>
							</tr>
						</tbody>
					</table>

					<div id="plotMap"></div>
				</div>
			</section>
		</div>

		<div class="col-md-6">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Activities Calendar</h2>
				</header>
				<div class="panel-body">
					<p class="h4 text-light">Legend</p>

					<div id="external-events">
						<div class="external-event label label-primary" data-event-class="fc-event-primary">Planned Activity</div>
						<div class="external-event label label-success" data-event-class="fc-event-success">Actual Field Activity</div>
					</div>

					<div class="col-md-12 mt-lg">
						<div id="calendar"></div>
					</div>
				</div>
			</section>

			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="fa fa-caret-down"></a>
						<a href="#" class="fa fa-times"></a>
					</div>

					<h2 class="panel-title">Drone Image</h2>
				</header>
				<div class="panel-body">
					{{-- check if $drone_images is empty --}}
					@if(empty($drone_images))
						{{-- show add drone images form --}}
						<form action="{{route('production_plans.drone_images.store')}}" method="POST">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="production_plan_id" value="{{$productionPlan->production_plan_id}}">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="link">Link</label>
								<input type="text" name="link" class="form-control" required>
							</div>
							<button type="submit" class="btn btn-primary mt-4" style="margin-top: 20px;">Save</button>
						</form>
					@else	
						{{-- show drone images details --}}
						<form action="{{route('production_plans.drone_images.update')}}" method="POST">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="production_plan_id" value="{{$productionPlan->production_plan_id}}">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" id="drone_map_name" name="name" class="form-control" value="{{$drone_images->name}}" readonly>
							</div>
							<div class="form-group">
								<label for="link">Link</label>
								<input type="text" id="drone_map_link" name="link" class="form-control" value={{$drone_images->link}} readonly>
							</div>
							<button type="button" class="btn btn-warning mt-4" style="margin-top: 20px;" id="edit_drone_image">Edit</button>
							<button type="submit" class="btn btn-primary mt-4" style="margin-top: 20px; display: none;" id="save_drone_image">Save</button>
						</form>
					@endif
				</div>
			</section>

			
		</div>
	</div>
@endsection

@push('scripts')
	@include('production_plans.js.plotMap')
	@include('production_plans.js.calendar')

	<script>
		$().ready(() => {
			showPlots("{{$productionPlan->production_plan_id}}")


		})

		$('#edit_drone_image').on('click', function() {
			$('#drone_map_name').removeAttr('readonly')
			$('#drone_map_link').removeAttr('readonly')
			$('#edit_drone_image').hide()
			$('#save_drone_image').show()
		});
	</script>
@endpush