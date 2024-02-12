<script>
	function cropPhaseChange() {
		let cropPhase = document.getElementById('cropPhase').value
		let cropStage = document.getElementById('cropStage')
		$('#cropStage').empty()

		cropStage.options[cropStage.options.length] = new Option('Select Crop Stage', '')
		let placeholder = cropStage.options[0]
		placeholder.setAttribute('selected', true)
		placeholder.setAttribute('disabled', true)

		if (cropPhase == "Reproductive") {
			cropStage.options[cropStage.options.length] = new Option('Booting', 'Booting')
			cropStage.options[cropStage.options.length] = new Option('Flowering', 'Flowering')
			cropStage.options[cropStage.options.length] = new Option('Heading', 'Heading')
			cropStage.options[cropStage.options.length] = new Option('Panicle Initiation', 'Panicle Initiation')
		} else if (cropPhase == "Ripening") {
			cropStage.options[cropStage.options.length] = new Option('Dough Grain (hard)', 'Dough Grain (hard)')
			cropStage.options[cropStage.options.length] = new Option('Dough Grain (soft)', 'Dough Grain (soft)')
			cropStage.options[cropStage.options.length] = new Option('Mature Grain', 'Mature Grain')
			cropStage.options[cropStage.options.length] = new Option('Milk Grain', 'Milk Grain')
		} else {
			cropStage.options[cropStage.options.length] = new Option('Seedling', 'Seedling')
			cropStage.options[cropStage.options.length] = new Option('Tillering (early)', 'Tillering (early)')
			cropStage.options[cropStage.options.length] = new Option('Tillering (maximum)', 'Tillering (maximum)')
		}
	}
</script>