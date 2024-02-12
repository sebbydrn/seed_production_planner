<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class SeedlingManagement extends Model {
    
    protected $connection = "seedTraceGeotag";
	protected $table = "seedling_management";
    protected $primaryKey = "seedling_management_id";
	protected $fillable = ['seedling_management_id', 'production_plot_code', 'activity', 'transplanting_method', 'status', 'timestamp', 'remarks', 'location_point'];

	public $timestamps = false;

	public function seed_certification() {
		return $this->hasOne('App\SeedTraceGeotag\SeedCertification', 'production_plot_code', 'production_plot_code');
	}

}
