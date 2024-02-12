<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetVarieties extends Model
{
    protected $table = "target_varieties";
    protected $primaryKey = "target_variety_id";
    protected $fillable = ['philrice_station_id', 'year', 'sem', 'variety', 'area', 'is_deleted', 'remarks', 'is_approved', 'seed_type', 'hybrid_seed_type', 'parentals_type'];
    public $timestamps = false;
}
