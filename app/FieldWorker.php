<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldWorker extends Model {
    
	protected $primaryKey = "worker_id";
	protected $fillable = ['worker_id', 'production_plan_id', 'personnel_id'];
	public $timestamps = false;

}
