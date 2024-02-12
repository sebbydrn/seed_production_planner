<script>
	function trackCertification() {
		HoldOn.open(holdonOptions)

		var variety = document.getElementById('variety').value;
		var serial_number = document.getElementById('serial_number').value;
		var lot_no = document.getElementById('lot_no').value;
		var lab_no = document.getElementById('lab_no').value;

		$.ajax({
			type: 'POST',
			url: "{{route('certification_tracker.track')}}",
			data: {
				'_token': "{{csrf_token()}}",
				'variety': variety,
				'serial_number': serial_number,
				'lot_no': lot_no,
				'lab_no': lab_no
			},
			dataType: 'JSON',
			success: (res) => {
				console.log(res);

				// Destroy certification tracker table datatable
				if ($.fn.DataTable.isDataTable('#certification_tracker_table')) {
					$('#certification_tracker_table').DataTable().destroy();
				}

				// Empty certification tracker table tbody
				$('#certification_tracker_table tbody').empty();

				// Initiate certification tracker table datatable
				let certification_tracker_table = $('#certification_tracker_table').DataTable({
					columns: [
						{
							'name': 'variety',
							'data': 'variety',
							'className': 'text-center',
							'width': '9%'
						},
						{
							'name': 'seed_class_planted',
							'data': 'seed_class_planted',
							'className': 'text-center',
							'width': '6%'
						},
						{
							'name': 'seed_class_after',
							'data': 'seed_class_after',
							'className': 'text-center',
							'width': '6%'
						},
						{
							'name': 'lot_no',
							'data': 'lot_no',
							'className': 'text-center',
							'width': '9%'
						},
						{
							'name': 'lab_no',
							'data': 'lab_no',
							'className': 'text-center',
							'width': '9%'
						},
						{
							'name': 'growapp_tracking_no',
							'data': 'growapp_tracking_no',
							'className': 'text-center',
							'width': '7%'
						},
						{
							'name': 'serial_number',
							'data': 'serial_number',
							'className': 'text-center',
							'width': '7%'
						},
						{
							'name': 'date_planted',
							'data': 'date_planted',
							'className': 'text-center',
							'width': '6%'
						},
						{
							'name': 'seed_source',
							'data': 'seed_source',
							'className': 'text-center',
							'width': '8%'
						},
						{
							'name': 'source_lot_no',
							'data': 'source_lot_no',
							'className': 'text-center',
							'width': '9%'
						},
						{
							'name': 'source_lab_no',
							'data': 'source_lab_no',
							'className': 'text-center',
							'width': '9%'
						},
						{
							'name': 'prelim_inspect_status',
							'data': 'prelim_inspect_status',
							'className': 'text-center',
							'width': '5%'
						},
						{
							'name': 'final_inspect_status',
							'data': 'final_inspect_status',
							'className': 'text-center',
							'width': '5%'
						},
						{
							'name': 'lab_test_status',
							'data': 'lab_test_status',
							'className': 'text-center',
							'width': '5%'
						}
					],
					searching: false,
					bSort: false
				});

				res.forEach((item, index) => {
					if (item['lot_no'].length > 1) {
						var lot_no = item['lot_no'][0];
					} else {
						var lot_no = "";

						for (var i=0; i<item['lot_no'].length; i++) {
							lot_no = lot_no + item['lot_no'][i];

							if (i<(item['lot_no'].length - 1)) {
								lot_no = lot_no + ", ";
							}
						}
					}

					// add row to datatable
					certification_tracker_table.row.add({
						'variety': item['variety'],
						'seed_class_planted': item['seed_class_planted'],
						'seed_class_after': item['seed_class_after'],
						'lot_no': lot_no,
						'lab_no': item['lab_no'],
						'growapp_tracking_no': item['growapp_tracking_no'],
						'serial_number': item['serial_number'],
						'date_planted': item['date_planted'],
						'seed_source': item['seed_source'],
						'source_lot_no': item['source_lot_no'],
						'source_lab_no': item['source_lab_no'],
						'prelim_inspect_status': item['prelim_inspect_status'],
						'final_inspect_status': item['final_inspect_status'],
						'lab_test_status': item['lab_test_status']
					});
				});

				// Draw table
				certification_tracker_table.draw();

				// Display table
				document.getElementById('certification_tracker_table').style.display = "table";
			}
		});

		HoldOn.close();
	}
</script>