<script>
	function deletePersonnel(personnelID) {
		swal({
		  	title: "Delete Personnel",
		  	text: "Once deleted, the personnel will be removed from this table.",
		  	icon: "warning",
		  	buttons: true
		})
		.then((willDelete) => {
		  	if (willDelete) {
		  		HoldOn.open(holdonOptions)

		  		$.ajax({
		  			type: 'DELETE',
		  			url: `{{url('personnel')}}/`+personnelID,
		  			data: {
		  				_token: "{{csrf_token()}}"
		  			},
		  			dataType: 'JSON',
		  			success: (res) => {
		  				HoldOn.close()

		  				if (res == "success") {
		  					swal("Success! The personnel is now deleted.", {
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
</script>