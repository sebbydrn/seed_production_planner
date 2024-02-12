<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonnelActivities extends Model {
    
	protected $primaryKey = "personnel_activity_id";
	protected $fillable = [
		'personnel_id',
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

	public function personnel() {
		return $this->belongsTo('App\Personnel', 'personnel_id', 'personnel_id');
	}

}
