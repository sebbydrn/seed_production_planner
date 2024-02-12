<script>
	
	function getVarieties() {

		let year = document.getElementById('year').value
		let sem 

		if (document.getElementById('sem1').checked) {
			sem = document.getElementById('sem1').value
		}

		if (document.getElementById('sem2').checked) {
			sem = document.getElementById('sem2').value
		}

		if (year && sem) {

			$.ajax({
				type: 'POST',
				url: "{{route('production_plans.varieties_planted')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'year': year,
					'sem': sem
				},
				dataType: 'JSON',
				success: (varieties) => {
					console.log(varieties)

					let varietiesInput = document.getElementById('variety')

					// Empty varieties dropdown
					varietiesInput.innerHTML = ""

					// Add placeholder to the warehouse dropdown
					let selectPlaceholder = document.createElement('option')
					selectPlaceholder.innerHTML = "Select Variety"

					// Make placeholder attribute selected and disabled
					selectPlaceholder.setAttribute('selected', true)
					selectPlaceholder.setAttribute('disabled', true)

					// Append placeholder option to dropdown
					varietiesInput.appendChild(selectPlaceholder)

					varieties.forEach((item, index) => {
						// Create option element
						let selectOpt = document.createElement('option')
						selectOpt.value = item['production_plan_id']
						selectOpt.innerHTML = item['variety']

						// Append options to dropdown
						varietiesInput.appendChild(selectOpt)
					})
				}
			})

		}

	}

	function getPlots() {

		let productionPlanID = document.getElementById('variety').value

		if (productionPlanID) {

			$.ajax({
				type: 'POST',
				url: "{{route('production_plans.production_plan_plots')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': productionPlanID
				},
				dataType: 'JSON',
				success: (res) => {
					console.log(res)

					document.getElementById('productionPlotCode').value = res.productionPlotCode

					let plots = res.plots
					let productionPlots = ""

					plots.forEach((item, index) => {
						if (productionPlots == "") {
							productionPlots = item
						} else {
							productionPlots += ", " + item
						}
					})

					let productionPlotsField = document.getElementById('productionPlots')

					productionPlotsField.innerHTML = productionPlots

					
				}
			})

		}

	}

</script>