<script>
	function updatePersonnelStatus(personnelID, status) {
		if (status == 0) {
			swal({
			  	title: "Deactivate Personnel",
			  	text: "Once deactivated, you will not be able to select the personnel in creating a production plan.",
			  	icon: "warning",
			  	buttons: true
			})
			.then((willDeactivate) => {
			  	if (willDeactivate) {
			  		HoldOn.open(holdonOptions)

			  		$.ajax({
			  			type: 'POST',
			  			url: "{{route('personnel.update_personnel_status')}}",
			  			data: {
			  				_token: "{{csrf_token()}}",
			  				personnel_id: personnelID,
			  				is_active: 0
			  			},
			  			dataType: 'JSON',
			  			success: (res) => {
			  				HoldOn.close()

			  				if (res == "success") {
			  					swal("Success! The personnel is now deactivated.", {
						      		icon: "success",
						   		})

			  					// Reload table to update contents
						   		$('#personnelTable').DataTable().ajax.reload(null, false)
			  				}
			  			}
			  		})
			  	} else {
			  		swal("Action was cancelled");
			  	}
			})	
		} else if (status == 1) {
			swal({
			  	title: "Activate Personnel",
			  	text: "Once activated, you will be able to select the personnel in creating a production plan.",
			  	icon: "warning",
			  	buttons: true
			})
			.then((willActivate) => {
			  	if (willActivate) {
			  		HoldOn.open(holdonOptions)

			    	$.ajax({
			  			type: 'POST',
			  			url: "{{route('personnel.update_personnel_status')}}",
			  			data: {
			  				_token: "{{csrf_token()}}",
			  				personnel_id: personnelID,
			  				is_active: 1
			  			},
			  			dataType: 'JSON',
			  			success: (res) => {
			  				HoldOn.close()

			  				if (res == "success") {
			  					swal("Success! The personnel is now activated.", {
						      		icon: "success",
						   		})

			  					// Reload table to update contents
						   		$('#personnelTable').DataTable().ajax.reload(null, false)
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
		console.log(personnelTable.rows('.dark').data())

		let selectedRows = personnelTable.rows('.dark').data()
		let selectedRowsLen = selectedRows.length

		if (selectedRowsLen == 0) {
			swal("No rows selected.", {
	      		icon: "warning",
	   		})
		} else {
			let personnelIDs = []

			for (let i=0; i<selectedRowsLen; i++) {
				personnelIDs.push(selectedRows[i].personnel_id)
			}

			if (status == 0) {
				swal({
				  	title: "Deactivate Personnel",
				  	text: "Once deactivated, you will not be able to select the personnel in creating a production plan.",
				  	icon: "warning",
				  	buttons: true
				})
				.then((willDeactivate) => {
				  	if (willDeactivate) {
				  		HoldOn.open(holdonOptions)

				  		$.ajax({
							type: 'POST',
							url: "{{route('personnel.multiple_update_personnel_status')}}",
							data: {
								_token: "{{csrf_token()}}",
								personnelIDs: personnelIDs,
								is_active: status
							},
							dataType: 'JSON',
							success: (res) => {
								HoldOn.close()

								if (res == "success") {
									swal("Success! The personnel are now deactivated.", {
										icon: "success"
									})

									// Reload table to update contents
									$('#personnelTable').DataTable().ajax.reload(null, false)
								}
							}
						})
				  	} else {
				  		swal("Action was cancelled");
					}
				})
			} else if (status == 1) {
				swal({
				  	title: "Activate Personnel",
				  	text: "Once activated, you will be able to select the personnel in creating a production plan.",
				  	icon: "warning",
				  	buttons: true
				})
				.then((willActivate) => {
				  	if (willActivate) {
				  		HoldOn.open(holdonOptions)

				    	$.ajax({
							type: 'POST',
							url: "{{route('personnel.multiple_update_personnel_status')}}",
							data: {
								_token: "{{csrf_token()}}",
								personnelIDs: personnelIDs,
								is_active: status
							},
							dataType: 'JSON',
							success: (res) => {
								HoldOn.close()
								
								if (res == "success") {
									swal("Success! The personnel are now activated.", {
										icon: "success"
									})

									// Reload table to update contents
									$('#personnelTable').DataTable().ajax.reload(null, false)
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