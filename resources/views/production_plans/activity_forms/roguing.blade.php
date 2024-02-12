<div id="roguing" class="tab-pane">
	<div class="row">
		<div class="col-sm-12">
			<a href="#nutrientManagement" data-toggle="tab" class="btn btn-primary" onclick="toggleNutrientManagement()"><i class="fa fa-arrow-left"></i> Back</a>
		</div>
	</div>

	<h4 class="mt-lg">10 DAT</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: rouging 10 DAT date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="roguing10DATDate" id="roguing10DATDate" class="form-control" readonly>
			</div>
			<!-- end: rouging 10 DAT date input -->
		</div>
	</div>

	<h4 class="mt-lg">20 DAT (Vegetative)</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: rouging 20 DAT date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="roguing20DATDate" id="roguing20DATDate" class="form-control" readonly>
			</div>
			<!-- end: rouging 20 DAT date input -->
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary" onclick="calculateRoguingSchedule()"><i class="fa fa-refresh"></i> Calculate Roguing Schedule</button>&nbsp;
			<a href="#pestManagement" data-toggle="tab" class="btn btn-success" onclick="togglePestManagement()" id="nextPestManagementButton" style="display: none;"><i class="fa fa-arrow-right"></i> Next</a>
		</div>
	</div>
</div>