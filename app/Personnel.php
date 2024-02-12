<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model {

	protected $table = "personnel";
    protected $primaryKey = "personnel_id";
	protected $fillable = ['personnel_id', 'emp_idno', 'name', 'first_name', 'last_name', 'role', 'is_active', 'is_deleted', 'philrice_station_id'];
	public $timestamps = false;

	public function activities() {
		return $this->hasMany('App\PersonnelActivities', 'personnel_id', 'personnel_id');
	}

}
