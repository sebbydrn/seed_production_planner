<script>
	function check_target() {
		var year = document.getElementById('year').value
		var sem = 0
		if (document.getElementById('sem1').checked)
			sem = 1
		else if (document.getElementById('sem2').checked)
			sem = 2

		if (year > 2022 && sem != 0) {
			// Get the target varieties to be planted in this year and semester
			console.log("YEAR: " + year + " SEM: " + sem)

			HoldOn.open(holdonOptions)

			$.ajax({
				type: 'POST',
				url: "{{route('production_plans.variety_targets')}}",
				data: {
					_token: "{{csrf_token()}}",
					year: year,
					sem: sem
				},
				dataType: 'JSON',
				success: (res) => {
					// empty varieties dropdown and replace with targeted varieties
					var varieties_dropdown = document.getElementById('variety')
					varieties_dropdown.innerHTML = ""

					$('#variety').select2('destroy').val('')
					
					var option = document.createElement('option')
					option.setAttribute('disabled', true)
					option.setAttribute('selected', true)
					varieties_dropdown.appendChild(option)

					res.forEach((item, index) => {
						var option = document.createElement('option')
						option.value = item.variety
						option.innerHTML = item.variety
						varieties_dropdown.appendChild(option)
					})

					$('#variety').select2({placeholder: "Select Variety"})

					HoldOn.close()
				}
			})
		}
	}

	function check_target_seed_class() {
		var year = document.getElementById('year').value
		var sem = 0
		if (document.getElementById('sem1').checked)
			sem = 1
		else if (document.getElementById('sem2').checked)
			sem = 2
		var variety = document.getElementById('variety').value

		if (year > 2022 && sem != 0 && variety != "") {
			// Get target seed classes of the selected variety
			console.log("VARIETY: " + variety)

			HoldOn.open(holdonOptions)

			$.ajax({
				type: 'POST',
				url: "{{route('production_plans.seed_class_targets')}}",
				data: {
					_token: "{{csrf_token()}}",
					year: year,
					sem: sem,
					variety: variety
				},
				dataType: 'JSON',
				success: (res) => {
					// empty seed class dropdown and replace with targeted seed classes of the selected variety
					var seed_class_dropdown = document.getElementById('seedClass')
					seed_class_dropdown.innerHTML = ""

					$('#seedClass').select2('destroy').val('')

					var option = document.createElement('option')
					option.setAttribute('disabled', true)
					option.setAttribute('selected', true)
					seed_class_dropdown.appendChild(option)

					res.forEach((item, index) => {
						var option = document.createElement('option')
						option.value = item.seed_class
						option.innerHTML = item.seed_class + " Seed"
						seed_class_dropdown.appendChild(option)
					})

					$('#seedClass').select2({placeholder: "Select Seed Class"})

					HoldOn.close()
				}
			})
		} else {
			console.log("test")
		}
	}
</script>