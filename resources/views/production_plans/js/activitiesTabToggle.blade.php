<script>
	function toggleSeedlingManagement() {
		document.getElementById('landPreparationTab').classList.remove('active')
		document.getElementById('seedlingManagementTab').classList.add('active')
	}

	function toggleLandPreparation() {
		document.getElementById('seedlingManagementTab').classList.remove('active')
		document.getElementById('landPreparationTab').classList.add('active')
		document.getElementById('cropEstablishmentTab').classList.remove('active')
	}

	function toggleCropEstablishment() {
		document.getElementById('landPreparationTab').classList.remove('active')
		document.getElementById('cropEstablishmentTab').classList.add('active')
		document.getElementById('waterManagementTab').classList.remove('active')
	}

	function toggleWaterManagement() {
		document.getElementById('cropEstablishmentTab').classList.remove('active')
		document.getElementById('waterManagementTab').classList.add('active')
		document.getElementById('nutrientManagementTab').classList.remove('active')
	}

	function toggleNutrientManagement() {
		document.getElementById('waterManagementTab').classList.remove('active')
		document.getElementById('nutrientManagementTab').classList.add('active')
		document.getElementById('roguingTab').classList.remove('active')
	}

	function toggleRoguing() {
		document.getElementById('nutrientManagementTab').classList.remove('active')
		document.getElementById('roguingTab').classList.add('active')
		document.getElementById('pestManagementTab').classList.remove('active')
	}

	function togglePestManagement() {
		document.getElementById('roguingTab').classList.remove('active')
		document.getElementById('pestManagementTab').classList.add('active')
		document.getElementById('harvestingTab').classList.remove('active')
	}

	function toggleHarvesting() {
		document.getElementById('pestManagementTab').classList.remove('active')
		document.getElementById('harvestingTab').classList.add('active')
	}
</script>