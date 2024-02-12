<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivitiesLogs extends Model {
    
	protected $primaryKey = "activity_log_id";
	protected $fillable = [
		'activity_id',
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

	public function activity() {
		return $this->belongsTo('App\Activity', 'activity_id', 'activity_id');
	}

}
