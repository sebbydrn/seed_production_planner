<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class Offtype extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "offtypes";
    protected $primaryKey = "offtype_id";
	protected $fillable = ['offtype_id', 'roguing_id', 'offtype_kind'];
	public $timestamps = false;

}
