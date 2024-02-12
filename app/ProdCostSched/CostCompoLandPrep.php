<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoLandPrep extends Model
{
    protected $table = "cost_compo_land_prep";
    protected $primaryKey = "land_prep_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'rotovate_area',
        'rotovate_cost',
        'rotovate_amount',
        'levelling_area',
        'levelling_cost',
        'levelling_amount',
        'sub_total'
    ];
    public $timestamps = false;
}
