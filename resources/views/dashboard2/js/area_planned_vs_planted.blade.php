<script>
	var ces_planned_area = "{{$area_planned_data->ces}}"
	var mes_planned_area = "{{$area_planned_data->mes}}"
	var lbs_planned_area = "{{$area_planned_data->lbs}}"
	var aes_planned_area = "{{$area_planned_data->aes}}"
	var bes_planned_area = "{{$area_planned_data->bes}}"
	var cves_planned_area = "{{$area_planned_data->cves}}"
	var prn_planned_area = "{{$area_planned_data->prn}}"
	var bies_planned_area = "{{$area_planned_data->bies}}"
	var cmu_planned_area = "{{$area_planned_data->cmu}}"
	var zss_planned_area = "{{$area_planned_data->zss}}"
	var sss_planned_area = "{{$area_planned_data->sss}}"
	var mss_planned_area = "{{$area_planned_data->mss}}"

	var ces_planted_area = "{{$area_planted_data->ces}}"
	var mes_planted_area = "{{$area_planted_data->mes}}"
	var lbs_planted_area = "{{$area_planted_data->lbs}}"
	var aes_planted_area = "{{$area_planted_data->aes}}"
	var bes_planted_area = "{{$area_planted_data->bes}}"
	var cves_planted_area = "{{$area_planted_data->cves}}"
	var prn_planted_area = "{{$area_planted_data->prn}}"
	var bies_planted_area = "{{$area_planted_data->bies}}"
	var cmu_planted_area = "{{$area_planted_data->cmu}}"
	var zss_planted_area = "{{$area_planted_data->zss}}"
	var sss_planted_area = "{{$area_planted_data->sss}}"
	var mss_planted_area = "{{$area_planted_data->mss}}"


	var options = {
		series: [
			{
				name: 'Area Planned in SP Planner',
				data: [
					ces_planned_area.toLocaleString("en-US"),
					mes_planned_area.toLocaleString("en-US"),
					lbs_planned_area.toLocaleString("en-US"),
					aes_planned_area.toLocaleString("en-US"),
					bes_planned_area.toLocaleString("en-US"),
					cves_planned_area.toLocaleString("en-US"),
					prn_planned_area.toLocaleString("en-US"),
					bies_planned_area.toLocaleString("en-US"),
					cmu_planned_area.toLocaleString("en-US"),
					zss_planned_area.toLocaleString("en-US"),
					sss_planned_area.toLocaleString("en-US"),
					mss_planned_area.toLocaleString("en-US"),
				]
			},
			{
				name: 'Area Planted',
				data: [
					ces_planted_area.toLocaleString("en-US"),
					mes_planted_area.toLocaleString("en-US"),
					lbs_planted_area.toLocaleString("en-US"),
					aes_planted_area.toLocaleString("en-US"),
					bes_planted_area.toLocaleString("en-US"),
					cves_planted_area.toLocaleString("en-US"),
					prn_planted_area.toLocaleString("en-US"),
					bies_planted_area.toLocaleString("en-US"),
					cmu_planted_area.toLocaleString("en-US"),
					zss_planted_area.toLocaleString("en-US"),
					sss_planted_area.toLocaleString("en-US"),
					mss_planted_area.toLocaleString("en-US"),
				]
			}
		],
		chart: {
			type: 'bar',
			height: 350
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '75%'			
			}
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		xaxis: {
			categories: ['CES', 'Midsayap', 'Los Baños', 'Agusan', 'Batac', 'Isabela', 'Negros', 'Bicol', 'CMU', 'Zamboanga', 'Samar', 'Mindoro']
		},
		yaxis: {
			title: {
				text: 'Hectares (ha)'
			}
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val.toLocaleString("en-US") + " ha"
				}
			}
		},
		colors: ['#005dac', '#00a04c']
	};

	var chart = new ApexCharts(document.querySelector("#area_planned_vs_planted"), options);
    chart.render();
</script>