<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

	if (!Entrust::hasRole('accountant')) {
		Route::get('/', ['uses' => 'ProductionPlansController@index']);
	} else {
		Route::get('/', ['uses' => 'ProductionCostScheduleController@index']);
	}

	Route::get('/dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);
	Route::post('/dashboard/varieties_planted', ['as' => 'dashboard.varieties_planted', 'uses' => 'DashboardController@varieties_planted']);
	Route::post('/dashboard/show_activities', ['as' => 'dashboard.show_activities', 'uses' => 'DashboardController@show_activities']);
	Route::post('/dashboard/years', ['as' => 'dashboard.years', 'uses' => 'DashboardController@years']);

	Route::get('/dashboard2', ['as' => 'dashboard2.index', 'uses' => 'Dashboard2Controller@index']);

	Route::post('/plots/datatable', ['as' => 'plots.datatable', 'uses' => 'PlotsController@datatable']);
	Route::get('/plots/active_plots', ['as' => 'plots.active_plots', 'uses' => 'PlotsController@active_plots']);
	Route::post('/plots/update_plot_status', ['as' => 'plots.update_plot_status', 'uses' => 'PlotsController@update_plot_status']);
	Route::post('/plots/multiple_update_plot_status', ['as' => 'plots.multiple_update_plot_status', 'uses' => 'PlotsController@multiple_update_plot_status']);
	Route::get('/plots/view_all_plots', ['as' => 'plots.view_all_plots', 'uses' => 'PlotsController@view_all_plots']);
	Route::resource('/plots', 'PlotsController');

	Route::post('/farmers/datatable', ['as' => 'farmers.datatable', 'uses' => 'FarmerController@datatable']);
	Route::resource('/farmers', 'FarmerController');

	Route::post('/production_plans/datatable', ['as' => 'production_plans.datatable', 'uses' => 'ProductionPlansController@datatable']);
	Route::post('/production_plans/plots', ['as' => 'production_plans.plots', 'uses' => 'ProductionPlansController@plots']);
	Route::get('/production_plans/add_activities/{production_plan_id}', ['as' => 'production_plans.add_activities', 'uses' => 'ProductionPlansController@add_activities']);
	Route::get('/production_plans/edit_activities/{production_plan_id}', ['as' => 'production_plans.edit_activities', 'uses' => 'ProductionPlansController@edit_activities']);
	Route::post('/production_plans/store_activities', ['as' => 'production_plans.store_activities', 'uses' => 'ProductionPlansController@store_activities']);
	Route::post('/production_plans/activities', ['as' => 'production_plans.activities', 'uses' => 'ProductionPlansController@activities']);
	Route::get('/production_plans/generate_qrcode/{production_plan_id}', ['as' => 'production_plans.generate_qrcode', 'uses' => 'ProductionPlansController@generate_qrcode']);
	Route::post('production_plans/seed_production_technology', ['as' => 'production_plans.seed_production_technology', 'uses' => 'ProductionPlansController@seed_production_technology']);
	Route::post('production_plans/view_plan_plots', ['as' => 'production_plans.view_plan_plots', 'uses' => 'ProductionPlansController@view_plan_plots']);
	Route::post('production_plans/variety_targets', 'ProductionPlansController@variety_targets')->name('production_plans.variety_targets');
	Route::post('production_plans/seed_class_targets', 'ProductionPlansController@seed_class_targets')->name('production_plans.seed_class_targets');
	Route::post('production_plans/area_summary', 'ProductionPlansController@area_summary')->name('production_plans.area_summary');
	Route::post('production_plans/get_plots', 'ProductionPlansController@getPlots')->name('production_plans.get_plots');

	// Route::get('/production_plans/input_production_plan/{production_plan_id}', ['as' => 'production_plans.input_production_plan', 'uses' => 'ProductionPlansController@input_production_plan']);
	// Route::post('/production_plans/store_input_production_plan', ['as' => 'production_plans.store_input_production_plan', 'uses' => 'ProductionPlansController@store_input_production_plan']);

	Route::post('/production_plans/varieties_planted', ['as' => 'production_plans.varieties_planted', 'uses' => 'ProductionPlansController@varieties_planted']);
	Route::post('/production_plans/production_plan_plots', ['as' => 'production_plans.production_plan_plots', 'uses' => 'ProductionPlansController@production_plan_plots']);

	Route::post('/production_plans/delete_finalized_plan', ['as' => 'production_plans.delete_finalized_plan', 'uses' => 'ProductionPlansController@delete_finalized_plan']);
	Route::post('/production_plans/discontinue_production_plan', ['as' => 'production_plans.discontinue_production_plan', 'uses' => 'ProductionPlansController@discontinue_production_plan']);

	Route::post('production_plans/show_municipalities', ['as' => 'production_plans.show_municipalities', 'uses' => 'ProductionPlansController@show_municipalities']);

	Route::resource('/production_plans', 'ProductionPlansController');

	Route::post('/personnel/datatable', ['as' => 'personnel.datatable', 'uses' => 'PersonnelController@datatable']);
	Route::post('/personnel/update_personnel_status', ['as' => 'personnel.update_personnel_status', 'uses' => 'PersonnelController@update_personnel_status']);
	Route::post('/personnel/multiple_update_personnel_status', ['as' => 'personnel.multiple_update_personnel_status', 'uses' => 'PersonnelController@multiple_update_personnel_status']);
	Route::resource('/personnel', 'PersonnelController');

	Route::post('/activities/datatable', ['as' => 'activities.datatable', 'uses' => 'ActivitiesController@datatable']);
	Route::resource('/activities', 'ActivitiesController');

	Route::post('/reports/planting_plan/generate', ['as' => 'planting_plan.generate', 'uses' => 'Reports\PlantingPlanController@generate']);
	Route::post('/reports/planting_plan/export', ['as' => 'planting_plan.export', 'uses' => 'Reports\PlantingPlanController@export']);
	Route::post('/reports/planting_plan/exportToPDF', ['as' => 'planting_plan.exportToPDF', 'uses' => 'Reports\PlantingPlanController@exportToPDF']);
	Route::get('/reports/planting_plan', ['as' => 'planting_plan.index', 'uses' => 'Reports\PlantingPlanController@index']);

	Route::post('/reports/planting_report/generate', ['as' => 'planting_report.generate', 'uses' => 'Reports\PlantingReportController@generate']);
	Route::post('/reports/planting_report/export', ['as' => 'planting_report.export', 'uses' => 'Reports\PlantingReportController@export']);
	Route::post('/reports/planting_report/exportToPDF', ['as' => 'planting_report.exportToPDF', 'uses' => 'Reports\PlantingReportController@exportToPDF']);
	Route::get('/reports/planting_report', ['as' => 'planting_report.index', 'uses' => 'Reports\PlantingReportController@index']);

	// harvesting report
	Route::get('/reports/harvesting_report', 'Reports\HarvestingReportController@index')->name('harvesting_report.index');
	Route::post('/reports/harvesting_report/generate', 'Reports\HarvestingReportController@generate')->name('harvesting_report.generate');
	Route::post('/reports/harvesting_report/exportToPDF', 'Reports\HarvestingReportController@exportToPDF')->name('harvesting_report.exportToPDF');
	Route::post('/reports/harvesting_report/export', 'Reports\HarvestingReportController@export')->name('harvesting_report.export');

	// processing report
	Route::get('/reports/processing_report', 'Reports\ProcessingReportController@index')->name('processing_report.index');
	Route::post('/reports/processing_report/generate', 'Reports\ProcessingReportController@generate')->name('processing_report.generate');
	Route::post('/reports/processing_report/exportToPDF', 'Reports\ProcessingReportController@exportToPDF')->name('processing_report.exportToPDF');
	Route::post('/reports/processing_report/export', 'Reports\ProcessingReportController@export')->name('processing_report.export');

	// production efficiency report
	Route::get('/reports/production_efficiency_report', 'Reports\ProductionEfficiencyReportController@index')->name('production_efficiency_report.index');
	Route::post('/reports/production_efficiency_report/generate', 'Reports\ProductionEfficiencyReportController@generate')->name('production_efficiency_report.generate');
	Route::post('/reports/production_efficiency_report/exportToPDF', 'Reports\ProductionEfficiencyReportController@exportToPDF')->name('production_efficiency.exportToPDF');
	Route::post('/reports/production_efficiency_report/export', 'Reports\ProductionEfficiencyReportController@export')->name('production_efficiency_report.export');

	// certification tracker
	Route::get('/reports/certification_tracker', 'Reports\CertificationTrackerController@index')->name('certification_tracker.index');
	Route::post('/reports/certification_tracker/track', 'Reports\CertificationTrackerController@track')->name('certification_tracker.track');

	// SeedTrace Geotag Forms
	// Route::post('/seed_trace_geotag/seedling_management/datatable', ['as' => 'seedling_management.datatable', 'uses' => 'SeedTraceGeotag\SeedlingManagementController@datatable']);
	Route::post('/seed_trace_geotag/seedling_management/activities', ['as' => 'seedling_management.activities', 'uses' => 'SeedTraceGeotag\SeedlingManagementController@activities']);
	// Route::resource('/seed_trace_geotag/seedling_management', 'SeedTraceGeotag\SeedlingManagementController');

	// Route::post('/seed_trace_geotag/land_preparation/datatable', ['as' => 'land_preparation.datatable', 'uses' => 'SeedTraceGeotag\LandPreparationController@datatable']);
	Route::post('/seed_trace_geotag/land_preparation/activities', ['as' => 'land_preparation.activities', 'uses' => 'SeedTraceGeotag\LandPreparationController@activities']);
	// Route::resource('/seed_trace_geotag/land_preparation', 'SeedTraceGeotag\LandPreparationController');

	// Route::post('/seed_trace_geotag/crop_establishment/datatable', ['as' => 'crop_establishment.datatable', 'uses' => 'SeedTraceGeotag\CropEstablishmentController@datatable']);
	Route::post('/seed_trace_geotag/crop_establishment/activities', ['as' => 'crop_establishment.activities', 'uses' => 'SeedTraceGeotag\CropEstablishmentController@activities']);
	// Route::resource('/seed_trace_geotag/crop_establishment', 'SeedTraceGeotag\CropEstablishmentController');

	// Route::post('/seed_trace_geotag/water_management/datatable', ['as' => 'water_management.datatable', 'uses' => 'SeedTraceGeotag\WaterManagementController@datatable']);
	Route::post('/seed_trace_geotag/water_management/activities', ['as' => 'water_management.activities', 'uses' => 'SeedTraceGeotag\WaterManagementController@activities']);
	// Route::resource('/seed_trace_geotag/water_management', 'SeedTraceGeotag\WaterManagementController');

	// Route::post('/seed_trace_geotag/nutrient_management/datatable', ['as' => 'nutrient_management.datatable', 'uses' => 'SeedTraceGeotag\NutrientManagementController@datatable']);
	Route::post('/seed_trace_geotag/nutrient_management/activities', ['as' => 'nutrient_management.activities', 'uses' => 'SeedTraceGeotag\NutrientManagementController@activities']);
	// Route::resource('/seed_trace_geotag/nutrient_management', 'SeedTraceGeotag\NutrientManagementController');

	// Route::post('/seed_trace_geotag/disease_management/datatable', ['as' => 'disease_management.datatable', 'uses' => 'SeedTraceGeotag\DiseaseManagementController@datatable']);
	Route::post('/seed_trace_geotag/disease_management/activities', ['as' => 'disease_management.activities', 'uses' => 'SeedTraceGeotag\DiseaseManagementController@activities']);
	// Route::resource('/seed_trace_geotag/disease_management', 'SeedTraceGeotag\DiseaseManagementController');

	// Route::post('/seed_trace_geotag/pest_management/datatable', ['as' => 'pest_management.datatable', 'uses' => 'SeedTraceGeotag\PestManagementController@datatable']);
	Route::post('/seed_trace_geotag/pest_management/activities', ['as' => 'pest_management.activities', 'uses' => 'SeedTraceGeotag\PestManagementController@activities']);
	// Route::resource('/seed_trace_geotag/pest_management', 'SeedTraceGeotag\PestManagementController');

	// Route::post('/seed_trace_geotag/roguing/datatable', ['as' => 'roguing.datatable', 'uses' => 'SeedTraceGeotag\RoguingController@datatable']);
	Route::post('/seed_trace_geotag/roguing/activities', ['as' => 'roguing.activities', 'uses' => 'SeedTraceGeotag\RoguingController@activities']);
	// Route::resource('/seed_trace_geotag/roguing', 'SeedTraceGeotag\RoguingController');

	// Route::post('/seed_trace_geotag/harvesting/datatable', ['as' => 'harvesting.datatable', 'uses' => 'SeedTraceGeotag\HarvestingController@datatable']);
	Route::post('/seed_trace_geotag/harvesting/activities', ['as' => 'harvesting.activities', 'uses' => 'SeedTraceGeotag\HarvestingController@activities']);
	// Route::resource('/seed_trace_geotag/harvesting', 'SeedTraceGeotag\HarvestingController');

	// Route::post('/seed_trace_geotag/damage_assessment/datatable', ['as' => 'damage_assessment.datatable', 'uses' => 'SeedTraceGeotag\DamageAssessmentController@datatable']);
	Route::post('/seed_trace_geotag/damage_assessment/activities', ['as' => 'damage_assessment.activities', 'uses' => 'SeedTraceGeotag\DamageAssessmentController@activities']);
	// Route::resource('/seed_trace_geotag/damage_assessment', 'SeedTraceGeotag\DamageAssessmentController');

	// Data monitoring
    Route::get('/data_monitoring', ['as' => 'data_monitoring.index', 'uses' => 'DataMonitoringController@index']);
    Route::get('/data_monitoring/show_data', ['as' => 'data_monitoring.show_data', 'uses' => 'DataMonitoringController@show_data']);
    Route::post('/data_monitoring/datatable', ['as' => 'data_monitoring.datatable', 'uses' => 'DataMonitoringController@datatable']);

    Route::get('/data_monitoring_geotag', ['as' => 'data_monitoring_geotag.index', 'uses' => 'DataMonitoringGeotagController@index']);
    Route::get('/data_monitoring_geotag/show_data', ['as' => 'data_monitoring_geotag.show_data', 'uses' => 'DataMonitoringGeotagController@show_data']);
    Route::post('/data_monitoring_geotag/datatable', ['as' => 'data_monitoring_geotag.datatable', 'uses' => 'DataMonitoringGeotagController@datatable']);

    Route::get('data_submission', ['as' => 'data_submission.index', 'uses' => 'DataSubmissionController@index']);

    // Target varieties
    Route::get('/target_varieties', 'TargetVarietiesController@index')->name('target_varieties.index');
    Route::post('/target_varieties/datatable', 'TargetVarietiesController@datatable')->name('target_varieties.datatable');
    Route::post('/target_varieties/store', 'TargetVarietiesController@store')->name('target_varieties.store');
    Route::post('/target_varieties/destroy', 'TargetVarietiesController@destroy')->name('target_varieties.destroy');

    // Production Cost Schedule
    Route::get('/production_cost_schedule', 'ProductionCostScheduleController@index')->name('production_cost_schedule.index');
    Route::post('/production_cost_schedule/datatable', 'ProductionCostScheduleController@datatable')->name('production_cost_schedule.datatable');
    Route::get('/production_cost_schedule/create', 'ProductionCostScheduleController@create')->name('production_cost_schedule.create');
    Route::post('/production_cost_schedule/store', 'ProductionCostScheduleController@store')->name('production_cost_schedule.store');
    Route::get('/production_cost_schedule/show/{prod_cost_sched_id}', 'ProductionCostScheduleController@show')->name('production_cost_schedule.show');
    Route::get('/production_cost_schedule/edit/{prod_cost_sched_id}', 'ProductionCostScheduleController@edit')->name('production_cost_schedule.edit');
    Route::patch('/production_cost_schedule/update/{prod_cost_sched_id}', 'ProductionCostScheduleController@update')->name('production_cost_schedule.update');
    Route::get('/production_cost_schedule/evaluate/{prod_cost_sched_id}', 'ProductionCostScheduleController@evaluate')->name('production_cost_schedule.evaluate');
    Route::delete('/production_cost_schedule/{production_cost_id}', 'ProductionCostScheduleController@delete')->name('production_cost_schedule.delete');
    Route::post('/production_cost_schedule/submit_evaluation', 'ProductionCostScheduleController@submit_evaluation')->name('production_cost_schedule.submit_evaluation');
    Route::get('/production_cost_schedule/exportToPDF/{production_cost_id}', 'ProductionCostScheduleController@exportToPDF')->name('production_cost_schedule.exportToPDF');
    Route::get('/production_cost_schedule/exportToExcel/{production_cost_id}', 'ProductionCostScheduleController@exportToExcel')->name('production_cost_schedule.exportToExcel');

    // seed production activities
    Route::get('/seed_production_activities/activities_viewer', 'SeedProductionActivitiesController@activities_viewer')->name('seed_production_activities.activities_viewer');
    Route::post('/seed_production_activities/activities_viewer/show', 'SeedProductionActivitiesController@show_activities')->name('seed_production_activities.show_activities');

    // submitted activities from seed production app
    Route::get('/seed_production_activities/submitted_activities', 'SeedProductionActivitiesController@submitted_activities')->name('seed_production_activities.submitted_activities');
    Route::post('/seed_production_activities/datatable_submitted_activities', 'SeedProductionActivitiesController@datatable_submitted_activities')->name('seed_production_activities.datatable_submitted_activities');

    // routes for getting seed production app submitted data for different field activities
    Route::get('field_activity/land_preparation/{land_preparation_id}', 'FieldActivitiesController@land_preparation')->name('field_activity.land_preparation');
    Route::get('field_activity/seedling_management/{seedling_management_id}', 'FieldActivitiesController@seedling_management')->name('field_activity.seedling_management');
    Route::get('field_activity/crop_establishment/{crop_establishment_id}', 'FieldActivitiesController@crop_establishment')->name('field_activity.crop_establishment');
    Route::get('field_activity/water_management/{water_management_id}', 'FieldActivitiesController@water_management')->name('field_activity.water_management');
    Route::get('field_activity/nutrient_management/{nutrient_management_id}', 'FieldActivitiesController@nutrient_management')->name('field_activity.nutrient_management');
    Route::get('field_activity/roguing/{roguing_id}', 'FieldActivitiesController@roguing')->name('field_activity.roguing');
    Route::get('field_activity/pest_management/{pest_management_id}', 'FieldActivitiesController@pest_management')->name('field_activity.pest_management');
    Route::get('field_activity/harvesting/{harvesting_id}', 'FieldActivitiesController@harvesting')->name('field_activity.harvesting');

    // route for getting seed production app location where the activity has been conducted
    Route::get('field_activity/map/{activity_name}/{activity_id}', 'FieldActivitiesController@map')->name('field_activity.map');

	Route::get('/seed_distribution', 'SeedDistributionController@index')->name('seed_distribution.index');
	Route::post('/seed_distribution/datatable', 'SeedDistributionController@datatable')->name('seed_distribution.datatable');
	Route::get('/seed_distribution/create', 'SeedDistributionController@create')->name('seed_distribution.create');
	Route::post('/seed_distribution/store', 'SeedDistributionController@store')->name('seed_distribution.store');
	Route::post('/seed_distribution/get_farmer_area', 'SeedDistributionController@getFarmerArea')->name('seed_distribution.get_farmer_area');
	Route::post('/seed_distribution/delete', 'SeedDistributionController@delete')->name('seed_distribution.delete');

	Route::get('/seed_inventory', 'SeedInventoryController@index')->name('seed_inventory.index');
	Route::post('/seed_inventory/datatable', 'SeedInventoryController@datatable')->name('seed_inventory.datatable');
	Route::get('/seed_inventory/create', 'SeedInventoryController@create')->name('seed_inventory.create');
	Route::post('/seed_inventory/store', 'SeedInventoryController@store')->name('seed_inventory.store');

	Route::get('/fertilizer_inventory', 'FertilizerInventoryController@index')->name('fertilizer_inventory.index');
	Route::post('/fertilizer_inventory/datatable', 'FertilizerInventoryController@datatable')->name('fertilizer_inventory.datatable');
	Route::get('/fertilizer_inventory/create', 'FertilizerInventoryController@create')->name('fertilizer_inventory.create');
	Route::post('/fertilizer_inventory/store', 'FertilizerInventoryController@store')->name('fertilizer_inventory.store');

	Route::get('/fertilizer_distribution', 'FertilizerDistributionController@index')->name('fertilizer_distribution.index');
	Route::post('/fertilizer_distribution/datatable', 'FertilizerDistributionController@datatable')->name('fertilizer_distribution.datatable');
	Route::get('/fertilizer_distribution/create', 'FertilizerDistributionController@create')->name('fertilizer_distribution.create');
	Route::post('/fertilizer_distribution/store', 'FertilizerDistributionController@store')->name('fertilizer_distribution.store');
	Route::post('/fertilizer_distribution/delete', 'FertilizerDistributionController@delete')->name('fertilizer_distribution.delete');

	Route::post('/production_plans/drone_images/store', 'ProductionPlansController@storeDroneImages')->name('production_plans.drone_images.store');
	Route::post('/production_plans/drone_images/update', 'ProductionPlansController@updateDroneImages')->name('production_plans.drone_images.update');
});
