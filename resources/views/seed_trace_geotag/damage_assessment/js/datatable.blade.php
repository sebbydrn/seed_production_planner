<script>
	let damageAssessmentTable

	$(document).ready(function() {
		// Damage Assessment Datatable
		damageAssessmentTable = $('#damageAssessmentTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('damage_assessment.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'production_plot_code', name: 'production_plot_code', width: '35%'},
				{data: 'datetime', name: 'datetime', width: '35%'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, width: '30%'}
			],
			order: [[0, 'asc']]
		})
	})
</script>