<script>
	let maturity
	let seedSoakingStart
	let seedlingAge
	let seedSowingEnd
	let pullingToTransplanting
	let transplantingDate

	function year(date) {
		return date.getFullYear()
	}

	function month(date) {
		return `${date.getMonth() + 1}`.padStart(2, '0')
	}

	function dayDate(date) {
		return `${date.getDate()}`.padStart(2, '0')
	}

	function hours(date) {
		return `${date.getHours()}`.padStart(2, '0')
	}

	function minutes(date) {
		return `${date.getMinutes()}`.padStart(2, '0')
	}

	function calculateSeedlingManagementSchedule() {
		let seedSoakingStartDate = document.getElementById('seedSoakingStartDate').value
		let seedSoakingStartTime = document.getElementById('seedSoakingStartTime').value
		let seedSoakingDuration = document.getElementById('seedSoakingDuration').value
		let seedIncubationDuration = document.getElementById('seedIncubationDuration').value
		let seedSowingDuration = document.getElementById('seedSowingDuration').value
		let seedbedIrrigationMinDAS = document.getElementById('seedbedIrrigationMinDAS').value
		let seedbedIrrigationMaxDAS = document.getElementById('seedbedIrrigationMaxDAS').value
		let seedbedIrrigationInterval = document.getElementById('seedbedIrrigationInterval').value
		let seedlingFertilizerAppInitDAS = document.getElementById('seedlingFertilizerAppInitDAS').value
		let seedlingFertilizerAppFinalDAS = document.getElementById('seedlingFertilizerAppFinalDAS').value
		seedlingAge = document.getElementById('seedlingAge').value

		if (seedSoakingStartDate == "" || seedSoakingStartTime == "" || seedSoakingDuration == 0 || seedIncubationDuration == 0 || seedSowingDuration == 0 || seedbedIrrigationMinDAS == 0 || seedbedIrrigationMaxDAS == 0 || seedbedIrrigationInterval == 0 || seedlingFertilizerAppInitDAS == 0 || seedlingAge == 0) {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		// Hide the next button
			document.getElementById('nextLandPrepButton').style.display = 'none'
		} else {
			seedSoakingStart = new Date(seedSoakingStartDate + ' ' + seedSoakingStartTime)

			let seedSoakingEnd = new Date(seedSoakingStart)
			seedSoakingEnd.setHours(seedSoakingEnd.getHours() + parseInt(seedSoakingDuration))
			document.getElementById('seedSoakingEnd').value = year(seedSoakingEnd) + "/" + month(seedSoakingEnd) + "/" + dayDate(seedSoakingEnd) + " " + hours(seedSoakingEnd) + ":" + minutes(seedSoakingEnd)

			let seedIncubationEnd = new Date(seedSoakingEnd)
			seedIncubationEnd.setHours(seedIncubationEnd.getHours() + parseInt(seedIncubationDuration))
			document.getElementById('seedIncubationEnd').value = year(seedIncubationEnd) + "/" + month(seedIncubationEnd) + "/" + dayDate(seedIncubationEnd) + " " + hours(seedIncubationEnd) + ":" + minutes(seedIncubationEnd)

			seedSowingEnd = new Date(seedIncubationEnd)
			seedSowingEnd.setHours(seedSowingEnd.getHours() + parseInt(seedSowingDuration))
			document.getElementById('seedSowingEnd').value = year(seedSowingEnd) + "/" + month(seedSowingEnd) + "/" + dayDate(seedSowingEnd) + " " + hours(seedSowingEnd) + ":" + minutes(seedSowingEnd)

			let seedbedIrrigationCount = Math.round((parseInt(seedlingAge) - parseInt(seedbedIrrigationMinDAS)) / parseInt(seedbedIrrigationInterval))

			let seedbedIrrigationMinDate = new Date(seedSowingEnd)
			seedbedIrrigationMinDate.setDate(seedbedIrrigationMinDate.getDate() + parseInt(seedbedIrrigationMinDAS))
			let seedbedIrrigationMaxDate = new Date(seedSowingEnd)
			seedbedIrrigationMaxDate.setDate(seedbedIrrigationMaxDate.getDate() + parseInt(seedbedIrrigationMaxDAS))
			document.getElementById('seedbedIrrigationDate1').value = year(seedbedIrrigationMinDate) + "/" + month(seedbedIrrigationMinDate) + "/" + dayDate(seedbedIrrigationMinDate) + "-" + year(seedbedIrrigationMaxDate) + "/" + month(seedbedIrrigationMaxDate) + "/" + dayDate(seedbedIrrigationMaxDate)
			
			let seedbedIrrigationDateInputCount = 2
			let seedbedIrrigationDateInputs = ""

			// Remove seedbed irrigation dates for re-calculation
			$('.seedbedIrrigationDates').remove()

			let seedbedIrrigationMinDateIterate
			let seedbedIrrigationMaxDateIterate

			for (let i=1; i<=seedbedIrrigationCount; ++i) {
				seedbedIrrigationMinDateIterate = new Date(seedbedIrrigationMinDate)
				seedbedIrrigationMaxDateIterate = new Date(seedbedIrrigationMaxDate)

				seedbedIrrigationMinDateIterate.setDate(seedbedIrrigationMinDateIterate.getDate() + (parseInt(seedbedIrrigationInterval) * i))
				seedbedIrrigationMaxDateIterate.setDate(seedbedIrrigationMaxDateIterate.getDate() + (parseInt(seedbedIrrigationInterval) * i))

				let seedbedIrrigationDateInputValue = "" + year(seedbedIrrigationMinDateIterate) + "/" + month(seedbedIrrigationMinDateIterate) + "/" + dayDate(seedbedIrrigationMinDateIterate) + "-" + year(seedbedIrrigationMaxDateIterate) + "/" + month(seedbedIrrigationMaxDateIterate) + "/" + dayDate(seedbedIrrigationMaxDateIterate) + ""

				seedbedIrrigationDateInputs += '<input type="text" name="seedbedIrrigationDate'+seedbedIrrigationDateInputCount+'" id="seedbedIrrigationDate'+seedbedIrrigationDateInputCount+'" class="form-control mt-md seedbedIrrigationDates" value="'+seedbedIrrigationDateInputValue+'" readonly>'
				++seedbedIrrigationDateInputCount
			}

			$(seedbedIrrigationDateInputs).insertAfter('#seedbedIrrigationDate1')

			let seedlingFertilizerAppInitDate = new Date(seedSowingEnd)
			seedlingFertilizerAppInitDate.setDate(seedlingFertilizerAppInitDate.getDate() + parseInt(seedlingFertilizerAppInitDAS))
			document.getElementById('seedlingFertilizerAppInitDate').value = year(seedlingFertilizerAppInitDate) + "/" + month(seedlingFertilizerAppInitDate) + "/" + dayDate(seedlingFertilizerAppInitDate)

			if (seedlingFertilizerAppFinalDAS > 0) {
				let seedlingFertilizerAppFinalDate = new Date(seedSowingEnd)
				seedlingFertilizerAppFinalDate.setDate(seedlingFertilizerAppFinalDate.getDate() + parseInt(seedlingFertilizerAppFinalDAS))
				document.getElementById('seedlingFertilizerAppFinalDate').value = year(seedlingFertilizerAppFinalDate) + "/" + month(seedlingFertilizerAppFinalDate) + "/" + dayDate(seedlingFertilizerAppFinalDate)
			}

			// Show the next button
			document.getElementById('nextLandPrepButton').style.display = 'inline-block'
		}

		// Save seedling management inputs to local storage	
		localStorage.setItem("seedlingAge", seedlingAge)
		localStorage.setItem("seedSoakingStartDate", seedSoakingStartDate)
		localStorage.setItem("seedSoakingStartTime", seedSoakingStartTime)
		localStorage.setItem("seedSoakingDuration", seedSoakingDuration)
		localStorage.setItem("seedIncubationDuration", seedIncubationDuration)
		localStorage.setItem("seedSowingDuration", seedSowingDuration)
		localStorage.setItem("seedbedIrrigationMinDAS", seedbedIrrigationMinDAS)
		localStorage.setItem("seedbedIrrigationMaxDAS", seedbedIrrigationMaxDAS)
		localStorage.setItem("seedbedIrrigationInterval", seedbedIrrigationInterval)
		localStorage.setItem("seedlingFertilizerAppInitDAS", seedlingFertilizerAppInitDAS)
		localStorage.setItem("seedlingFertilizerAppFinalDAS", seedlingFertilizerAppFinalDAS)
	}

	function calculateLandPreparationSchedule() {
		let plowingDAS = document.getElementById('plowingDAS').value
		let harrowing1DAS = document.getElementById('harrowing1DAS').value
		let harrowing2DAS = document.getElementById('harrowing2DAS').value
		let harrowing3DAS = document.getElementById('harrowing3DAS').value
		let levellingDAS = document.getElementById('levellingDAS').value
		seedlingAge = document.getElementById('seedlingAge').value

		if (plowingDAS == 0 || harrowing1DAS == 0 || harrowing2DAS == 0 || harrowing3DAS == 0 || levellingDAS == 0 || seedlingAge == 0) {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		// Hide the next button
			document.getElementById('nextCropEstablishmentButton').style.display = 'none'
		} else {
			let plowingDate = new Date(seedSowingEnd)
			plowingDate.setDate(plowingDate.getDate() + parseInt(plowingDAS))
			document.getElementById('plowingDate').value = year(plowingDate) + "/" + month(plowingDate) + "/" + dayDate(plowingDate)

			let harrowing1Date = new Date(seedSowingEnd)
			harrowing1Date.setDate(harrowing1Date.getDate() + parseInt(harrowing1DAS))
			document.getElementById('harrowing1Date').value = year(harrowing1Date) + "/" + month(harrowing1Date) + "/" + dayDate(harrowing1Date)

			let harrowing2Date = new Date(seedSowingEnd)
			harrowing2Date.setDate(harrowing2Date.getDate() + parseInt(harrowing2DAS))
			document.getElementById('harrowing2Date').value = year(harrowing2Date) + "/" + month(harrowing2Date) + "/" + dayDate(harrowing2Date)

			let harrowing3Date = new Date(seedSowingEnd)
			harrowing3Date.setDate(harrowing3Date.getDate() + parseInt(harrowing3DAS))
			document.getElementById('harrowing3Date').value = year(harrowing3Date) + "/" + month(harrowing3Date) + "/" + dayDate(harrowing3Date)

			let levellingDate = new Date(seedSowingEnd)
			levellingDate.setDate(levellingDate.getDate() + parseInt(levellingDAS))
			document.getElementById('levellingDate').value = year(levellingDate) + "/" + month(levellingDate) + "/" + dayDate(levellingDate)

			// Show the next button
			document.getElementById('nextCropEstablishmentButton').style.display = 'inline-block'
		}

		// Save land preparation inputs to local storage
		localStorage.setItem("plowingDAS", plowingDAS)
		localStorage.setItem("harrowing1DAS", harrowing1DAS)
		localStorage.setItem("harrowing2DAS", harrowing2DAS)
		localStorage.setItem("harrowing3DAS", harrowing3DAS)
		localStorage.setItem("levellingDAS", levellingDAS)
	}

	function calculateCropEstablishmentSchedule() {
		pullingToTransplanting = document.getElementById('pullingToTransplanting').value
		let replantingWindowMinDAT = document.getElementById('replantingWindowMinDAT').value
		let replantingWindowMaxDAT = document.getElementById('replantingWindowMaxDAT').value
		seedlingAge = document.getElementById('seedlingAge').value

		if (pullingToTransplanting == 0 || replantingWindowMinDAT == 0 || replantingWindowMaxDAT == 0 || seedlingAge == 0) {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		// Hide the next button
			document.getElementById('nextWaterManagementButton').style.display = 'none'
		} else {
			transplantingDate = new Date(seedSowingEnd)
			transplantingDate.setDate(transplantingDate.getDate() + parseInt(seedlingAge))
			document.getElementById('transplantingDate').value = year(transplantingDate) + "/" + month(transplantingDate) + "/" + dayDate(transplantingDate)

			let replantingWindowMinDate = new Date(transplantingDate)
			replantingWindowMinDate.setDate(replantingWindowMinDate.getDate() + parseInt(replantingWindowMinDAT))
			let replantingWindowMaxDate = new Date(transplantingDate)
			replantingWindowMaxDate.setDate(replantingWindowMaxDate.getDate() + parseInt(replantingWindowMaxDAT))
			document.getElementById('replantingWindowDate').value = year(replantingWindowMinDate) + "/" + month(replantingWindowMinDate) + "/" + dayDate(replantingWindowMinDate) + "-" + year(replantingWindowMaxDate) + "/" + month(replantingWindowMaxDate) + "/" + dayDate(replantingWindowMaxDate)

			// Show the next button
			document.getElementById('nextWaterManagementButton').style.display = 'inline-block'
		}

		// Save crop establishment inputs to local storage
		localStorage.setItem("pullingToTransplanting", pullingToTransplanting)
		localStorage.setItem("replantingWindowMinDAT", replantingWindowMinDAT)
		localStorage.setItem("replantingWindowMaxDAT", replantingWindowMaxDAT)
	}

	function calculateWaterManagementSchedule() {
		let irrigationMinDAT = document.getElementById('irrigationMinDAT').value
		let irrigationMaxDAT = document.getElementById('irrigationMaxDAT').value
		let irrigationInterval = document.getElementById('irrigationInterval').value
		maturity = document.getElementById('maturity').value
		seedlingAge = document.getElementById('seedlingAge').value

		if (irrigationMinDAT == 0 || irrigationMaxDAT == 0 || irrigationInterval == 0 || seedlingAge == 0) {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		// Hide the next button
			document.getElementById('nextNutrientManagementButton').style.display = 'none'
		} else {
			// let irrigationCount = Math.round(((parseInt(maturity) + 7) - (parseInt(seedlingAge) + parseInt(pullingToTransplanting) + parseInt(irrigationMinDAT) + 14)) / irrigationInterval)
			let irrigationAve = (parseInt(irrigationMinDAT) + parseInt(irrigationMaxDAT)) / 2
			let irrigationCount = (parseInt(maturity) - (parseInt(seedlingAge) + parseInt(pullingToTransplanting) + irrigationAve + 14)) / irrigationInterval
			console.log('Irrigation count: ' + irrigationCount)

			let irrigationMinDate = new Date(transplantingDate)
			irrigationMinDate.setDate(irrigationMinDate.getDate() + parseInt(irrigationMinDAT))
			let irrigationMaxDate = new Date(transplantingDate)
			irrigationMaxDate.setDate(irrigationMaxDate.getDate() + parseInt(irrigationMaxDAT))
			document.getElementById('irrigationDate1').value = year(irrigationMinDate) + "/" + month(irrigationMinDate) + "/" + dayDate(irrigationMinDate) + "-" + year(irrigationMaxDate) + "/" + month(irrigationMaxDate) + "/" + dayDate(irrigationMaxDate)

			let irrigationDateInputCount = 2
			let irrigationDateInputs = ""

			// Remove irrigation dates for re-calculation
			$('.irrigationDates').remove()

			let irrigationMinDateIterate
			let irrigationMaxDateIterate

			for (let i=1; i<=irrigationCount; ++i) {
				irrigationMinDateIterate = new Date(irrigationMinDate)
				irrigationMaxDateIterate = new Date(irrigationMaxDate)

				irrigationMinDateIterate.setDate(irrigationMinDateIterate.getDate() + (parseInt(irrigationInterval) * i))
				irrigationMaxDateIterate.setDate(irrigationMaxDateIterate.getDate() + (parseInt(irrigationInterval) * i))

				let irrigationDateInputValue = "" + year(irrigationMinDateIterate) + "/" + month(irrigationMinDateIterate) + "/" + dayDate(irrigationMinDateIterate) + "-" + year(irrigationMaxDateIterate) + "/" + month(irrigationMaxDateIterate) + "/" + dayDate(irrigationMaxDateIterate) + ""

				irrigationDateInputs += '<input type="text" name="irrigationDate'+irrigationDateInputCount+'" id="irrigationDate'+irrigationDateInputCount+'" class="form-control mt-md irrigationDates" value="'+irrigationDateInputValue+'" readonly>'
				++irrigationDateInputCount
			}

			$(irrigationDateInputs).insertAfter('#irrigationDate1')

			// Show the next button
			document.getElementById('nextNutrientManagementButton').style.display = 'inline-block'
		}

		// Save water management inputs to local storage
		localStorage.setItem("irrigationMinDAT", irrigationMinDAT)
		localStorage.setItem("irrigationMaxDAT", irrigationMaxDAT)
		localStorage.setItem("irrigationInterval", irrigationInterval)
	}

	function calculateNutrientManagementSchedule() {
		let fertilizerApp1DAT = document.getElementById('fertilizerApp1DAT').value
		let fertilizerApp2DAT = document.getElementById('fertilizerApp2DAT').value
		let fertilizerApp3DAT = document.getElementById('fertilizerApp3DAT').value
		let fertilizerAppFinalDAT = document.getElementById('fertilizerAppFinalDAT').value
		seedlingAge = document.getElementById('seedlingAge').value

		if (fertilizerApp1DAT == 0 || fertilizerApp2DAT == 0 || fertilizerAppFinalDAT == 0 || seedlingAge == 0) {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		// Hide the next button
			document.getElementById('nextRoguingButton').style.display = 'none'
		} else {
			let fertilizerApp1Date = new Date(transplantingDate)
			fertilizerApp1Date.setDate(fertilizerApp1Date.getDate() + parseInt(fertilizerApp1DAT))
			document.getElementById('fertilizerApp1Date').value = year(fertilizerApp1Date) + "/" + month(fertilizerApp1Date) + "/" + dayDate(fertilizerApp1Date)

			let fertilizerApp2Date = new Date(transplantingDate)
			fertilizerApp2Date.setDate(fertilizerApp2Date.getDate() + parseInt(fertilizerApp2DAT))
			document.getElementById('fertilizerApp2Date').value = year(fertilizerApp2Date) + "/" + month(fertilizerApp2Date) + "/" + dayDate(fertilizerApp2Date)

			if (fertilizerApp3DAT != 0) {
				let fertilizerApp3Date = new Date(transplantingDate)
				fertilizerApp3Date.setDate(fertilizerApp3Date.getDate() + parseInt(fertilizerApp3DAT))
				document.getElementById('fertilizerApp3Date').value = year(fertilizerApp3Date) + "/" + month(fertilizerApp3Date) + "/" + dayDate(fertilizerApp3Date)
			}

			let fertilizerAppFinalDate = new Date(transplantingDate)
			fertilizerAppFinalDate.setDate(fertilizerAppFinalDate.getDate() + parseInt(fertilizerAppFinalDAT))
			document.getElementById('fertilizerAppFinalDate').value = year(fertilizerAppFinalDate) + "/" + month(fertilizerAppFinalDate) + "/" + dayDate(fertilizerAppFinalDate)

			// Show the next button
			document.getElementById('nextRoguingButton').style.display = 'inline-block'
		}

		// Save nutrient management inputs to local storage
		localStorage.setItem("fertilizerApp1DAT", fertilizerApp1DAT)
		localStorage.setItem("fertilizerApp2DAT", fertilizerApp2DAT)
		localStorage.setItem("fertilizerApp3DAT", fertilizerApp3DAT)
		localStorage.setItem("fertilizerAppFinalDAT", fertilizerAppFinalDAT)
	}

	function calculateRoguingSchedule() {
		seedlingAge = document.getElementById('seedlingAge').value

		if (seedlingAge == 0) {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		// Hide the next button
			document.getElementById('nextPestManagementButton').style.display = 'none'
		} else {
			let roguing10DATDate = new Date(transplantingDate)
			roguing10DATDate.setDate(roguing10DATDate.getDate() + 10)
			document.getElementById('roguing10DATDate').value = year(roguing10DATDate) + "/" + month(roguing10DATDate) + "/" + dayDate(roguing10DATDate)

			let roguing20DATDate = new Date(transplantingDate)
			roguing20DATDate.setDate(roguing20DATDate.getDate() + 20)
			document.getElementById('roguing20DATDate').value = year(roguing20DATDate) + "/" + month(roguing20DATDate) + "/" + dayDate(roguing20DATDate)

			// Show the next button
			document.getElementById('nextPestManagementButton').style.display = 'inline-block'
		}

	}

	function calculatePestManagementSchedule() {
		let preEmergenceAppDAT = document.getElementById('preEmergenceAppDAT').value
		let postEmergenceAppDAT = document.getElementById('postEmergenceAppDAT').value
		seedlingAge = document.getElementById('seedlingAge').value

		if (preEmergenceAppDAT == 0 || seedlingAge == 0) {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		// Hide the next button
			document.getElementById('nextHarvestingButton').style.display = 'none'
		} else {
			let preEmergenceAppDate = new Date(transplantingDate)
			preEmergenceAppDate.setDate(preEmergenceAppDate.getDate() + parseInt(preEmergenceAppDAT))
			document.getElementById('preEmergenceAppDate').value = year(preEmergenceAppDate) + "/" + month(preEmergenceAppDate) + "/" + dayDate(preEmergenceAppDate)

			if (postEmergenceAppDAT != 0) {
				let postEmergenceAppDate = new Date(transplantingDate)
				postEmergenceAppDate.setDate(postEmergenceAppDate.getDate() + parseInt(postEmergenceAppDAT))
				document.getElementById('postEmergenceAppDate').value = year(postEmergenceAppDate) + "/" + month(postEmergenceAppDate) + "/" + dayDate(postEmergenceAppDate)
			}

			// Show the next button
			document.getElementById('nextHarvestingButton').style.display = 'inline-block'
		}

		// Save pest management inputs to local storage
		localStorage.setItem("preEmergenceAppDAT", preEmergenceAppDAT)
		localStorage.setItem("postEmergenceAppDAT", postEmergenceAppDAT)
	}

	function calculateHarvestingSchedule() {
		seedlingAge = document.getElementById('seedlingAge').value

		if (seedlingAge == 0) {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})

	   		// Hide the submit button
			document.getElementById('storeActivities').style.display = 'none'
		} else {
			// let harvestingDays = ((parseInt(maturity) + 7) - (parseInt(seedlingAge) + parseInt(pullingToTransplanting)))

			let harvestingDate = new Date(seedSowingEnd)
			harvestingDate.setDate(harvestingDate.getDate() + parseInt(maturity))

			// let harvestingDate = new Date(transplantingDate)
			// harvestingDate.setDate(harvestingDate.getDate() + parseInt(harvestingDays))
			document.getElementById('harvestingDate').value = year(harvestingDate) + "/" + month(harvestingDate) + "/" + dayDate(harvestingDate)

			// Show the submit button
			document.getElementById('storeActivities').style.display = 'inline-block'
		}

	}

	// Get production technology
	function selectProdTech() {
		let techID = document.getElementById('prodTech').value
		
		HoldOn.open(holdonOptions)

		$.ajax({
			type: 'POST',
			url: "{{route('production_plans.seed_production_technology')}}",
			data: {
				'_token': "{{csrf_token()}}",
				'techID': techID
			},
			dataType: 'JSON',
			success: (res) => {
				console.log(res)
				
				document.getElementById('seedlingAge').value = res.seedling_age
				document.getElementById('seedSoakingDuration').value = res.soaking_hrs
				document.getElementById('seedIncubationDuration').value = res.incubation_hrs
				document.getElementById('seedSowingDuration').value = res.sowing_hrs
				document.getElementById('seedbedIrrigationMinDAS').value = res.seedbed_irrigation_min_DAS
				document.getElementById('seedbedIrrigationMaxDAS').value = res.seedbed_irrigation_max_DAS
				document.getElementById('seedbedIrrigationInterval').value = res.seedbed_irrigation_interval
				document.getElementById('seedlingFertilizerAppInitDAS').value = res.seedling_fertilizer_app_init_DAS
				document.getElementById('seedlingFertilizerAppFinalDAS').value = res.seedling_fertilizer_app_final_DAS
				document.getElementById('plowingDAS').value = res.plowing_DAS
				document.getElementById('harrowing1DAS').value = res.harrowing_1_DAS
				document.getElementById('harrowing2DAS').value = res.harrowing_2_DAS
				document.getElementById('harrowing3DAS').value = res.harrowing_3_DAS
				document.getElementById('levellingDAS').value = res.levelling_DAS
				document.getElementById('pullingToTransplanting').value = res.pulling_to_transplanting
				document.getElementById('replantingWindowMinDAT').value = res.replanting_window_min_DAT
				document.getElementById('replantingWindowMaxDAT').value = res.replanting_window_max_DAT
				document.getElementById('irrigationMinDAT').value = res.irrigation_min_DAT
				document.getElementById('irrigationMaxDAT').value = res.irrigation_max_DAT
				document.getElementById('irrigationInterval').value = res.irrigation_interval
				document.getElementById('fertilizerApp1DAT').value = res.fertilizer_app_1_DAT
				document.getElementById('fertilizerApp2DAT').value = res.fertilizer_app_2_DAT
				document.getElementById('fertilizerApp3DAT').value = res.fertilizer_app_3_DAT
				document.getElementById('fertilizerAppFinalDAT').value = res.fertilizer_app_final_DAT
				document.getElementById('preEmergenceAppDAT').value = res.pre_emergence_app_DAT
				document.getElementById('postEmergenceAppDAT').value = res.post_emergence_app_DAT

				HoldOn.close()
			}
		})

		// save production technology value in local storage
		localStorage.setItem("prodTech", techID)
	}

	// TODO: limit 1 negative sign only
	// Prevent input type number to accept e, + and - as input
	document.getElementById('plowingDAS').addEventListener("keypress", function(event) {
		if (event.which != 45 && event.which > 31 
            && (event.which < 48 || event.which > 57)) {
			event.preventDefault()
		}
	})

	document.getElementById('harrowing1DAS').addEventListener("keypress", function(event) {
		if (event.which != 45 && event.which > 31 
            && (event.which < 48 || event.which > 57)) {
			event.preventDefault()
		}
	})

	document.getElementById('harrowing2DAS').addEventListener("keypress", function(event) {
		if (event.which != 45 && event.which > 31 
            && (event.which < 48 || event.which > 57)) {
			event.preventDefault()
		}
	})

	document.getElementById('harrowing3DAS').addEventListener("keypress", function(event) {
		if (event.which != 45 && event.which > 31 
            && (event.which < 48 || event.which > 57)) {
			event.preventDefault()
		}
	})

	document.getElementById('levellingDAS').addEventListener("keypress", function(event) {
		if (event.which != 45 && event.which > 31 
            && (event.which < 48 || event.which > 57)) {
			event.preventDefault()
		}
	})

</script>