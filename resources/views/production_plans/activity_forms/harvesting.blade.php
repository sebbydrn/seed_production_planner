<div id="harvesting" class="tab-pane">
	<div class="row">
		<div class="col-sm-12">
			<a href="#pestManagement" data-toggle="tab" class="btn btn-primary" onclick="togglePestManagement()"><i class="fa fa-arrow-left"></i> Back</a>
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-3">
			<!-- start: expected harvesting date input -->
			<div class="form-group">
				<label class="control-label">Expected Harvesting Date (y/m/d)</label>
				<input type="text" name="harvestingDate" id="harvestingDate" class="form-control" readonly>
			</div>
			<!-- end: expected harvesting date input -->
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary" onclick="calculateHarvestingSchedule()"><i class="fa fa-refresh"></i> Calculate Harvesting Schedule</button>
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" id="storeActivities" class="btn btn-lg btn-success" onclick="storeActivities({{Request::segment(3)}})" style="display: none;"><i class="fa fa-check-circle"></i> Submit & Finalize Production Plan</button>
		</div>
	</div>
</div>