<script>
	(function( $ ) {
		'use strict';

		/*
		Modal Dismiss
		*/
		$(document).on('click', '.modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
		});
	}).apply( this , [ jQuery ])

	function viewPersonnelInfo(personnelID) {
		// Personnel info
		$.ajax({
			type: 'GET',
			url: `{{url('personnel')}}/`+personnelID,
			dataType: 'JSON',
			success: (res) => {
				console.log(res)

				// Add details to table
				document.getElementById('empIDNo').innerHTML = res.emp_idno
				document.getElementById('personnelName').innerHTML = res.first_name + " " + res.last_name
				document.getElementById('role').innerHTML = res.role

				// Open info modal
				$.magnificPopup.open({
					items: {
						src: '#modalViewPersonnel'
					},
					type: 'inline',
					mainClass: 'mfp-with-zoom',
					zoom: {
						enable: true,
						duration: 300,
						easing: 'ease-in-out'
					}
				})
			}
		})
	}
</script>