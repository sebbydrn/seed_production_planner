<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoHarvesting extends Model
{
    protected $table = "cost_compo_harvesting";
    protected $primaryKey = "harvesting_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'manual_area',
        'manual_cost',
        'manual_amount',
        'mechanical_area',
        'mechanical_cost',
        'mechanical_amount',
        'hauling_ave_bags',
        'hauling_bag_no',
        'hauling_cost',
        'hauling_amount',
        'threshing_area',
        'threshing_cost',
        'threshing_amount',
        'towing_area',
        'towing_cost',
        'towing_amount',
        'scatter_area',
        'scatter_cost',
        'scatter_amount',
        'sub_total'
    ];
    public $timestamps = false;
}
