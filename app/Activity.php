<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {
    
	protected $table = "activities";
    protected $primaryKey = "activity_id";
	protected $fillable = ['activity_id', 'name'];
	public $timestamps = false;

	public function activities() {
		return $this->hasMany('App\ActivitiesLogs', 'activity_id', 'activity_id');
	}

}
