<div id="pestManagement" class="tab-pane">
	<div class="row">
		<div class="col-sm-12">
			<a href="#roguing" data-toggle="tab" class="btn btn-primary" onclick="toggleRoguing()"><i class="fa fa-arrow-left"></i> Back</a>
		</div>
	</div>

	<h4 class="mt-lg">Pre-emergence Herbicide Application</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: pre-emergence herbicide application DAT input -->
			<div class="form-group">
				<label class="control-label">DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="preEmergenceAppDAT" id="preEmergenceAppDAT" class="spinner-input form-control" onblur="inputChange('preEmergenceAppDAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('preEmergenceAppDAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('preEmergenceAppDAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: pre-emergence herbicide application DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: pre-emergence herbicide application date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="preEmergenceAppDate" id="preEmergenceAppDate" class="form-control" readonly>
			</div>
			<!-- end: pre-emergence herbicide application date input -->
		</div>
	</div>

	<h4 class="mt-lg">Post-emergence Herbicide Application</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: post-emergence herbicide application DAT input -->
			<div class="form-group">
				<label class="control-label">DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="postEmergenceAppDAT" id="postEmergenceAppDAT" class="spinner-input form-control" onblur="inputChange('postEmergenceAppDAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('postEmergenceAppDAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('postEmergenceAppDAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: post-emergence herbicide application DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: post-emergence herbicide application date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="postEmergenceAppDate" id="postEmergenceAppDate" class="form-control" readonly>
			</div>
			<!-- end: post-emergence herbicide application date input -->
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary" onclick="calculatePestManagementSchedule()"><i class="fa fa-refresh"></i> Calculate Pest Management Schedule</button>&nbsp;
			<a href="#harvesting" data-toggle="tab" class="btn btn-success" onclick="toggleHarvesting()" id="nextHarvestingButton" style="display: none;"><i class="fa fa-arrow-right"></i> Next</a>
		</div>
	</div>
</div>