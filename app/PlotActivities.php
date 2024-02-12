<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotActivities extends Model {
    
	protected $primaryKey = "plot_activity_id";
	protected $fillable = [
		'pallet_id',
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

	public function plot() {
		return $this->belongsTo('App\Plot', 'plot_id', 'plot_id');
	}

}
