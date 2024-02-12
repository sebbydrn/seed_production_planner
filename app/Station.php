<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model {
    
	protected $connection = "rsis";
	protected $table = "philrice_station";
	protected $primaryKey = "philrice_station_id";

	public function affiliation() {
		return $this->belongsTo('App\AffiliationUser', 'affiliated_to', 'philrice_station_id');
	}

}
