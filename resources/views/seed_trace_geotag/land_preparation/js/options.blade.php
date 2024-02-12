<script>
	function setActivities() {
		let cropPhase = document.getElementById('cropPhase').value
		let activity = document.getElementById('activity')
		$('#activity').empty()

		activity.options[activity.options.length] = new Option('Select Activity', '')
		let placeholder = activity.options[0]
		placeholder.setAttribute('selected', true)
		placeholder.setAttribute('disabled', true)

		if (cropPhase == "For Seedbed") {
			activity.options[activity.options.length] = new Option('Clean and repair dike', 'Clean and repair dike')
			activity.options[activity.options.length] = new Option('Harrowing', 'Harrowing')
			activity.options[activity.options.length] = new Option('Land Soaking', 'Land Soaking')
			activity.options[activity.options.length] = new Option('Laying-out and raising beds', 'Laying-out and raising beds')
			activity.options[activity.options.length] = new Option('Levelling', 'Levelling')
			activity.options[activity.options.length] = new Option('Plowing or rotovating', 'Plowing or rotovating')
		} else {
			activity.options[activity.options.length] = new Option('Clean and repair dike', 'Clean and repair dike')
			activity.options[activity.options.length] = new Option('Harrowing', 'Harrowing')
			activity.options[activity.options.length] = new Option('Land Soaking', 'Land Soaking')
			activity.options[activity.options.length] = new Option('Levelling', 'Levelling')
			activity.options[activity.options.length] = new Option('Plowing or rotovating', 'Plowing or rotovating')
		}
	}
</script>