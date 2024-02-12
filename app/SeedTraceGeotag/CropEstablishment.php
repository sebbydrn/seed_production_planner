<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class CropEstablishment extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "crop_establishment";
    protected $primaryKey = "crop_establishment_id";
	protected $fillable = ['crop_establishment_id', 'production_plot_code', 'activity', 'transplanting_method', 'datetime_start', 'datetime_end', 'labor_cost', 'workers_no', 'remarks', 'location_point'];
	public $timestamps = false;

}
