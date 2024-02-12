<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionPlanActivities extends Model {
    
	protected $primaryKey = "production_plan_activity_id";
	protected $fillable = [
		'production_plan_id',
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

	public function production_plan() {
		return $this->belongsTo('App\ProductionPlan', 'production_plan_id', 'production_plan_id');
	}

}
