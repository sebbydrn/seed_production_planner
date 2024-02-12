<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class Roguing extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "roguing";
    protected $primaryKey = "roguing_id";
	protected $fillable = ['roguing_id', 'production_plot_code', 'crop_phase', 'offtypes_removed_count', 'timestamp', 'laborers', 'remarks', 'location_point'];
	public $timestamps = false;

	public function offtypes() {
		return $this->hasMany('App\SeedTraceGeotag\Offtype', 'roguing_id', 'roguing_id');
	}
}
