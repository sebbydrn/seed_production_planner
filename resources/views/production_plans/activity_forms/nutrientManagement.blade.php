<div id="nutrientManagement" class="tab-pane">
	<div class="row">
		<div class="col-sm-12">
			<a href="#waterManagement" data-toggle="tab" class="btn btn-primary" onclick="toggleWaterManagement()"><i class="fa fa-arrow-left"></i> Back</a>
		</div>
	</div>

	<h4 class="mt-lg">1st Fertilizer Application</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: 1st fertilizer application DAT input -->
			<div class="form-group">
				<label class="control-label">DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="fertilizerApp1DAT" id="fertilizerApp1DAT" class="spinner-input form-control" onblur="inputChange('fertilizerApp1DAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('fertilizerApp1DAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('fertilizerApp1DAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: 1st fertilizer application DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: 1st fertilizer application date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="fertilizerApp1Date" id="fertilizerApp1Date" class="form-control" readonly>
			</div>
			<!-- end: 1st fertilizer application date input -->
		</div>
	</div>

	<h4 class="mt-lg">2nd Fertilizer Application</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: 2nd fertilizer application DAT input -->
			<div class="form-group">
				<label class="control-label">DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="fertilizerApp2DAT" id="fertilizerApp2DAT" class="spinner-input form-control" onblur="inputChange('fertilizerApp2DAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('fertilizerApp2DAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('fertilizerApp2DAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: 2nd fertilizer application DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: 2nd fertilizer application date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="fertilizerApp2Date" id="fertilizerApp2Date" class="form-control" readonly>
			</div>
			<!-- end: 2nd fertilizer application date input -->
		</div>
	</div>

	<h4 class="mt-lg">3rd Fertilizer Application</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: 3rd fertilizer application DAT input -->
			<div class="form-group">
				<label class="control-label">DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 0}'>
					<div class="input-group input-small">
						<input type="text" name="fertilizerApp3DAT" id="fertilizerApp3DAT" class="spinner-input form-control" onblur="inputChange('fertilizerApp3DAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('fertilizerApp3DAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('fertilizerApp3DAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: 3rd fertilizer application DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: 3rd fertilizer application date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="fertilizerApp3Date" id="fertilizerApp3Date" class="form-control" readonly>
			</div>
			<!-- end: 3rd fertilizer application date input -->
		</div>
	</div>

	<h4 class="mt-lg">Final Fertilizer Application</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: final fertilizer application DAT input -->
			<div class="form-group">
				<label class="control-label">DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="fertilizerAppFinalDAT" id="fertilizerAppFinalDAT" class="spinner-input form-control" onblur="inputChange('fertilizerAppFinalDAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('fertilizerAppFinalDAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('fertilizerAppFinalDAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: final fertilizer application DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: final fertilizer application date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="fertilizerAppFinalDate" id="fertilizerAppFinalDate" class="form-control" readonly>
			</div>
			<!-- end: final fertilizer application date input -->
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary" onclick="calculateNutrientManagementSchedule()"><i class="fa fa-refresh"></i> Calculate Nutrient Management Schedule</button>&nbsp;
			<a href="#roguing" data-toggle="tab" class="btn btn-success" onclick="toggleRoguing()" id="nextRoguingButton" style="display: none;"><i class="fa fa-arrow-right"></i> Next</a>
		</div>
	</div>
</div>