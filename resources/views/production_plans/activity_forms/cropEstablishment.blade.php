<div id="cropEstablishment" class="tab-pane">
	<div class="row">
		<div class="col-sm-12">
			<a href="#landPreparation" data-toggle="tab" class="btn btn-primary" onclick="toggleLandPreparation()"><i class="fa fa-arrow-left"></i> Back</a>
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-3">
			<!-- start: pulling to transplanting DAS input -->
			<div class="form-group">
				<label class="control-label">Pulling to Transplanting</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="pullingToTransplanting" id="pullingToTransplanting" class="spinner-input form-control" onblur="inputChange('pullingToTransplanting')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('pullingToTransplanting')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('pullingToTransplanting')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: pulling to transplanting DAS input -->
		</div>
	</div>

	<h4 class="mt-lg">Transplanting</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: transplanting date input -->
			<div class="form-group">
				<label class="control-label">Date (y/m/d)</label>
				<input type="text" name="transplantingDate" id="transplantingDate" class="form-control" readonly>
			</div>
			<!-- end: transplanting date input -->
		</div>
	</div>

	<h4 class="mt-lg">Replanting</h4>

	<div class="row">
		<div class="col-sm-3">
			<!-- start: replanting window min DAT input -->
			<div class="form-group">
				<label class="control-label">Min. DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="replantingWindowMinDAT" id="replantingWindowMinDAT" class="spinner-input form-control" onblur="inputChange('replantingWindowMinDAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('replantingWindowMinDAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('replantingWindowMinDAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: replanting window min DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: replanting window max DAT input -->
			<div class="form-group">
				<label class="control-label">Max. DAT</label>
				<div data-plugin-spinner data-plugin-options='{"value": 0, "min": 1}'>
					<div class="input-group input-small">
						<input type="text" name="replantingWindowMaxDAT" id="replantingWindowMaxDAT" class="spinner-input form-control" onblur="inputChange('replantingWindowMaxDAT')">
						<div class="spinner-buttons input-group-btn">
							<button type="button" class="btn spinner-up btn-default" onclick="inputChange('replantingWindowMaxDAT')">
								<i class="fa fa-angle-up"></i>
							</button>
							<button type="button" class="btn spinner-down btn-default" onclick="inputChange('replantingWindowMaxDAT')">
								<i class="fa fa-angle-down"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end: replanting window max DAT input -->
		</div>
		<div class="col-sm-3">
			<!-- start: replanting window dates input -->
			<div class="form-group">
				<label class="control-label">Replanting Window Dates (y/m/d)</label>
				<input type="text" name="replantingWindowDate" id="replantingWindowDate" class="form-control" readonly>
			</div>
			<!-- end: replanting window dates input -->
		</div>
	</div>

	<div class="row mt-lg">
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary" onclick="calculateCropEstablishmentSchedule()"><i class="fa fa-refresh"></i> Calculate Crop Establishment Schedule</button>&nbsp;
			<a href="#waterManagement" data-toggle="tab" class="btn btn-success" onclick="toggleWaterManagement()" id="nextWaterManagementButton" style="display: none;"><i class="fa fa-arrow-right"></i> Next</a>
		</div>
	</div>
</div>