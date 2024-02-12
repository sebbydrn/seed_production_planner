<script>
	
	let receivedProdPlansTable

	$(document).ready(function() {
		// Plots Datatable
		receivedProdPlansTable = $('#receivedProdPlansTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('data_monitoring.datatable')}}",
				data: {
					_token: "{{csrf_token()}}"
				}
			},
			columns: [
				{data: 'production_plot_code', name: 'production_plot_code', width: '20%'},
				{data: 'year', name: 'year', width: '15%'},
				{data: 'sem', name: 'sem', width: '15%'},
				{data: 'variety', name: 'variety', width: '15%'},
				{data: 'seed_class', name: 'seed_class', width: '15%'},
				{data: 'station', name: 'station', width: '20%'}
			],
			order: [[1, 'desc'], [2, 'desc']]
		})
	})

	setInterval(function() {
		$.ajax({
			type: 'GET',
			url: "{{route('data_monitoring_geotag.show_data')}}",
			dataType: 'JSON',
			success: (res) => {
				console.log(res)

				document.getElementById('totalDailyData').innerHTML = res.totalDailyData
				document.getElementById('totalData').innerHTML = res.totalData

				document.getElementById('dailyData').innerHTML = ""

				let dateToday = new Date()
				dateToday = monthText(dateToday) + " " + dayDate(dateToday) + ", " + year(dateToday)
				let dailyData = res.dailyData
				let dailyDataRows = '<strong>Data Log Today: '+dateToday+'</strong> <hr style="background-color: #fff; width: 100%;" class="mt-1 mb-1" />'

				if (dailyData.length == 0) {
					dailyDataRows += '<span style="color: red;">--No Data Received--</span>'
				} else {
					let count = 1;
					dailyData.forEach(function (item, index) {
						if (count <= 5) {
							dailyDataRows += '<p class="mt-0 mb-0"><span style="color: #28a745;">[ '+item.timestamp+' ]</span> Data: [ Production Plot Code:"'+item.productionPlotCode+'"; Form:"'+item.form+'" ]</p>'
						}
						count++;
					})
				}

				document.getElementById('dailyData').innerHTML = dailyDataRows
			}
		})
	}, 5000)

	function year(date) {
		return date.getFullYear()
	}

	function monthText(date) {
		let month = date.getMonth()
		let monthArr = new Array()
		monthArr[0] = "January"
		monthArr[1] = "February"
		monthArr[2] = "March"
		monthArr[3] = "April"
		monthArr[4] = "May"
		monthArr[5] = "June"
		monthArr[6] = "July"
		monthArr[7] = "August"
		monthArr[8] = "September"
		monthArr[9] = "October"
		monthArr[10] = "November"
		monthArr[11] = "December"
		return monthArr[month]
	}

	function dayDate(date) {
		return `${date.getDate()}`.padStart(2, '0')
	}

	function refreshTable() {
		// TODO: add filter by station when refreshing table data
		$('#receivedProdPlansTable').DataTable().ajax.reload(null, false)
	}

	function filterTableByStation() {
		let philriceStation = document.getElementById('philriceStation').value

		// Destroy production plans DataTable
		if ($.fn.DataTable.isDataTable('#receivedProdPlansTable')) {
			$('#receivedProdPlansTable').DataTable().destroy()
		}

		// Empty production plans tbody
		$('#receivedProdPlansTable tbody').empty()

		// Production Plans Datatable
		receivedProdPlansTable = $('#receivedProdPlansTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'POST',
				url: "{{route('data_monitoring.datatable')}}",
				data: {
					_token: "{{csrf_token()}}",
					philriceStation: philriceStation
				}
			},
			columns: [
				{data: 'production_plot_code', name: 'production_plot_code', width: '20%'},
				{data: 'year', name: 'year', width: '15%'},
				{data: 'sem', name: 'sem', width: '15%'},
				{data: 'variety', name: 'variety', width: '15%'},
				{data: 'seed_class', name: 'seed_class', width: '15%'},
				{data: 'station', name: 'station', width: '20%'}
			],
			order: [[1, 'desc'], [2, 'desc']]
		})
	}


</script>