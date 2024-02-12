<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class Harvesting extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "harvesting";
    protected $primaryKey = "harvesting_id";
	protected $fillable = ['harvesting_id', 'production_plot_code', 'harvesting_method', 'timestamp', 'bags_no', 'remarks', 'image', 'location_point'];
	public $timestamps = false;

}
