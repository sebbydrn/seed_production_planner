<script>
	var submitted_activities_datatable;
	var philriceStation = 0;
	var year_filter;
	var sem_filter;

	$(document).ready(function() {
		// submitted activities datatable
		submitted_activities_datatable = $('#submitted_activities').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('seed_production_activities.datatable_submitted_activities')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'date', name: 'date', width: '10%', className: 'text-center', orderable: false},
				{data: 'variety', name: 'variety', width: '15%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '15%', orderable: false, className: 'text-center'},
				{data: 'activity', name: 'activity', width: '30%', orderable: false, className: 'text-center'},
				{data: 'station', name: 'station', width: '10%', orderable: false, className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, width: '20%', className: 'text-center'}
			]
		});
	});

	// filter function for the submitted activities datatable using "station"
	function filterTableByStation() {
		philriceStation = document.getElementById('philriceStation').value;

		filterTable(); // run filter table
	}

	// filter function for the submitted activities datatable using "year and sem"
	function filterTableByYearSem() {
		year_filter = document.getElementById('year_filter').value;
		sem_filter = document.getElementById('sem_filter').value;

		// check "year_filter" and "sem_filter" is not null or empty
		if ((year_filter != null || year_filter != "") && (sem_filter != null || year_filter != ""))
			filterTable(); // run filter table
	}

	function filterTable() {
		// set "philriceStation" value to zero when submitted value is null or empty
		philriceStation = (philriceStation == null || philriceStation == "") ? 0 : philriceStation;

		// destroy submitted activities datatable
		if ($.fn.DataTable.isDataTable('#submitted_activities')) {
			$('#submitted_activities').DataTable().destroy()
		}

		// empty submitted activities datatable tbody
		$('#submitted_activities tbody').empty()

		// submitted activities datatable
		submitted_activities_datatable = $('#submitted_activities').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('seed_production_activities.datatable_submitted_activities')}}",
				data: {
					_token: "{{csrf_token()}}",
					philriceStation: philriceStation,
					year_filter: year_filter,
					sem_filter: sem_filter
				}
			},
			columns: [
				{data: 'date', name: 'date', width: '10%', className: 'text-center', orderable: false},
				{data: 'variety', name: 'variety', width: '15%', orderable: false, className: 'text-center'},
				{data: 'seed_class', name: 'seed_class', width: '15%', orderable: false, className: 'text-center'},
				{data: 'activity', name: 'activity', width: '30%', orderable: false, className: 'text-center'},
				{data: 'station', name: 'station', width: '10%', orderable: false, className: 'text-center'},
				{data: 'actions', name: 'actions', orderable: false, width: '20%', className: 'text-center'}
			]
		});
	}
</script>