<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class WaterManagement extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "water_management";
    protected $primaryKey = "water_management_id";
	protected $fillable = ['water_management_id', 'production_plot_code', 'crop_stage', 'crop_phase', 'activity', 'datetime_start', 'datetime_end', 'labor_cost', 'workers_no', 'remarks', 'location_point'];
	public $timestamps = false;

}
