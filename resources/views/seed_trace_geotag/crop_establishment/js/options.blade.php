<script>
	function activityChange() {
		let activity = document.getElementById('activity').value
		let transplantingMethodInput = document.getElementById('transplantingMethodInput')

		if (activity == "Transplanting") {
			transplantingMethodInput.style.display = 'block'
		} else {
			transplantingMethodInput.style.display = 'none'
		}
	}
</script>