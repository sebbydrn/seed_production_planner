<script>
	function storeActivities(productionPlanID) {
		swal({
		  	title: "Submit Activities?",
		  	text: "Once submitted, production plan will be finalized.",
		  	icon: "warning",
		  	buttons: true
		})
		.then((submitActivities) => {
		  	if (submitActivities) {
		  		HoldOn.open(holdonOptions)

		  		let techID = document.getElementById('prodTech')


				// Seed Soaking
				let seedSoakingDuration = document.getElementById('seedSoakingDuration').value
				let seedSoakingEnd = document.getElementById('seedSoakingEnd').value

				// Seed Incubation
				let seedIncubationDuration = document.getElementById('seedIncubationDuration').value
				let seedIncubationEnd = document.getElementById('seedIncubationEnd').value

				// Seed Sowing
				let seedSowingDuration = document.getElementById('seedSowingDuration').value
				let seedSowingEnd = document.getElementById('seedSowingEnd').value

				// Seedbed Irrigation
				let seedbedIrrigationMinDAS = document.getElementById('seedbedIrrigationMinDAS').value
				let seedbedIrrigationMaxDAS = document.getElementById('seedbedIrrigationMaxDAS').value
				let seedbedIrrigationInterval = document.getElementById('seedbedIrrigationInterval').value

				let seedbedIrrigationCount = Math.round((parseInt(seedlingAge) - parseInt(seedbedIrrigationMinDAS)) / parseInt(seedbedIrrigationInterval))
				seedbedIrrigationCount += 1

				let seedbedIrrigationDates = []
				let seedbedIrrigationDate1 = document.getElementById('seedbedIrrigationDate1').value
				seedbedIrrigationDates.push(seedbedIrrigationDate1)
				for (let i=2; i<=seedbedIrrigationCount; ++i) {
					let seedbedIrrigationDate = document.getElementById('seedbedIrrigationDate'+i).value
					seedbedIrrigationDates.push(seedbedIrrigationDate)
				}
				console.log(seedbedIrrigationDates)

				// Seedling Fertilizer Application
				let seedlingFertilizerAppInitDAS = document.getElementById('seedlingFertilizerAppInitDAS').value
				let seedlingFertilizerAppInitDate = document.getElementById('seedlingFertilizerAppInitDate').value
				let seedlingFertilizerAppFinalDAS = document.getElementById('seedlingFertilizerAppFinalDAS').value
				let seedlingFertilizerAppFinalDate = document.getElementById('seedlingFertilizerAppFinalDate').value

				// Plowing
				let plowingDAS = document.getElementById('plowingDAS').value
				let plowingDate = document.getElementById('plowingDate').value

				// Harrowing 1
				let harrowing1DAS = document.getElementById('harrowing1DAS').value
				let harrowing1Date = document.getElementById('harrowing1Date').value

				// Harrowing 2
				let harrowing2DAS = document.getElementById('harrowing2DAS').value
				let harrowing2Date = document.getElementById('harrowing2Date').value

				// Harrowing 3
				let harrowing3DAS = document.getElementById('harrowing3DAS').value
				let harrowing3Date = document.getElementById('harrowing3Date').value

				// Levelling
				let levellingDAS = document.getElementById('levellingDAS').value
				let levellingDate = document.getElementById('levellingDate').value

				// Replanting Window
				let replantingWindowMinDAT = document.getElementById('replantingWindowMinDAT').value
				let replantingWindowMaxDAT = document.getElementById('replantingWindowMaxDAT').value
				let replantingWindowDate = document.getElementById('replantingWindowDate').value

				// Irrigation
				let irrigationMinDAT = document.getElementById('irrigationMinDAT').value
				let irrigationMaxDAT = document.getElementById('irrigationMaxDAT').value
				let irrigationInterval = document.getElementById('irrigationInterval').value

				// let irrigationCount = Math.round(((parseInt(maturity) + 7) - (parseInt(seedlingAge) + parseInt(pullingToTransplanting) + parseInt(irrigationMinDAT) + 14)) / irrigationInterval)
				let irrigationAve = (parseInt(irrigationMinDAT) + parseInt(irrigationMaxDAT)) / 2
				let irrigationCount = (parseInt(maturity) - (parseInt(seedlingAge) + parseInt(pullingToTransplanting) + irrigationAve + 14)) / irrigationInterval
				irrigationCount += 1

				let irrigationDates = []
				let irrigationDate1 = document.getElementById('irrigationDate1').value
				irrigationDates.push(irrigationDate1)

				for (let i=2; i<=irrigationCount; ++i) {
					let irrigationDate = document.getElementById('irrigationDate'+i).value
					irrigationDates.push(irrigationDate)
				}
				console.log(irrigationDates)

				// Fertilizer Application
				let fertilizerApp1DAT = document.getElementById('fertilizerApp1DAT').value
				let fertilizerApp1Date = document.getElementById('fertilizerApp1Date').value
				let fertilizerApp2DAT = document.getElementById('fertilizerApp2DAT').value
				let fertilizerApp2Date = document.getElementById('fertilizerApp2Date').value
				let fertilizerApp3DAT = document.getElementById('fertilizerApp3DAT').value
				let fertilizerApp3Date = document.getElementById('fertilizerApp3Date').value
				let fertilizerAppFinalDAT = document.getElementById('fertilizerAppFinalDAT').value
				let fertilizerAppFinalDate = document.getElementById('fertilizerAppFinalDate').value

				// Roguing
				let roguing10DATDate = document.getElementById('roguing10DATDate').value
				let roguing20DATDate = document.getElementById('roguing20DATDate').value

				// Pre-emergence Herbicide Application
				let preEmergenceAppDAT = document.getElementById('preEmergenceAppDAT').value
				let preEmergenceAppDate = document.getElementById('preEmergenceAppDate').value

				// Post-emergence Herbicide Application
				let postEmergenceAppDAT = document.getElementById('postEmergenceAppDAT').value
				let postEmergenceAppDate = document.getElementById('postEmergenceAppDate').value

				// Harvesting
				let harvestingDate = document.getElementById('harvestingDate').value

				// Submit via ajax
				if (techID) {
					$.ajax({
						type: 'POST',
						url: "{{route('production_plans.store_activities')}}",
						data: {
							'_token': "{{csrf_token()}}",
							'productionPlanID': productionPlanID,
							'seedlingAge': seedlingAge,
							'seedSoakingStart': year(seedSoakingStart) + "/" + month(seedSoakingStart) + "/" + dayDate(seedSoakingStart) + " " + hours(seedSoakingStart) + ":" + minutes(seedSoakingStart),
							'seedSoakingDuration': seedSoakingDuration,
							'seedSoakingEnd': seedSoakingEnd,
							'seedIncubationDuration': seedIncubationDuration,
							'seedIncubationEnd': seedIncubationEnd,
							'seedSowingDuration': seedSowingDuration,
							'seedSowingEnd': seedSowingEnd,
							'seedbedIrrigationMinDAS': seedbedIrrigationMinDAS,
							'seedbedIrrigationMaxDAS': seedbedIrrigationMaxDAS,
							'seedbedIrrigationInterval': seedbedIrrigationInterval,
							'seedbedIrrigationDates': seedbedIrrigationDates,
							'seedlingFertilizerAppInitDAS': seedlingFertilizerAppInitDAS,
							'seedlingFertilizerAppInitDate': seedlingFertilizerAppInitDate,
							'seedlingFertilizerAppFinalDAS': seedlingFertilizerAppFinalDAS,
							'seedlingFertilizerAppFinalDate': seedlingFertilizerAppFinalDate,
							'plowingDAS': plowingDAS,
							'plowingDate': plowingDate,
							'harrowing1DAS': harrowing1DAS,
							'harrowing1Date': harrowing1Date,
							'harrowing2DAS': harrowing2DAS,
							'harrowing2Date': harrowing2Date,
							'harrowing3DAS': harrowing3DAS,
							'harrowing3Date': harrowing3Date,
							'levellingDAS': levellingDAS,
							'levellingDate': levellingDate,
							'pullingToTransplanting': pullingToTransplanting,
							'transplantingDate': year(transplantingDate) + "/" + month(transplantingDate) + "/" + dayDate(transplantingDate),
							'replantingWindowMinDAT': replantingWindowMinDAT,
							'replantingWindowMaxDAT': replantingWindowMaxDAT,
							'replantingWindowDate': replantingWindowDate,
							'irrigationMinDAT': irrigationMinDAT,
							'irrigationMaxDAT': irrigationMaxDAT,
							'irrigationInterval': irrigationInterval,
							'irrigationDates': irrigationDates,
							'fertilizerApp1DAT': fertilizerApp1DAT,
							'fertilizerApp1Date': fertilizerApp1Date,
							'fertilizerApp2DAT': fertilizerApp2DAT,
							'fertilizerApp2Date': fertilizerApp2Date,
							'fertilizerApp3DAT': fertilizerApp3DAT,
							'fertilizerApp3Date': fertilizerApp3Date,
							'fertilizerAppFinalDAT': fertilizerAppFinalDAT,
							'fertilizerAppFinalDate': fertilizerAppFinalDate,
							'roguing10DATDate': roguing10DATDate,
							'roguing20DATDate': roguing20DATDate,
							'preEmergenceAppDAT': preEmergenceAppDAT,
							'preEmergenceAppDate': preEmergenceAppDate,
							'postEmergenceAppDAT': postEmergenceAppDAT,
							'postEmergenceAppDate': postEmergenceAppDate,
							'harvestingDate': harvestingDate,
							'techID': techID.value
						},
						dataType: 'JSON',
						success: (res) => {
							HoldOn.close()
							
							if (res == "success") {
								swal("Success! The production plan is now finalized.", {
						      		icon: "success",
						   		})
						   		.then((value) => {
						   			window.location.href = "{{route('production_plans.index')}}"
						   		})

						   		// remove saved items in local storage
						   		localStorage.removeItem("prodTech")
						   		localStorage.removeItem("seedlingAge")
						   		localStorage.removeItem("seedSoakingStartDate")
								localStorage.removeItem("seedSoakingStartTime")
								localStorage.removeItem("seedSoakingDuration")
								localStorage.removeItem("seedIncubationDuration")
								localStorage.removeItem("seedSowingDuration")
								localStorage.removeItem("seedbedIrrigationMinDAS")
								localStorage.removeItem("seedbedIrrigationMaxDAS")
								localStorage.removeItem("seedbedIrrigationInterval")
								localStorage.removeItem("seedlingFertilizerAppInitDAS")
								localStorage.removeItem("seedlingFertilizerAppFinalDAS")
								localStorage.removeItem("plowingDAS")
								localStorage.removeItem("harrowing1DAS")
								localStorage.removeItem("harrowing2DAS")
								localStorage.removeItem("harrowing3DAS")
								localStorage.removeItem("levellingDAS")
								localStorage.removeItem("pullingToTransplanting")
								localStorage.removeItem("replantingWindowMinDAT")
								localStorage.removeItem("replantingWindowMaxDAT")
								localStorage.removeItem("irrigationMinDAT")
								localStorage.removeItem("irrigationMaxDAT")
								localStorage.removeItem("irrigationInterval")
								localStorage.removeItem("fertilizerApp1DAT")
								localStorage.removeItem("fertilizerApp2DAT")
								localStorage.removeItem("fertilizerApp3DAT")
								localStorage.removeItem("fertilizerAppFinalDAT")
								localStorage.removeItem("preEmergenceAppDAT")
								localStorage.removeItem("postEmergenceAppDAT")
							}
						}
					})
				} else {
					$.ajax({
						type: 'POST',
						url: "{{route('production_plans.store_activities')}}",
						data: {
							'_token': "{{csrf_token()}}",
							'productionPlanID': productionPlanID,
							'seedlingAge': seedlingAge,
							'seedSoakingStart': year(seedSoakingStart) + "/" + month(seedSoakingStart) + "/" + dayDate(seedSoakingStart) + " " + hours(seedSoakingStart) + ":" + minutes(seedSoakingStart),
							'seedSoakingDuration': seedSoakingDuration,
							'seedSoakingEnd': seedSoakingEnd,
							'seedIncubationDuration': seedIncubationDuration,
							'seedIncubationEnd': seedIncubationEnd,
							'seedSowingDuration': seedSowingDuration,
							'seedSowingEnd': seedSowingEnd,
							'seedbedIrrigationMinDAS': seedbedIrrigationMinDAS,
							'seedbedIrrigationMaxDAS': seedbedIrrigationMaxDAS,
							'seedbedIrrigationInterval': seedbedIrrigationInterval,
							'seedbedIrrigationDates': seedbedIrrigationDates,
							'seedlingFertilizerAppInitDAS': seedlingFertilizerAppInitDAS,
							'seedlingFertilizerAppInitDate': seedlingFertilizerAppInitDate,
							'seedlingFertilizerAppFinalDAS': seedlingFertilizerAppFinalDAS,
							'seedlingFertilizerAppFinalDate': seedlingFertilizerAppFinalDate,
							'plowingDAS': plowingDAS,
							'plowingDate': plowingDate,
							'harrowing1DAS': harrowing1DAS,
							'harrowing1Date': harrowing1Date,
							'harrowing2DAS': harrowing2DAS,
							'harrowing2Date': harrowing2Date,
							'harrowing3DAS': harrowing3DAS,
							'harrowing3Date': harrowing3Date,
							'levellingDAS': levellingDAS,
							'levellingDate': levellingDate,
							'pullingToTransplanting': pullingToTransplanting,
							'transplantingDate': year(transplantingDate) + "/" + month(transplantingDate) + "/" + dayDate(transplantingDate),
							'replantingWindowMinDAT': replantingWindowMinDAT,
							'replantingWindowMaxDAT': replantingWindowMaxDAT,
							'replantingWindowDate': replantingWindowDate,
							'irrigationMinDAT': irrigationMinDAT,
							'irrigationMaxDAT': irrigationMaxDAT,
							'irrigationInterval': irrigationInterval,
							'irrigationDates': irrigationDates,
							'fertilizerApp1DAT': fertilizerApp1DAT,
							'fertilizerApp1Date': fertilizerApp1Date,
							'fertilizerApp2DAT': fertilizerApp2DAT,
							'fertilizerApp2Date': fertilizerApp2Date,
							'fertilizerApp3DAT': fertilizerApp3DAT,
							'fertilizerApp3Date': fertilizerApp3Date,
							'fertilizerAppFinalDAT': fertilizerAppFinalDAT,
							'fertilizerAppFinalDate': fertilizerAppFinalDate,
							'roguing10DATDate': roguing10DATDate,
							'roguing20DATDate': roguing20DATDate,
							'preEmergenceAppDAT': preEmergenceAppDAT,
							'preEmergenceAppDate': preEmergenceAppDate,
							'postEmergenceAppDAT': postEmergenceAppDAT,
							'postEmergenceAppDate': postEmergenceAppDate,
							'harvestingDate': harvestingDate
						},
						dataType: 'JSON',
						success: (res) => {
							HoldOn.close()
							
							if (res == "success") {
								swal("Success! The production plan is now finalized.", {
						      		icon: "success",
						   		})
						   		.then((value) => {
						   			window.location.href = "{{route('production_plans.index')}}"
						   		})
							}
						}
					})
				}
				
		  	} else {
		  		swal("Action was cancelled");
		  	}
		})

		// console.log(productionPlanID)
		// console.log(seedlingAge)
		// console.log(year(seedSoakingStart) + "/" + month(seedSoakingStart) + "/" + dayDate(seedSoakingStart) + " " + hours(seedSoakingStart) + ":" + minutes(seedSoakingStart))
		// console.log(seedSoakingDuration)
		// console.log(seedSoakingEnd)
		// console.log(seedIncubationDuration)
		// console.log(seedIncubationEnd)
		// console.log(seedSowingDuration)
		// console.log(seedSowingEnd)
		// console.log(seedbedIrrigationMinDAS)
		// console.log(seedbedIrrigationMaxDAS)
		// console.log(seedbedIrrigationInterval)
		// console.log(seedbedIrrigationDates)
		// console.log(seedlingFertilizerAppInitDAS)
		// console.log(seedlingFertilizerAppInitDate)
		// console.log(seedlingFertilizerAppFinalDAS)
		// console.log(seedlingFertilizerAppFinalDate)
		// console.log(plowingDAS)
		// console.log(plowingDate)
		// console.log(harrowing1DAS)
		// console.log(harrowing1Date)
		// console.log(harrowing2DAS)
		// console.log(harrowing2Date)
		// console.log(harrowing3DAS)
		// console.log(harrowing3Date)
		// console.log(levellingDAS)
		// console.log(levellingDate)
		// console.log(pullingToTransplanting)
		// console.log(year(transplantingDate) + "/" + month(transplantingDate) + "/" + dayDate(transplantingDate) + " " + hours(transplantingDate) + ":" + minutes(transplantingDate))
		// console.log(replantingWindowMinDAT)
		// console.log(replantingWindowMaxDAT)
		// console.log(replantingWindowDate)
		// console.log(irrigationMinDAT)
		// console.log(irrigationMaxDAT)
		// console.log(irrigationInterval)
		// console.log(irrigationDates)
		// console.log(fertilizerApp1DAT)
		// console.log(fertilizerApp1Date)
		// console.log(fertilizerApp2DAT)
		// console.log(fertilizerApp2Date)
		// console.log(fertilizerApp3DAT)
		// console.log(fertilizerApp3Date)
		// console.log(fertilizerAppFinalDAT)
		// console.log(fertilizerAppFinalDate)
		// console.log(roguing10DATDate)
		// console.log(roguing20DATDate)
		// console.log(preEmergenceAppDAT)
		// console.log(preEmergenceAppDate)
		// console.log(postEmergenceAppDAT)
		// console.log(postEmergenceAppDate)
		// console.log(harvestingDate)
	}
</script>