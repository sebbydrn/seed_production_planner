<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class LandPreparation extends Model  {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "land_preparation";
    protected $primaryKey = "land_preparation_id";
	protected $fillable = ['land_preparation_id', 'production_plot_code', 'crop_phase', 'activity', 'datetime_start', 'datetime_end', 'labor_cost', 'workers_no', 'remarks', 'location_point'];
	public $timestamps = false;

}
