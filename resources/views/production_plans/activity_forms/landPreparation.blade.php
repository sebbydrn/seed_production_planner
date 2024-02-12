<div id="landPreparation" class="tab-pane">
	<div class="row">
		<div class="col-sm-12">
			<a href="#seedlingManagement" data-toggle="tab" class="btn btn-primary" onclick="toggleSeedlingManagement()"><i class="fa fa-arrow-left"></i> Back</a>
		</div>
	</div>

	<div class="alert alert-info mt-lg">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong>Need Any Help?</strong> If Land preparation is before the date of seed sowing put negative on DAS input field.
	</div>

	<h4>Plowing</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: plowing DAS input -->
			<div class="form-group">
				<label class="control-label">DAS</label>
				<input name="plowingDAS" id="plowingDAS" class="form-control" type="number" onchange="inputChange('plowingDAS')">
			</div>
			<!-- end: plowing DAS input -->
		</div>
		<div class="col-sm-3">
			<!-- start: plowing date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="plowingDate" id="plowingDate" class="form-control" readonly>
			</div>
			<!-- end: plowing date input -->
		</div>
	</div>

	<h4>1st Harrowing</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: 1st harrowing DAS input -->
			<div class="form-group">
				<label class="control-label">DAS</label>
				<input name="harrowing1DAS" id="harrowing1DAS" class="form-control" type="number" onchange="inputChange('harrowing1DAS')">
			</div>
			<!-- end: 1st harrowing DAS input -->
		</div>
		<div class="col-sm-3">
			<!-- start: 1st harrowing date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="harrowing1Date" id="harrowing1Date" class="form-control" readonly>
			</div>
			<!-- end: 1st harrowing date input -->
		</div>
	</div>

	<h4>2nd Harrowing</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: 2nd harrowing DAS input -->
			<div class="form-group">
				<label class="control-label">DAS</label>
				<input name="harrowing2DAS" id="harrowing2DAS" class="form-control" type="number" onchange="inputChange('harrowing2DAS')">
			</div>
			<!-- end: 2nd harrowing DAS input -->
		</div>
		<div class="col-sm-3">
			<!-- start: 2nd harrowing date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="harrowing2Date" id="harrowing2Date" class="form-control" readonly>
			</div>
			<!-- end: 2nd harrowing date input -->
		</div>
	</div>

	<h4>3rd Harrowing</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: 3rd harrowing DAS input -->
			<div class="form-group">
				<label class="control-label">DAS</label>
				<input name="harrowing3DAS" id="harrowing3DAS" class="form-control" type="number" onchange="inputChange('harrowing3DAS')">
			</div>
			<!-- end: 3rd harrowing DAS input -->
		</div>
		<div class="col-sm-3">
			<!-- start: 3rd harrowing date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="harrowing3Date" id="harrowing3Date" class="form-control" readonly>
			</div>
			<!-- end: 3rd harrowing date input -->
		</div>
	</div>

	<h4>Levelling</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: levelling DAS input -->
			<div class="form-group">
				<label class="control-label">DAS</label>
				<input name="levellingDAS" id="levellingDAS" class="form-control" type="number" onchange="inputChange('levellingDAS')">
			</div>
			<!-- end: levelling DAS input -->
		</div>
		<div class="col-sm-3">
			<!-- start: levelling date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="levellingDate" id="levellingDate" class="form-control" readonly>
			</div>
			<!-- end: levelling date input -->
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary" onclick="calculateLandPreparationSchedule()"><i class="fa fa-refresh"></i> Calculate Land Preparation Schedule</button>&nbsp;
			<a href="#cropEstablishment" data-toggle="tab" class="btn btn-success" onclick="toggleCropEstablishment()" id="nextCropEstablishmentButton" style="display: none;"><i class="fa fa-arrow-right"></i> Next</a>
		</div>
	</div>
</div>