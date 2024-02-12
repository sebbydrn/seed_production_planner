<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoDrying extends Model
{
    protected $table = "cost_compo_drying";
    protected $primaryKey = "drying_id";
    protected $fillable = [
        'post_production_id',
        'sem',
        'drying_bags_no',
        'drying_cost',
        'drying_amount',
        'emergency_labor_no',
        'emergency_labor_days',
        'emergeny_labor_cost',
        'emergency_labor_amount',
        'sub_total'
    ];
    public $timestamps = false;
}
