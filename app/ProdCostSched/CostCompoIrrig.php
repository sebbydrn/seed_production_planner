<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoIrrig extends Model
{
    protected $table = "cost_compo_irrig";
    protected $primaryKey = "irrig_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'area',
        'cost',
        'amount'
    ];
    public $timestamps = false;
}
