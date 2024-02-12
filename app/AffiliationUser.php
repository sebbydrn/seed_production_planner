<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliationUser extends Model {
   
	protected $connection = "rsis";
	protected $table = "affiliation_user";
	protected $primaryKey = "affiliation_user_id";

	public function station() {
		return $this->hasOne('App\Station', 'philrice_station_id', 'affiliated_to');
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id', 'user_id');
	}

}
