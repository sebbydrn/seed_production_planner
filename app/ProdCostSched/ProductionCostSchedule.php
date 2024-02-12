<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class ProductionCostSchedule extends Model
{
    protected $table = "production_cost_schedule";
    protected $primaryKey = "production_cost_id";
    protected $fillable = [
        'production_cost_id',
        'total_s1',
        'total_s2',
        'timestamp',
        'is_approved',
        'remarks',
        'philrice_station_id',
        'year',
        'area_station',
        'area_outside',
        'area_contract',
        'area1_s1',
        'area1_s2',
        'area2_s1',
        'area2_s2',
        'volume_clean1_s1',
        'volume_clean1_s2',
        'volume_clean2_s1',
        'volume_clean2_s2',
        'production_cost_kilo_s1',
        'production_cost_kilo_s2',
        'production_cost_ha_s1',
        'production_cost_ha_s2',
        'seed_production_type'
    ];
    public $timestamps = false;
}
