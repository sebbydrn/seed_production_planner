<div id="seedlingManagement" class="tab-pane active">
	<h4 class="mt-lg">Seed Soaking</h4>

	<div class="row">
		<div class="col-sm-6">
			<!-- start: seed soaking start date input -->
			<div class="form-group">
				<label class="control-label">Start of Seed Soaking</label>
				<div class="row">
					<div class="col-sm-6">
						<input type="text" name="seedSoakingStartDate" id="seedSoakingStartDate" class="form-control" placeholder="Date" data-plugin-datepicker onchange="inputChange('seedSoakingStartDate')">
					</div>
					<div class="col-sm-6">
						<input type="text" name="seedSoakingStartTime" id="seedSoakingStartTime" class="form-control" placeholder="Time" onchange="inputChange('seedSoakingStartTime')">
					</div>
				</div>
			</div>
			<!-- end: seed soaking start date input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seed soaking duration input -->
			<div class="form-group">
				<label class="control-label">Duration (Hours)</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1, "max": 24}'>
					<div class="input-group input-small">
						<input type="text" name="seedSoakingDuration" id="seedSoakingDuration" class="spinner-input form-control" onblur="inputChange('seedSoakingDuration')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedSoakingDuration')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedSoakingDuration')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: seed soaking duration input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seed soaking end date input -->
			<div class="form-group">
				<label class="control-label">End of Seed Soaking (y/m/d h:m)</label>
				<input type="text" name="seedSoakingEnd" id="seedSoakingEnd" class="form-control" readonly>
			</div>
			<!-- end: seed soaking end date input -->
		</div>
	</div>

	<h4 class="mt-lg">Seed Incubation</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: seed incubation duration input -->
			<div class="form-group">
				<label class="control-label">Duration (Hours)</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1, "max": 24}'>
					<div class="input-group input-small">
						<input type="text" name="seedIncubationDuration" id="seedIncubationDuration" class="spinner-input form-control" onblur="inputChange('seedIncubationDuration')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedIncubationDuration')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedIncubationDuration')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: seed incubation duration input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seed incubation end date input -->
			<div class="form-group">
				<label class="control-label">End of Seed Incubation (y/m/d h:m)</label>
				<input type="text" name="seedIncubationEnd" id="seedIncubationEnd" class="form-control" readonly>
			</div>
			<!-- end: seed incubation end date input -->
		</div>
	</div>

	<h4 class="mt-lg">Seed Sowing</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: seed sowing duration input -->
			<div class="form-group">
				<label class="control-label">Duration (Hours)</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1, "max": 24}'>
					<div class="input-group input-small">
						<input type="text" name="seedSowingDuration" id="seedSowingDuration" class="spinner-input form-control" onblur="inputChange('seedSowingDuration')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedSowingDuration')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedSowingDuration')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: seed sowing duration input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seed sowing end date input -->
			<div class="form-group">
				<label class="control-label">End of Seed Sowing (y/m/d h:m)</label>
				<input type="text" name="seedSowingEnd" id="seedSowingEnd" class="form-control" readonly>
			</div>
			<!-- end: seed sowing end date input -->
		</div>
	</div>

	<h4 class="mt-lg">Seedbed Irrigation</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: seedbed irrigation min DAS input -->
			<div class="form-group">
				<label class="control-label">Min. DAS</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="seedbedIrrigationMinDAS" id="seedbedIrrigationMinDAS" class="spinner-input form-control" onblur="inputChange('seedbedIrrigationMinDAS')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedbedIrrigationMinDAS')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedbedIrrigationMinDAS')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: seedbed irrigation min DAS input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seedbed irrigation max DAS input -->
			<div class="form-group">
				<label class="control-label">Max. DAS</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="seedbedIrrigationMaxDAS" id="seedbedIrrigationMaxDAS" class="spinner-input form-control" onblur="inputChange('seedbedIrrigationMaxDAS')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedbedIrrigationMaxDAS')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedbedIrrigationMaxDAS')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: seedbed irrigation max DAS input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seedbed irrigation interval input -->
			<div class="form-group">
				<label class="control-label">Seedbed Irrigation Interval</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="seedbedIrrigationInterval" id="seedbedIrrigationInterval" class="spinner-input form-control" onblur="inputChange('seedbedIrrigationInterval')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedbedIrrigationInterval')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedbedIrrigationInterval')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: seedbed irrigation interval input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seedbed irrigation dates input -->
			<div class="form-group">
				<label class="control-label">Seedbed Irrigation Dates (y/m/d)</label>
				<input type="text" name="seedbedIrrigationDate1" id="seedbedIrrigationDate1" class="form-control" readonly>
			</div>
			<!-- end: seedbed irrigation dates input -->
		</div>
	</div>

	<h4 class="mt-lg">Seedling Initial Fertilizer Application</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: seedling initial fertilizer application input -->
			<div class="form-group">
				<label class="control-label">DAS</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="seedlingFertilizerAppInitDAS" id="seedlingFertilizerAppInitDAS" class="spinner-input form-control"  onblur="inputChange('seedlingFertilizerAppInitDAS')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedlingFertilizerAppInitDAS')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedlingFertilizerAppInitDAS')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: seedling initial fertilizer application input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seedling initial fertilizer application date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="seedlingFertilizerAppInitDate" id="seedlingFertilizerAppInitDate" class="form-control" readonly>
			</div>
			<!-- end: seedling initial fertilizer application date input -->
		</div>
	</div>

	<h4 class="mt-lg">Seedling Final Fertilizer Application</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: seedling final fertilizer application input -->
			<div class="form-group">
				<label class="control-label">DAS</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="seedlingFertilizerAppFinalDAS" id="seedlingFertilizerAppFinalDAS" class="spinner-input form-control"  onblur="inputChange('seedlingFertilizerAppFinalDAS')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('seedlingFertilizerAppFinalDAS')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('seedlingFertilizerAppFinalDAS')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: seedling final fertilizer application input -->
		</div>
		<div class="col-sm-3">
			<!-- start: seedling final fertilizer application date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="seedlingFertilizerAppFinalDate" id="seedlingFertilizerAppFinalDate" class="form-control" readonly>
			</div>
			<!-- end: seedling final fertilizer application date input -->
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary" onclick="calculateSeedlingManagementSchedule()"><i class="fa fa-refresh"></i> Calculate Seedling Management Schedule</button>&nbsp;
			<a href="#landPreparation" data-toggle="tab" class="btn btn-success" onclick="toggleLandPreparation()" id="nextLandPrepButton" style="display: none;"><i class="fa fa-arrow-right"></i> Next</a>
		</div>
	</div>
</div>