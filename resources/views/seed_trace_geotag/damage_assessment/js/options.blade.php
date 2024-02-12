<script>
	function damageCauseChange() {
		let damageCause = document.getElementById('damageCause').value
		let damageSpecInput = document.getElementById('damageSpecInput')

		if (damageCause == "Others") {
			damageSpecInput.style.display = 'block'
		} else {
			damageSpecInput.style.display = 'none'
		}
	}
</script>