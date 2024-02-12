<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeedProductionTechnologyActivities extends Model {
    	
    protected $table = "seed_production_technologies_activities";
	protected $primaryKey = "seed_production_technologies_act_id";
	protected $fillable = [
		'tech_id',
		'user_id',
		'activity',
		'browser',
		'device',
		'ip_env_address',
		'ip_server_address',
		'new_value',
		'old_value',
		'OS'
	];
	public $timestamps = false;

	public function seed_production_technology() {
		return $this->belongsTo('App\SeedProductionTechnology', 'tech_id', 'tech_id');
	}

}
