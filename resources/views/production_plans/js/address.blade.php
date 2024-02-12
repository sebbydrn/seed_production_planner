<script>
	function showMunicipalities() {
		HoldOn.open(holdonOptions)

		var provinceCode = document.getElementById('province').value

		$.ajax({
			type: 'POST',
			url: "{{route('production_plans.show_municipalities')}}",
			data: {
				_token: "{{csrf_token()}}",
				provinceCode: provinceCode
			},
			dataType: 'JSON',
			success: (res) => {
				console.log(res)

				// Change region field value
				document.getElementById('region').value = res.region_code

				// Change municipality field options
				// Remove options in municipality field
				var municipality = document.getElementById('municipality')
				municipality.innerHTML = ""

				// Add placeholder
				var selectPlaceholder = document.createElement('option')
				selectPlaceholder.innerHTML = "SELECT MUNICIPALITY"

				// Make placeholder attribute selected and disabled
				selectPlaceholder.setAttribute('selected', true)
				selectPlaceholder.setAttribute('disabled', true)

				// Append placeholder option to dropdown
				municipality.appendChild(selectPlaceholder)

				var new_options = res.municipalities

				new_options.forEach((item, index) => {
					// Create option element
					let selectOpt = document.createElement('option')
					selectOpt.value = item.mun_code
					selectOpt.innerHTML = item.name

					// Append options to dropdown
					municipality.appendChild(selectOpt)
				})

				HoldOn.close()
			}
		})
	}
</script>