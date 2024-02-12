@extends('layouts.index')

@push('styles')
	<style>
		.dataTables_filter label {
			display: inline;
		}
	</style>
@endpush

@section('pageHeader')
	<h2>Add Production Cost Schedule</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="{{route('production_cost_schedule.index')}}">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><a href="{{route('production_cost_schedule.index')}}">Production Cost Schedule</a></li>
			<li><span>Add Production Cost Schedule</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
@endsection

@section('pageContent')
	<h3 class="text-center" style="margin-bottom: 5px;">PROJECTED SEED PRODUCTION COST</h3>
	<h3 class="text-center mb-xl" style="margin-top: 5px;"><i>Semester 1 & Semester 2</i></h3>

	<section class="panel">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-4 col-md-12">
					<div class="form-group">
						<label class="control-label">Year</label>
						<input type="number" name="year" id="year" class="form-control year" min="2023" step="1">
					</div>
				</div>

				<div class="col-lg-4 col-md-12">
					<div class="form-group">
						<label class="control-label">Seed production for</label>
						<select name="seed_production_type" id="seed_production_type" class="form-control seed_production_type" onchange="select_production_type()">
							<option value="" selected="selected" disabled="disabled">Select seed production for</option>
							<option value="Inbred">Inbred</option>
							<option value="Hybrid (AxR)">Hybrid (AxR)</option>
							<option value="Hybrid (P and R)">Hybrid (P and R)</option>
							<option value="Hybrid (S)">Hybrid (S)</option>
							<option value="Hybrid (A)">Hybrid (A)</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-12 mt-lg">
					<div class="form-group">
						<label class="control-label">Area on-station (in ha)</label>
						<input type="number" name="area_on_station" id="area_on_station" class="form-control" oninput="add_seed_production_area()" value="0">
					</div>
				</div>

				<div class="col-lg-4 col-md-12 mt-lg">
					<div class="form-group">
						<label class="control-label">Area outside station (station-managed) (in ha)</label>
						<input type="number" name="area_out_station" id="area_out_station" class="form-control" oninput="add_seed_production_area()" value="0">
					</div>
				</div>

				<div class="col-lg-4 col-md-12 mt-lg">
					<div class="form-group">
						<label class="control-label">Area from seed production contracting (in ha)</label>
						<input type="number" name="area_contracting" id="area_contracting" class="form-control" oninput="add_seed_production_area()" value="0">
					</div>
				</div>

				<div class="col-lg-4 col-md-12 mt-lg">
					<div class="form-group">
						<label class="control-label">Total seed production area (in ha)</label>
						<input type="text" name="total_production_area" id="total_production_area" class="form-control" readonly="readonly">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-12 mt-lg">
					<div class="form-group">
						<label class="control-label">Remarks</label>
						<textarea name="remarks" id="remarks" class="form-control" rows="5"></textarea>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
			</div>

			<h2 class="panel-title">I. PRODUCTION COST SCHEDULE</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered cost_components" style="width: 100%;">
				<thead>
					<tr class="success">
						<th style="width: 50%;">Cost Components/Activities</th>
					</tr>
				</thead>
				<tbody>
					@include('production_cost_schedule.forms.land_preparation')
					@include('production_cost_schedule.forms.seed_pulling')
					@include('production_cost_schedule.forms.chemicals_fertilizers')
					@include('production_cost_schedule.forms.harvesting')
					@include('production_cost_schedule.forms.drying')
					@include('production_cost_schedule.forms.seed_cleaning')
					@include('production_cost_schedule.forms.service_contractors')
					@include('production_cost_schedule.forms.planting_materials')
					@include('production_cost_schedule.forms.field_supplies')
					@include('production_cost_schedule.forms.fuel')
					@include('production_cost_schedule.forms.irrigation')
					@include('production_cost_schedule.forms.seed_lab')
					@include('production_cost_schedule.forms.land_rental')
					@include('production_cost_schedule.forms.production_contracting')
				</tbody>
			</table>
		</div>
	</section>

	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
			</div>

			<h2 class="panel-title">II. PRODUCTION COST SUMMARY</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered" style="width: 100%;">
				<thead>
					<tr class="warning">
						<th colspan="2" class="text-center">COST COMPONENTS</th>
						<th class="text-center">Sem 1</th>
						<th class="text-center">Sem 2</th>
						<th class="text-center">Total (P)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="text-center" style="width: 5%;">A.</th>
						<td style="width: 35%">Land Preparation</td>
						<td class="text-right component_s1" style="width: 20%" id="land_preparation_sem1">0.00</td>
						<td class="text-right component_s2" style="width: 20%" id="land_preparation_sem2">0.00</td>
						<td class="text-right" style="width: 20%" id="land_preparation_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">B.</th>
						<td>Seed Pulling, Marking & Transplanting</td>
						<td class="text-right component_s1" id="seed_pulling_s1">0.00</td>
						<td class="text-right component_s2" id="seed_pulling_s2">0.00</td>
						<td class="text-right" id="seed_pulling_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">C.</th>
						<td>Chemicals & Fertilizers</td>
						<td class="text-right component_s1" id="fertilizers_s1">0.00</td>
						<td class="text-right component_s2" id="fertilizers_s2">0.00</td>
						<td class="text-right" id="fertilizer_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">D.</th>
						<td>Harvesting</td>
						<td class="text-right component_s1" id="harvesting_s1">0.00</td>
						<td class="text-right component_s2" id="harvesting_s2">0.00</td>
						<td class="text-right" id="harvesting_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">E.</th>
						<td>Drying</td>
						<td class="text-right component_s1" id="drying_s1">0.00</td>
						<td class="text-right component_s2" id="drying_s2">0.00</td>
						<td class="text-right" id="drying_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">F.</th>
						<td>Seed Cleaning</td>
						<td class="text-right component_s1" id="cleaning_s1">0.00</td>
						<td class="text-right component_s2" id="cleaning_s2">0.00</td>
						<td class="text-right" id="cleaning_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">G.</th>
						<td>Service Contractors</td>
						<td class="text-right component_s1" id="service_contract_s1">0.00</td>
						<td class="text-right component_s2" id="service_contract_s2">0.00</td>
						<td class="text-right" id="service_contract_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">H.</th>
						<td>Planting Materials</td>
						<td class="text-right component_s1" id="planting_s1">0.00</td>
						<td class="text-right component_s2" id="planting_s2">0.00</td>
						<td class="text-right" id="planting_materials_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">I.</th>
						<td>Field Supplies</td>
						<td class="text-right component_s1" id="field_supplies_s1">0.00</td>
						<td class="text-right component_s2" id="field_supplies_s2">0.00</td>
						<td class="text-right" id="field_supplies_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">J.</th>
						<td>Fuel, Oil and Lubricants</td>
						<td class="text-right component_s1" id="fuel_s1">0.00</td>
						<td class="text-right component_s2" id="fuel_s2">0.00</td>
						<td class="text-right" id="fuel_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">K.</th>
						<td>Irrigation Fee</td>
						<td class="text-right component_s1" id="irrigation_s1">0.00</td>
						<td class="text-right component_s2" id="irrigation_s2">0.00</td>
						<td class="text-right" id="irrigation_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">L.</th>
						<td>Seed Laboratory Fee</td>
						<td class="text-right component_s1" id="seed_lab_s1">0.00</td>
						<td class="text-right component_s2" id="seed_lab_s2">0.00</td>
						<td class="text-right" id="seed_lab_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">M.</th>
						<td>Land Rental</td>
						<td class="text-right component_s1" id="land_rental_s1">0.00</td>
						<td class="text-right component_s2" id="land_rental_s2">0.00</td>
						<td class="text-right" id="land_rental_component">0.00</td>
					</tr>
					<tr>
						<th class="text-center">N.</th>
						<td>Seed Production Contracting</td>
						<td class="text-right component_s1" id="production_contracting_s1">0.00</td>
						<td class="text-right component_s2" id="production_contracting_s2">0.00</td>
						<td class="text-right" id="production_contracting_component">0.00</td>
					</tr>
				</tbody>
				<tfoot class="production_cost_summary">
					<tr class="primary">
						<th colspan="2" class="text-right">TOTAL PRODUCTION COST (P)</th>
						<th class="text-right" id="total_prod_cost_s1">0.00</th>
						<th class="text-right" id="total_prod_cost_s2">0.00</th>
						<th class="text-right" id="total_prod_cost">0.00</th>
					</tr>
					<tr>
						<td></td>
						<td><i class="total_area_for_production_label1">Total FS-RS area (ha)</i></td>
						<td class="text-right"><i class="area1_s1" id="area1_s1">0.00</i></td>
						<td class="text-right"><i class="area1_s2" id="area1_s2">0.00</i></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><i class="total_area_for_production_label2">Total BS-FS area (ha)</i></td>
						<td class="text-right"><i class="area2_s1" id="area2_s1">0.00</i></td>
						<td class="text-right"><i class="area2_s2" id="area2_s2">0.00</i></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><i class="volume_clean_seeds1">Volume of clean seeds, FS-RS (kg)</i></td>
						<td class="text-right"><i class="clean_seed1_s1" id="clean_seed1_s1">0.00</i></td>
						<td class="text-right"><i class="clean_seed1_s2" id="clean_seed1_s2">0.00</i></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><i class="volume_clean_seeds2">Volume of clean seeds, BS-FS (kg)</i></td>
						<td class="text-right"><i class="clean_seed2_s1" id="clean_seed2_s1">0.00</i></td>
						<td class="text-right"><i class="clean_seed2_s2" id="clean_seed2_s2">0.00</i></td>
						<td></td>
					</tr>
					<tr>
						<th class="primary"></th>
						<th class="text-right primary"><i>Total Clean Seeds Produced (kg)</i></th>
						<th class="text-right primary"><i class="clean_seeds_total_s1" id="clean_seeds_total_s1">0.00</i></th>
						<th class="text-right primary"><i class="clean_seeds_total_s2" id="clean_seeds_total_s2">0.00</i></th>
						<th></th>
					</tr>
					<tr>
						<th class="primary"></th>
						<th class="text-right primary"><i>Production Cost per Kilo (P/kg)</i></th>
						<th class="text-right primary"><i class="prod_cost_kilo_s1" id="prod_cost_kilo_s1">0.00</i></th>
						<th class="text-right primary"><i class="prod_cost_kilo_s2" id="prod_cost_kilo_s2">0.00</i></th>
						<th></th>
					</tr>
					<tr>
						<th class="primary"></th>
						<th class="text-right primary"><i>Production Cost per Hectare (P/ha)</i></th>
						<th class="text-right primary"><i class="prod_cost_ha_s1" id="prod_cost_ha_s1">0.00</i></th>
						<th class="text-right primary"><i class="prod_cost_ha_s2" id="prod_cost_ha_s2">0.00</i></th>
						<th></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="panel-footer">
			<div class="text-center mt-lg mb-lg">
				<button class="btn btn-success btn-lg" onclick="submit()">Submit for Approval</button>
			</div>
		</div>
	</section>
@endsection

@push('scripts')

	@include('production_cost_schedule.js.form')
	@include('production_cost_schedule.js.computation')
@endpush