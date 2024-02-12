<script>
	function discontinue_plan(production_plan_id) {
		swal({
			content: {
				element: "input",
				attributes: {
					placeholder: "Please input why you will discontinue this plan",
					type: "text"
				}
			},
			title: 'Discontinue Production Plan',
			text: 'Please input why you will delete this plan',
			buttons: {
				cancel: true,
				confirm: true,
			},
		})
		.then((willDelete) => {
			console.log(willDelete)

			if (willDelete === null) {
				swal("Action cancelled")
			} else if (willDelete === "") {
				swal("Please input why you will discontinue this plan")
			} else {
				HoldOn.open(holdonOptions)

				$.ajax({
					type: 'POST',
					url: "{{route('production_plans.discontinue_production_plan')}}",
					data: {
						_token: "{{csrf_token()}}",
						production_plan_id: production_plan_id,
						remarks: willDelete
					},
					dataType: 'JSON',
					success: (res) => {
						HoldOn.close()

						if (res == "success") {
							swal("Success! The production plan is now discontinued.", {
								icon: "success",
							})

		  					// Reload table to update contents
		  					$('#productionPlansTable').DataTable().ajax.reload(null, false)
		  				}
		  			}
		  		})
			}

		})
	}
</script>