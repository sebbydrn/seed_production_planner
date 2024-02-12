<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetVarietyActivities extends Model
{
    protected $table = "target_variety_activities";
    protected $primaryKey = "target_variety_activity_id";
    protected $fillable = ['user_id', 'activity', 'browser', 'device', 'ip_env_address', 'ip_server_address', 'OS'];
    public $timestamps = false;
}
