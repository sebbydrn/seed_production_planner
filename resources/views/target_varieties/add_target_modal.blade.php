<div id="add_target_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Target Variety To Be Planted</h4>
			</div>
			<div class="modal-body">
				<form id="add_target_form" method="post">
					<div class="form-group {{($errors->has('year')) ? 'has-error' : ''}}">
						<label class="control-label">Year</label>
						<input type="number" name="year" id="year" class="form-control" min="2023" value="{{old('year')}}">
						@if($errors->has('year'))
							<label for="year" class="error">{{$errors->first('year')}}</label>
						@endif
					</div>

					<div class="form-group {{($errors->has('sem')) ? 'has-error' : ''}}">
						<label class="control-label">Semester</label>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem1" value="1" {{(old('sem') == 1) ? 'checked' : ''}}>
								1st Semester (Sept 16-Mar 15)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="sem" id="sem2" value="2" {{(old('sem') == 2) ? 'checked' : ''}}>
								2nd Semester (Mar 16-Sept 15)
							</label>
						</div>
						@if($errors->has('sem'))
							<label for="sem" class="error">{{$errors->first('sem')}}</label>
						@endif
					</div>

					<div class="form-group {{($errors->has('seed_type')) ? 'has-error' : ''}}">
						<label class="control-label">Seed Type</label>
						<select data-plugin-selectTwo name="seed_type" id="seed_type" class="form-control mb-md populate placeholder" data-plugin-options='{ "placeholder": "Select Seed Type", "allowClear": true }' onchange="select_seed_type()">
							<option value="" selected disabled></option>
							<option value="Inbred">Inbred Seed</option>
							<option value="Hybrid">Hybrid Seed</option>
							<option value="SQR">Special Quality Rice</option>
						</select>
						@if($errors->has('seed_class'))
							<label for="seed_class" class="error">{{$errors->first('seed_class')}}</label>
						@endif
					</div>

					<div class="form-group {{($errors->has('hybrid_type')) ? 'has-error' : ''}}" style="display: none;" id="hybrid_input">
						<label class="control-label">Hybrid Seed Type</label>
						<select data-plugin-selectTwo name="hybrid_type" id="hybrid_type" class="form-control mb-md populate placeholder" data-plugin-options='{ "placeholder": "Select Hybrid Seed Type", "allowClear": true }' onchange="select_hybrid_seed_type()">
							<option value="" selected disabled></option>
							<option value="Breeder">Breeder</option>
							<option value="Parentals">Parentals</option>
							<option value="F1">F1</option>
						</select>
						@if($errors->has('hybrid_type'))
							<label for="hybrid_type" class="error">{{$errors->first('hybrid_type')}}</label>
						@endif
					</div>

					<div class="form-group {{($errors->has('parentals')) ? 'has-error' : ''}}" style="display: none;" id="parentals_input">
						<label class="control-label">Parentals</label>
						<select data-plugin-selectTwo name="parentals" id="parentals" class="form-control mb-md populate placeholder" data-plugin-options='{ "placeholder": "Select Parentals", "allowClear": true }'>
							<option value="" selected disabled></option>
							<option value="S line">S line</option>
							<option value="A line">A line</option>
							<option value="R line">R line</option>
						</select>
						@if($errors->has('parentals'))
							<label for="parentals" class="error">{{$errors->first('parentals')}}</label>
						@endif
					</div>

					<div class="form-group {{($errors->has('seed_class')) ? 'has-error' : ''}}" style="display: none;" id="seed_class_input">
						<label class="control-label">Seed Class</label>
						<select data-plugin-selectTwo name="seed_class" id="seed_class" class="form-control mb-md populate placeholder" data-plugin-options='{ "placeholder": "Select Seed Class", "allowClear": true }'>
							<option value="" selected disabled></option>
							<option value="Nucleus">Nucleus (FOR GR USE)</option>
							<option value="Breeder">Breeder</option>
							<option value="Foundation">Foundation</option>
							<option value="Registered">Registered</option>
							<option value="Certified">Certified</option>

						</select>
						@if($errors->has('seed_class'))
							<label for="seed_class" class="error">{{$errors->first('seed_class')}}</label>
						@endif
					</div>

					<div class="form-group {{($errors->has('variety')) ? 'has-error' : ''}}">
						<label class="control-label">Variety</label>
						<select data-plugin-selectTwo name="variety" id="variety" class="form-control mb-md populate placeholder" data-plugin-options='{ "placeholder": "Select Variety", "allowClear": true }'>
							<option value="" selected disabled></option>
							@foreach($varieties as $variety)
								<option value="{{$variety->variety}}">{{$variety->variety}}</option>
							@endforeach
						</select>
						@if($errors->has('variety'))
							<label for="variety" class="error">{{$errors->first('variety')}}</label>
						@endif
					</div>

					<div class="form-group {{($errors->has('area_to_be_planted')) ? 'has-error' : ''}}">
						<label class="control-label">Area To Be Planted (ha)</label>
						<input type="number" name="area_to_be_planted" id="area_to_be_planted" class="form-control" step="0.0001">
						@if($errors->has('area_to_be_planted'))
							<label for="area_to_be_planted" class="error">{{$errors->first('area_to_be_planted')}}</label>
						@endif
					</div>

					<button type="submit" class="btn btn-success" style="margin-top: 20px">Submit</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>