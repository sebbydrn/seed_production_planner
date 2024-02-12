<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionPlan extends Model {
    
	protected $primaryKey = "production_plan_id";
	protected $fillable = ['production_plan_id', 'year', 'sem', 'variety', 'seed_class', 'seed_quantity', 'source_seed_lot', 'seed_production_in_charge', 'tech_id', 'seed_soaking_start', 'is_finalized', 'philrice_station_id', 'region', 'province', 'municipality', 'barangay', 'sitio', 'rice_program'];
	public $timestamps = false;

	public function activities() {
		return $this->hasMany('App\ProductionPlanActivities', 'production_plan_id', 'production_plan_id');
	}

}
