<script>
	let productionPlanTable

	$(document).ready(function() {
		// Plots Datatable
		productionPlanTable = $('#productionPlansTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('production_plans.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'production_plot_code', name: 'production_plot_code', orderable: false, className: 'text-center'},
				{data: 'year_sem', name: 'year_sem', orderable: false, className: 'text-center'},
				{data: 'variety', name: 'variety', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', orderable: false, className: 'text-center'},
				{data: 'planned_plots', name: 'planned_plots', orderable: false, searchable: false, className: 'text-center'},
				{data: 'planned_plots_area', name: 'planned_plots_area', orderable: false, searchable: false, className: 'text-right'},
				{data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center'}
			]
		})
	})
</script>