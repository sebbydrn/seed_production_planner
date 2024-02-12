<script>
	var form = document.getElementById('add_target_form')
	form.addEventListener("submit", submit_target, true)

	function show_add_target_variety() {
		// Empty form fields
		document.getElementById('year').value = ""
		$('#variety_to_be_planted').select2("val", "")
		$('#seed_class_to_be_planted').select2("val", "")
		document.getElementById('area_to_be_planted').value = ""

		if (document.getElementById('sem1').checked)
			document.getElementById('sem1').checked = false
		else if (document.getElementById('sem2').checked)
			document.getElementById('sem2').checked = false

		$('#add_target_modal').modal()
	}

	function submit_target(event) {
		event.preventDefault()

		HoldOn.open(holdonOptions)

		var sem = null

		if (document.getElementById('sem1').checked)
			sem = 1
		else if (document.getElementById('sem2').checked)
			sem = 2

		$.ajax({
			type: 'POST',
			url: "{{route('target_varieties.store')}}",
			data: {
				_token: "{{csrf_token()}}",
				year: document.getElementById('year').value,
				sem: sem,
				variety: document.getElementById('variety_to_be_planted').value,
				seed_class: document.getElementById('seed_class_to_be_planted').value,
				area: document.getElementById('area_to_be_planted').value
			},
			dataType: 'JSON',
			success: (res) => {
				if (res == "Success") {
					swal("Success! The variety has been added to your target.", {
						icon: "success",
					})

					// Reload table to update contents
		  			$('#target_varieties_tbl').DataTable().ajax.reload(null, false)

		  			// Empty form fields
		  			document.getElementById('year').value = ""
		  			$('#variety_to_be_planted').select2("val", "")
		  			$('#seed_class_to_be_planted').select2("val", "")
		  			document.getElementById('area_to_be_planted').value = ""

		  			if (document.getElementById('sem1').checked)
						document.getElementById('sem1').checked = false
					else if (document.getElementById('sem2').checked)
						document.getElementById('sem2').checked = false
				} else if (res == "Failed") {
					swal("Please fill up the form fields.", {
						icon: "error",
					})
				} else if (res == "Duplicate") { 
					swal("The variety has already been targeted.", {
						icon: "warning",
					})
				} else {
					console.log(res)
				}

				HoldOn.close()
			}
		})
	}

	function delete_target(target_variety_id) {
		swal({
			content: {
				element: "input",
				attributes: {
					placeholder: "Please input why you will delete this target",
					type: "text"
				}
			},
			title: 'Delete Target',
			text: 'Please input why you will delete this target',
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
				swal("Please input why you will delete this target")
			} else {
				HoldOn.open(holdonOptions)

				$.ajax({
					type: 'POST',
					url: "{{route('target_varieties.destroy')}}",
					data: {
						_token: "{{csrf_token()}}",
						target_variety_id: target_variety_id,
						remarks: willDelete
					},
					dataType: 'JSON',
					success: (res) => {
						HoldOn.close()

						if (res == "Success") {
							swal("Success! The target is now deleted.", {
								icon: "success",
							})

		  					// Reload table to update contents
		  					$('#target_varieties_tbl').DataTable().ajax.reload(null, false)
		  				}
		  			}
		  		})
			}

		})
	}

	function select_seed_type() {
		var seed_type = document.getElementById('seed_type').value;

		if (seed_type == "Hybrid") {
			document.getElementById('hybrid_input').style.display = "block";
			document.getElementById('parentals_input').style.display = "none";
			document.getElementById('seed_class_input').style.display = "none";
		} else if (seed_type == "Inbred") {
			document.getElementById('hybrid_input').style.display = "none";
			document.getElementById('parentals_input').style.display = "none";
			document.getElementById('seed_class_input').style.display = "block";
		} else if (seed_type == "SQR") {
			document.getElementById('hybrid_input').style.display = "none";
			document.getElementById('parentals_input').style.display = "none";
			document.getElementById('seed_class_input').style.display = "none";
		}
	}

	function select_hybrid_seed_type() {
		var hybrid_seed_type = document.getElementById('hybrid_type').value;

		if (hybrid_seed_type == "Parentals") {
			document.getElementById('parentals_input').style.display = "block";
		} else {
			document.getElementById('parentals_input').style.display = "none";
		}
	}
</script>