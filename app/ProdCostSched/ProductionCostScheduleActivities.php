<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class ProductionCostScheduleActivities extends Model
{
    protected $table = "production_cost_schedule_activities";
    protected $primaryKey = "prod_cost_sched_activity_id";
    protected $fillable = [
        'prod_cost_sched_id',
        'user_id',
        'activity',
        'browser',
        'device',
        'ip_env_address',
        'ip_server_address',
        'new_value',
        'old_value',
        'OS'
    ];
    public $timestamps = false;
}
