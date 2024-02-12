<script>
	function inputChange(inputID) {
		var input = document.getElementById(inputID)
		localStorage.setItem(inputID, input.value)
	}

	document.addEventListener("DOMContentLoaded", function(event) {
		// Check if production technology has saved value in local storage
		if (localStorage.getItem('prodTech') != null) {
			document.getElementById('prodTech').value = localStorage.getItem('prodTech')
		}

		// Check if seedling age has saved value in local storage
		if (localStorage.getItem('seedlingAge') != null) {
			document.getElementById('seedlingAge').value = localStorage.getItem('seedlingAge')
		}

		// Check if seed soaking start date has saved value in local storage
		if (localStorage.getItem('seedSoakingStartDate') != null) {
			document.getElementById('seedSoakingStartDate').value = localStorage.getItem('seedSoakingStartDate')
		}

		// Check if seed soaking start time has saved value in local storage
		if (localStorage.getItem('seedSoakingStartTime') != null) {
			$('#seedSoakingStartTime').timepicker('setTime', localStorage.getItem('seedSoakingStartTime'))
		} else {
			$('#seedSoakingStartTime').timepicker()
		}

		// Check if seed soaking duration has saved value in local storage
		if (localStorage.getItem('seedSoakingDuration') != null) {
			document.getElementById('seedSoakingDuration').value = localStorage.getItem('seedSoakingDuration')
		}

		// Check if seed incubation duration has saved value in local storage
		if (localStorage.getItem('seedIncubationDuration') != null) {
			document.getElementById('seedIncubationDuration').value = localStorage.getItem('seedIncubationDuration')
		}

		// Check if seed sowing duration has saved value in local storage
		if (localStorage.getItem('seedSowingDuration') != null) {
			document.getElementById('seedSowingDuration').value = localStorage.getItem('seedSowingDuration')
		}

		// Check if seedbed irrigation min DAS has saved value in local storage
		if (localStorage.getItem('seedbedIrrigationMinDAS') != null) {
			document.getElementById('seedbedIrrigationMinDAS').value = localStorage.getItem('seedbedIrrigationMinDAS')
		}

		// Check if seedbed irrigation max DAS has saved value in local storage
		if (localStorage.getItem('seedbedIrrigationMaxDAS') != null) {
			document.getElementById('seedbedIrrigationMaxDAS').value = localStorage.getItem('seedbedIrrigationMaxDAS')
		}

		// Check if seedbed irrigation interval has saved value in local storage
		if (localStorage.getItem('seedbedIrrigationInterval') != null) {
			document.getElementById('seedbedIrrigationInterval').value = localStorage.getItem('seedbedIrrigationInterval')
		}

		// Check if seedling fertilizer application init DAS has saved value in local storage
		if (localStorage.getItem('seedlingFertilizerAppInitDAS') != null) {
			document.getElementById('seedlingFertilizerAppInitDAS').value = localStorage.getItem('seedlingFertilizerAppInitDAS')
		}

		// Check if seedling fertilizer application final DAS has saved value in local storage
		if (localStorage.getItem('seedlingFertilizerAppFinalDAS') != null) {
			document.getElementById('seedlingFertilizerAppFinalDAS').value = localStorage.getItem('seedlingFertilizerAppFinalDAS')
		}

		// Check if plowing has saved value in local storage
		if (localStorage.getItem('plowingDAS') != null) {
			document.getElementById('plowingDAS').value = localStorage.getItem('plowingDAS')
		}

		// Check if 1st harrowing has saved value in local storage
		if (localStorage.getItem('harrowing1DAS') != null) {
			document.getElementById('harrowing1DAS').value = localStorage.getItem('harrowing1DAS')
		}

		// Check if 2nd harrowing has saved value in local storage
		if (localStorage.getItem('harrowing2DAS') != null) {
			document.getElementById('harrowing2DAS').value = localStorage.getItem('harrowing2DAS')
		}

		// Check if 3rd harrowing has saved value in local storage
		if (localStorage.getItem('harrowing3DAS') != null) {
			document.getElementById('harrowing3DAS').value = localStorage.getItem('harrowing3DAS')
		}

		// Check if levelling has saved value in local storage
		if (localStorage.getItem('levellingDAS') != null) {
			document.getElementById('levellingDAS').value = localStorage.getItem('levellingDAS')
		}

		// Check if pulling to transplanting has saved value in local storage
		if (localStorage.getItem('pullingToTransplanting') != null) {
			document.getElementById('pullingToTransplanting').value = localStorage.getItem('pullingToTransplanting')
		}

		// Check if replanting window min has saved value in local storage
		if (localStorage.getItem('replantingWindowMinDAT') != null) {
			document.getElementById('replantingWindowMinDAT').value = localStorage.getItem('replantingWindowMinDAT')
		}

		// Check if replanting window max has saved value in local storage
		if (localStorage.getItem('replantingWindowMaxDAT') != null) {
			document.getElementById('replantingWindowMaxDAT').value = localStorage.getItem('replantingWindowMaxDAT')
		}

		// Check if irrigation min DAT has saved value in local storage
		if (localStorage.getItem('irrigationMinDAT') != null) {
			document.getElementById('irrigationMinDAT').value = localStorage.getItem('irrigationMinDAT')
		}

		// Check if irrigation max DAT has saved value in local storage
		if (localStorage.getItem('irrigationMaxDAT') != null) {
			document.getElementById('irrigationMaxDAT').value = localStorage.getItem('irrigationMaxDAT')
		}

		// Check if irrigation interval has saved value in local storage
		if (localStorage.getItem('irrigationInterval') != null) {
			document.getElementById('irrigationInterval').value = localStorage.getItem('irrigationInterval')
		}

		// Check if fertilizer application 1 has saved value in local storage
		if (localStorage.getItem('fertilizerApp1DAT') != null) {
			document.getElementById('fertilizerApp1DAT').value = localStorage.getItem('fertilizerApp1DAT')
		}

		// Check if fertilizer application 2 has saved value in local storage
		if (localStorage.getItem('fertilizerApp2DAT') != null) {
			document.getElementById('fertilizerApp2DAT').value = localStorage.getItem('fertilizerApp2DAT')
		}

		// Check if fertilizer application 3 has saved value in local storage
		if (localStorage.getItem('fertilizerApp3DAT') != null) {
			document.getElementById('fertilizerApp3DAT').value = localStorage.getItem('fertilizerApp3DAT')
		}

		// Check if fertilizer application final has saved value in local storage
		if (localStorage.getItem('fertilizerAppFinalDAT') != null) {
			document.getElementById('fertilizerAppFinalDAT').value = localStorage.getItem('fertilizerAppFinalDAT')
		}

		// Check if pre emergence application has saved value in local storage
		if (localStorage.getItem('preEmergenceAppDAT') != null) {
			document.getElementById('preEmergenceAppDAT').value = localStorage.getItem('preEmergenceAppDAT')
		}

		// Check if post emergence application has saved value in local storage
		if (localStorage.getItem('postEmergenceAppDAT') != null) {
			document.getElementById('postEmergenceAppDAT').value = localStorage.getItem('postEmergenceAppDAT')
		}
	})
</script>