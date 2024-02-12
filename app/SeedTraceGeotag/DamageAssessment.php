<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class DamageAssessment extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "damage_assessment";
    protected $primaryKey = "damage_assessment_id";
	protected $fillable = ['damage_assessment_id', 'production_plot_code', 'timestamp', 'damage_cause', 'damage_spec', 'remarks', 'image', 'location_point'];
	public $timestamps = false;

}
