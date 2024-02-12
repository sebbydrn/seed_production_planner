<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeedProductionTechnology extends Model {
    
    protected $table = "seed_production_technologies";
	protected $primaryKey = "tech_id";
	protected $fillable = ['tech_id', 'year', 'sem', 'soaking_hrs', 'incubation_hrs', 'sowing_hrs', 'seedbed_irrigation_min_DAS', 'seedbed_irrigation_max_DAS', 'seedbed_irrigation_interval', 'seedling_fertilizer_app_init_DAS', 'seedling_fertilizer_app_final_DAS', 'plowing_DAS', 'harrowing_1_DAS', 'harrowing_2_DAS', 'harrowing_3_DAS', 'levelling_DAS', 'seedling_age', 'pulling_to_transplanting', 'replanting_window_min_DAT', 'replanting_window_max_DAT', 'irrigation_min_DAT', 'irrigation_max_DAT', 'irrigation_interval', 'fertilizer_app_1_DAT', 'fertilizer_app_2_DAT', 'fertilizer_app_3_DAT', 'fertilizer_app_final_DAT', 'pre_emergence_app_DAT', 'post_emergence_app_DAT'];
	public $timestamps = false;

	public function seed_production_activities() {
		return $this->hasMany('App\SeedProductionTechnologyActivities', 'tech_id', 'tech_id');
	}

}
