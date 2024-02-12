<script>

	(function($) {

		let initCalendar = function() {
			let $calendar = $('#calendar')
			let calendar 
			let activitiesDates = []

			$.ajax({
				type: 'POST',
				url: "{{route('production_plans.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					res.forEach((item, index) => {
						let event = []
						event['title'] = item.title,
						event['start'] = new Date(item.start)
						if (item.end) {
							event['end'] = new Date(item.end)
						}

						activitiesDates.push(event)
					})
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('seedling_management.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('land_preparation.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('crop_establishment.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('water_management.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('nutrient_management.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('disease_management.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('pest_management.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('roguing.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('harvesting.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			$.ajax({
				type: 'POST',
				url: "{{route('damage_assessment.activities')}}",
				data: {
					'_token': "{{csrf_token()}}",
					'productionPlanID': "{{$productionPlan->production_plan_id}}"
				},
				dataType: 'JSON',
				async: false,
				success: (res) => {
					console.log(res)
					if (res) {
						res.forEach((item, index) => {
							let event = []
							event['title'] = item.title,
							event['start'] = new Date(item.start)
							if (item.end) {
								event['end'] = new Date(item.end)
							}
							event['color'] = '#47a447'

							activitiesDates.push(event)
						})
					}
				}
			})

			console.log(activitiesDates)

			calendar = $calendar.fullCalendar({
				header: {
					left: 'title',
					right: 'prev,today,next,basicDay,basicWeek,month'
				},
				timeFormat: 'H:mm',
				titleFormat: {
					month: 'MMMM YYYY',      // September 2009
				    week: "MMM d YYYY",      // Sep 13 2009
				    day: 'dddd, MMM d, YYYY' // Tuesday, Sep 8, 2009
				},
				themeButtonIcons: {
					prev: 'fa fa-caret-left',
					next: 'fa fa-caret-right',
				},
				events: activitiesDates
			})
		}

		$(function() {
			initCalendar()
		})

	}).apply(this, [jQuery])
</script>