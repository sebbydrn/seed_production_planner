<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class NutrientManagement extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "nutrient_management";
    protected $primaryKey = "nutrient_management_id";
	protected $fillable = ['nutrient_management_id', 'production_plot_code', 'techonology_used', 'fertilizer_used', 'other_fertilizer', 'formulation', 'unit', 'total_chemical_used', 'tank_load_no', 'tank_load_volume', 'tank_load_rate', 'datetime_start', 'datetime_end', 'labor_cost', 'workers_no', 'remarks', 'is_water_available', 'image', 'location_point'];
	public $timestamps = false;

}
