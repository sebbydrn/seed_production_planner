<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoFuel extends Model
{
    protected $table = "cost_compo_fuel";
    protected $primaryKey = "fuel_id";
    protected $fillable = [
        'production_cost-id',
        'sem',
        'diesel_liters',
        'diesel_cost',
        'diesel_amount',
        'gas_liters',
        'gas_cost',
        'gas_amount',
        'kerosene_liters',
        'kerosene_cost',
        'kerosene_amount',
        'sub_total'
    ];
    public $timestamps = false;
}
