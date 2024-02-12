<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannedActivity extends Model {
    
	protected $table = "planned_activities";
	protected $primaryKey = "planned_activity_id";
	protected $fillable = ['planned_activity_id', 'production_plan_id', 'activity_id', 'date_start', 'date_end', 'date_alert'];
	public $timestamps = false;

	public function activity() {
		return $this->hasMany('App\Activity', 'activity_id', 'activity_id');
	}

}
