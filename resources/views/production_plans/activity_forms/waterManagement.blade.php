<div id="waterManagement" class="tab-pane">
	<div class="row">
		<div class="col-sm-12">
			<a href="#cropEstablishment" data-toggle="tab" class="btn btn-primary" onclick="toggleCropEstablishment()"><i class="fa fa-arrow-left"></i> Back</a>
		</div>
	</div>

	<h4 class="mt-lg">Irrigation</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: irrigation min DAT input -->
			<div class="form-group">
				<label class="control-label">Min. DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="irrigationMinDAT" id="irrigationMinDAT" class="spinner-input form-control" onblur="inputChange('irrigationMinDAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('irrigationMinDAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('irrigationMinDAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: irrigation min DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: irrigation max DAT input -->
			<div class="form-group">
				<label class="control-label">Max. DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="irrigationMaxDAT" id="irrigationMaxDAT" class="spinner-input form-control" onblur="inputChange('irrigationMaxDAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('irrigationMaxDAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('irrigationMaxDAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: irrigation max DAS input -->
		</div>
		<div class="col-sm-3">
			<!-- start: irrigation interval input -->
			<div class="form-group">
				<label class="control-label">Irrigation Interval</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="irrigationInterval" id="irrigationInterval" class="spinner-input form-control" onblur="inputChange('irrigationInterval')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('irrigationInterval')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('irrigationInterval')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: irrigation interval input -->
		</div>
		<div class="col-sm-3">
			<!-- start: irrigation dates input -->
			<div class="form-group">
				<label class="control-label">Irrigation Dates (y/m/d)</label>
				<input type="text" name="irrigationDate1" id="irrigationDate1" class="form-control" readonly>
			</div>
			<!-- end: irrigation dates input -->
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary" onclick="calculateWaterManagementSchedule()"><i class="fa fa-refresh"></i> Calculate Water Management Schedule</button>&nbsp;
			<a href="#nutrientManagement" data-toggle="tab" class="btn btn-success" onclick="toggleNutrientManagement()" id="nextNutrientManagementButton" style="display: none;"><i class="fa fa-arrow-right"></i> Next</a>
		</div>
	</div>
</div>