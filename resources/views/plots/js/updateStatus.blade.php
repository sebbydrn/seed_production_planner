<script>
	function updatePlotStatus(plotID, status) {
		if (status == 0) {
			swal({
			  	title: "Deactivate Plot",
			  	text: "Once deactivated, you will not be able to use the plot in creating a production plan.",
			  	icon: "warning",
			  	buttons: true
			})
			.then((willDeactivate) => {
			  	if (willDeactivate) {
			  		HoldOn.open(holdonOptions)

			  		$.ajax({
			  			type: 'POST',
			  			url: "{{route('plots.update_plot_status')}}",
			  			data: {
			  				_token: "{{csrf_token()}}",
			  				plot_id: plotID,
			  				is_active: 0
			  			},
			  			dataType: 'JSON',
			  			success: (res) => {
			  				HoldOn.close()

			  				if (res == "success") {
			  					swal("Success! The plot is now deactivated.", {
						      		icon: "success",
						   		})

			  					// Reload table to update contents
						   		$('#plotsTable').DataTable().ajax.reload(null, false)
			  				}
			  			}
			  		})
			  	} else {
			  		swal("Action was cancelled");
			  	}
			})	
		} else if (status == 1) {
			swal({
			  	title: "Activate Plot",
			  	text: "Once activated, you will be able to use the plot in creating a production plan.",
			  	icon: "warning",
			  	buttons: true
			})
			.then((willActivate) => {
			  	if (willActivate) {
			  		HoldOn.open(holdonOptions)

			    	$.ajax({
			  			type: 'POST',
			  			url: "{{route('plots.update_plot_status')}}",
			  			data: {
			  				_token: "{{csrf_token()}}",
			  				plot_id: plotID,
			  				is_active: 1
			  			},
			  			dataType: 'JSON',
			  			success: (res) => {
			  				HoldOn.close()

			  				if (res == "success") {
			  					swal("Success! The plot is now activated.", {
						      		icon: "success",
						   		})

			  					// Reload table to update contents
						   		$('#plotsTable').DataTable().ajax.reload(null, false)
			  				}
			  			}
			  		})
			  	} else {
			  		swal("Action was cancelled");
			  	}
			})
		}
	}

	function updateSelectedRowsStatus(status) {
		console.log(plotsTable.rows('.dark').data())

		let selectedRows = plotsTable.rows('.dark').data()
		let selectedRowsLen = selectedRows.length

		if (selectedRowsLen == 0) {
			swal("No rows selected.", {
	      		icon: "warning",
	   		})
		} else {
			let plotIDs = []

			for (let i=0; i<selectedRowsLen; i++) {
				plotIDs.push(selectedRows[i].plot_id)
			}

			if (status == 0) {
				swal({
				  	title: "Deactivate Plot",
				  	text: "Once deactivated, you will not be able to use the plot/s in creating a production plan.",
				  	icon: "warning",
				  	buttons: true
				})
				.then((willDeactivate) => {
				  	if (willDeactivate) {
				  		HoldOn.open(holdonOptions)

				  		$.ajax({
							type: 'POST',
							url: "{{route('plots.multiple_update_plot_status')}}",
							data: {
								_token: "{{csrf_token()}}",
								plotIDs: plotIDs,
								is_active: status
							},
							dataType: 'JSON',
							success: (res) => {
								HoldOn.close()

								if (res == "success") {
									swal("Success! The plots are now deactivated.", {
										icon: "success"
									})

									// Reload table to update contents
									$('#plotsTable').DataTable().ajax.reload(null, false)
								}
							}
						})
				  	} else {
				  		swal("Action was cancelled");
					}
				})
			} else if (status == 1) {
				swal({
				  	title: "Activate Plot",
				  	text: "Once activated, you will be able to use the plot/s in creating a production plan.",
				  	icon: "warning",
				  	buttons: true
				})
				.then((willActivate) => {
				  	if (willActivate) {
				  		HoldOn.open(holdonOptions)

				    	$.ajax({
							type: 'POST',
							url: "{{route('plots.multiple_update_plot_status')}}",
							data: {
								_token: "{{csrf_token()}}",
								plotIDs: plotIDs,
								is_active: status
							},
							dataType: 'JSON',
							success: (res) => {
								HoldOn.close()
								
								if (res == "success") {
									swal("Success! The plots are now activated.", {
										icon: "success"
									})

									// Reload table to update contents
									$('#plotsTable').DataTable().ajax.reload(null, false)
								}
							}
						})
				  	} else {
				  		swal("Action was cancelled");
				  	}
				})
			}
		}

	}
</script>