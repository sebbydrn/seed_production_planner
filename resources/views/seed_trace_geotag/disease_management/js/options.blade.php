<script>
	function diseaseChange() {
		let disease = document.getElementById('disease').value
		let otherDiseaseInput = document.getElementById('otherDiseaseInput')

		if (disease == "Others") {
			otherDiseaseInput.style.display = 'block'
		} else {
			otherDiseaseInput.style.display = 'none'
		}
	}

	function controlTypeChange() {
		let controlType = document.getElementById('controlType').value
		let controlSpecInput = document.getElementById('controlSpecInput')
		let chemicalUsedInput = document.getElementById('chemicalUsedInput')
		let activeIngredientInput = document.getElementById('activeIngredientInput')
		let applicationModeInput = document.getElementById('applicationModeInput')
		let brandNameInput = document.getElementById('brandNameInput')
		let formulationInput = document.getElementById('formulationInput')
		let unitInput = document.getElementById('unitInput')

		if (controlType == "Chemical") {
			controlSpecInput.style.display = 'none'
			chemicalUsedInput.style.display = 'block'
			activeIngredientInput.style.display = 'block'
			applicationModeInput.style.display = 'block'
			brandNameInput.style.display = 'block'
			formulationInput.style.display = 'block'
			unitInput.style.display = 'block'
		} else {
			controlSpecInput.style.display = 'block'
			chemicalUsedInput.style.display = 'none'
			activeIngredientInput.style.display = 'none'
			applicationModeInput.style.display = 'none'
			brandNameInput.style.display = 'none'
			formulationInput.style.display = 'none'
			unitInput.style.display = 'none'
		}
	}

	function applicationModeChange() {
		let applicationMode = document.getElementById('applicationMode').value
		let formulation = document.getElementById('formulation')
		$('#formulation').empty()

		formulation.options[formulation.options.length] = new Option('Select Formulation', '')
		let placeholder = formulation.options[0]
		placeholder.setAttribute('selected', true)
		placeholder.setAttribute('disabled', true)

		if (applicationMode == "Broadcast") {
			formulation.options[formulation.options.length] = new Option('Granular', 'Granular')
			formulation.options[formulation.options.length] = new Option('Powder', 'Powder')
		} else {
			formulation.options[formulation.options.length] = new Option('Liquid', 'Liquid')
			formulation.options[formulation.options.length] = new Option('Powder', 'Powder')
		}
	}

	function formulationChange() {
		let applicationMode = document.getElementById('applicationMode').value
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

		if (applicationMode == "Broadcast" && formulation == "Granular") {
			unit.options[unit.options.length] = new Option('Gram (g)', 'Gram (g)')
			unit.options[unit.options.length] = new Option('Kilogram (kg)', 'Kilogram (kg)')
			totalChemicalUsedInput.style.display = 'block'
			tankLoadNoInput.style.display = 'none'
			tankLoadVolumeInput.style.display = 'none'
			tankLoadRateInput.style.display = 'none'
		} else if (applicationMode == "Broadcast" && formulation == "Powder") {
			unit.options[unit.options.length] = new Option('Gram (g)', 'Gram (g)')
			unit.options[unit.options.length] = new Option('Kilogram (kg)', 'Kilogram (kg)')
			unit.options[unit.options.length] = new Option('Milligram (mg)', 'Milligram (mg)')
			totalChemicalUsedInput.style.display = 'block'
			tankLoadNoInput.style.display = 'none'
			tankLoadVolumeInput.style.display = 'none'
			tankLoadRateInput.style.display = 'none'
		} else if (applicationMode == "Spray" && formulation == "Powder") {
			unit.options[unit.options.length] = new Option('Gram (g)', 'Gram (g)')
			unit.options[unit.options.length] = new Option('Kilogram (kg)', 'Kilogram (kg)')
			unit.options[unit.options.length] = new Option('Milligram (mg)', 'Milligram (mg)')
			totalChemicalUsedInput.style.display = 'none'
			tankLoadNoInput.style.display = 'block'
			tankLoadVolumeInput.style.display = 'block'
			tankLoadRateInput.style.display = 'block'
		} else if (applicationMode == "Spray" && formulation == "Liquid") {
			unit.options[unit.options.length] = new Option('Liter (l)', 'Liter (l)')
			unit.options[unit.options.length] = new Option('Milliliter (ml)', 'Milliliter (ml)')
			totalChemicalUsedInput.style.display = 'none'
			tankLoadNoInput.style.display = 'block'
			tankLoadVolumeInput.style.display = 'block'
			tankLoadRateInput.style.display = 'block'
		}
	}
</script>