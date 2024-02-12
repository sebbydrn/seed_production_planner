<script>
	function reject_prod_cost_sched(id) {
		swal({
		  	content: {
				element: "input",
				attributes: {
					placeholder: "Please input why you will reject this production cost schedule",
					type: "text"
				}
			},
			title: 'Reject Production Cost Schedule',
			text: 'Please input why you will reject this production cost schedule',
			buttons: {
		  		cancel: "No",
		  		confirm: "Yes, Proceed",
		  	},
		})
		.then((submit) => {
		  	if (submit) {
		  		HoldOn.open(holdonOptions);
		  		
		  		$.ajax({
		  			type: 'PATCH',
		  			url: "{{route('production_cost_schedule.approve', ['id' => $id])}}",
		  			data: {
		  				_token: "{{csrf_token()}}",
		  				philrice_station_id: "{{$philrice_station_id}}",
		  				year: "{{$year}}",
		  				is_approved: 2
		  			},
		  			dataType: 'JSON',
		  			success: (res) => {
		  				if (res == "success") {
		  					swal("Success! Production cost schedule was rejected.", {
					      		icon: "success",
					   		}).then((result) => {
					   			// redirect to production cost schedule table page
					   			window.location.href = "{{route('production_cost_schedule.index')}}";
					   		});
		  				} else {
		  					swal("An error has been encountered.", {
		  						icon: "error",
		  					});
		  				}
		  			}
		  		});
		  	} else {
		  		swal("Action was cancelled");
		  	}
		});
	}

	function approve_prod_cost_sched(id) {
		swal({
		  	title: "Approve Production Cost Schedule",
		  	text: "Do you want to approve this production cost schedule?",
		  	icon: "warning",
		  	buttons: {
		  		cancel: "No",
		  		confirm: "Yes, Proceed",
		  	},
		})
		.then((submit) => {
		  	if (submit) {
		  		HoldOn.open(holdonOptions);
		  		
		  		$.ajax({
		  			type: 'PATCH',
		  			url: "{{route('production_cost_schedule.approve', ['id' => $id])}}",
		  			data: {
		  				_token: "{{csrf_token()}}",
		  				philrice_station_id: "{{$philrice_station_id}}",
		  				year: "{{$year}}",
		  				is_approved: 1
		  			},
		  			dataType: 'JSON',
		  			success: (res) => {
		  				if (res == "success") {
		  					swal("Success! Production cost schedule was approved.", {
					      		icon: "success",
					   		}).then((result) => {
					   			// redirect to production cost schedule table page
					   			window.location.href = "{{route('production_cost_schedule.index')}}";
					   		});
		  				} else {
		  					swal("An error has been encountered.", {
		  						icon: "error",
		  					});
		  				}
		  			}
		  		});
		  	} else {
		  		swal("Action was cancelled");
		  	}
		});
	}
</script>