<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoSeedPull extends Model
{
    protected $table = "cost_compo_seed_pull";
    protected $primaryKey = "seed_pull_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'pulling_area',
        'pulling_cost',
        'pulling_amount',
        'replanting_labor_no',
        'replanting_labor_area',
        'replanting_labor_cost',
        'replanting_labor_amount'
    ];
    public $timestamps = false;
}
