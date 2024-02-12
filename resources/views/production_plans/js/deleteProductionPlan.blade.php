<script>
	function deleteProductionPlan(productionPlanID) {
		swal({
		  	title: "Delete Production Plan",
		  	text: "Once deleted, the production plan will be removed from this table.",
		  	icon: "warning",
		  	buttons: true
		})
		.then((willDeactivate) => {
		  	if (willDeactivate) {
		  		HoldOn.open(holdonOptions)
		  		
		  		$.ajax({
		  			type: 'DELETE',
		  			url: `{{url('production_plans')}}/`+productionPlanID,
		  			data: {
		  				_token: "{{csrf_token()}}"
		  			},
		  			dataType: 'JSON',
		  			success: (res) => {
		  				HoldOn.close()

		  				if (res == "success") {
		  					swal("Success! The production plan is now deleted.", {
					      		icon: "success",
					   		})

		  					// Reload table to update contents
					   		$('#productionPlansTable').DataTable().ajax.reload(null, false)
		  				}
		  			}
		  		})
		  	} else {
		  		swal("Action was cancelled");
		  	}
		})
	}

	function deleteFinProductionPlan(productionPlanID) {
		swal({
		  	content: {
		    	element: "input",
		    	attributes: {
		      		placeholder: "Please input why you will delete this plan",
		      		type: "text"
		    	}
		  	},
		    title: 'Delete Production Plan',
		    text: 'Please input why you will delete this plan',
		    buttons: {
			    cancel: true,
			    confirm: true,
			},
		})
		.then((willDelete) => {
			console.log(willDelete)

			if (willDelete == null) {
				swal("Action cancelled")
			} else {
				if (willDelete != "" && willDelete != null) {
					HoldOn.open(holdonOptions)

					$.ajax({
						type: 'POST',
						url: "{{route('production_plans.delete_finalized_plan')}}",
						data: {
							_token: "{{csrf_token()}}",
							productionPlanID: productionPlanID,
							remarks: willDelete
						},
						dataType: 'JSON',
						success: (res) => {
							HoldOn.close()

			  				if (res == "success") {
			  					swal("Success! The production plan is now deleted.", {
						      		icon: "success",
						   		})

			  					// Reload table to update contents
						   		$('#productionPlansTable').DataTable().ajax.reload(null, false)
			  				}
						}
					})
				} else {
					swal("Please input why you will delete this plan")
				}
			}

		})

	}
</script>