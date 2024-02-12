<script>
	let cropEstablishmentTable

	$(document).ready(function() {
		// Crop Establishment Datatable
		cropEstablishmentTable = $('#cropEstablishmentTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('crop_establishment.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'production_plot_code', name: 'production_plot_code', width: '20%'},
				{data: 'activity', name: 'activity', width: '20%'},
				{data: 'datetime_start', name: 'datetime_start', width: '20%'},
				{data: 'datetime_end', name: 'datetime_end', width: '20%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%'}
			],
			order: [[0, 'asc']]
		})
	})
</script>