<script>
	function addPlot() {
		let farmer = document.getElementById('farmer').value;
		let plotName = document.getElementById('name').value
		let area = document.getElementById('area').value
		let coordinates = document.getElementById('coordinates').value

		if (plotName && area && coordinates) {
			HoldOn.open(holdonOptions)

			$.ajax({
				type: 'POST',
				url: "{{route('plots.store')}}",
				data: {
					_token: "{{csrf_token()}}",
					farmer: farmer,
					name: plotName,
					area: area,
					coordinates: coordinates
				},
				dataType:'JSON',
				success: (res) => {
					if (res == "success") {
						$('#farmer').val('').trigger('change');
						document.getElementById('name').value = ''
						document.getElementById('area').value = ''
						document.getElementById('coordinates').value = ''

						let orderedList = document.getElementById('activePlots')
						let newListItem = document.createElement('li')
						newListItem.appendChild(document.createTextNode(plotName))
						orderedList.appendChild(newListItem)

						HoldOn.close()

						swal("Well done! New plot successfully added.", {
				      		icon: "success",
				   		})
					} else {
						HoldOn.close()

						swal("Oh snap! Error adding new plot.", {
				      		icon: "error",
				   		})
					}
				}
			})
		} else {
			swal("Please fill-up all the input fields.", {
	      		icon: "warning",
	   		})
		}
	}

	// Prevent input type number to accept e, + and - as input
	document.getElementById('area').addEventListener("keypress", function(event) {
		if (event.which != 46 && event.which > 31 
            && (event.which < 48 || event.which > 57)) {
			event.preventDefault()
		}
	})

	// Allow space in plot name field
	document.getElementById('name').addEventListener('keydown', function(event) {
		event.stopPropagation()
	})
</script>