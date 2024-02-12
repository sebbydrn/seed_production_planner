<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoFertilizers extends Model
{
    protected $table = "cost_compo_fertilizers";
    protected $primaryKey = "fertilizer_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'area',
        'cost',
        'amount'
    ];
    public $timestamps = false;
}
