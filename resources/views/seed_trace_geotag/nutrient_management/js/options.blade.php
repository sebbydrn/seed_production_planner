<script>
	function fertilizerChange() {
		let fertilizerUsed = document.getElementById('fertilizerUsed').value
		let otherFertilizerInput = document.getElementById('otherFertilizerInput')

		if (fertilizerUsed == "Others") {
			otherFertilizerInput.style.display = 'block'
		} else {
			otherFertilizerInput.style.display = 'none'
		}
	}

	function formulationChange() {
		let formulation = document.getElementById('formulation').value
		let unit = document.getElementById('unit')
		let totalChemicalUsedInput = document.getElementById('totalChemicalUsedInput')
		let tankLoadNoInput = document.getElementById('tankLoadNoInput')
		let tankLoadVolumeInput = document.getElementById('tankLoadVolumeInput')
		let tankLoadRateInput = document.getElementById('tankLoadRateInput')
		$('#unit').empty()

		unit.options[unit.options.length] = new Option('Select Unit', '')
		let placeholder = unit.options[0]
		placeholder.setAttribute('selected', true)
		placeholder.setAttribute('disabled', true)

		if (formulation == "Granular") {
			unit.options[unit.options.length] = new Option('Gram (g)', 'Gram (g)')
			unit.options[unit.options.length] = new Option('Kilogram (kg)', 'Kilogram (kg)')
			totalChemicalUsedInput.style.display = 'block'
			tankLoadNoInput.style.display = 'none'
			tankLoadVolumeInput.style.display = 'none'
			tankLoadRateInput.style.display = 'none'
		} else {
			unit.options[unit.options.length] = new Option('Liter (l)', 'Liter (l)')
			unit.options[unit.options.length] = new Option('Milliliter (ml)', 'Milliliter (ml)')
			totalChemicalUsedInput.style.display = 'none'
			tankLoadNoInput.style.display = 'block'
			tankLoadVolumeInput.style.display = 'block'
			tankLoadRateInput.style.display = 'block'
		}
	}
</script>