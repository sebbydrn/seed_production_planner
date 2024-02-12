<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoFieldSupp extends Model
{
    protected $table = "cost_compo_field_supp";
    protected $primaryKey = "field_supp_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'sack1_no',
        'sack1_cost',
        'sack1_amount',
        'sack2_no',
        'sack2_cost',
        'sack2_amount',
        'sack3_no',
        'sack3_cost',
        'sack3_amount',
        'other_supplies_amount',
        'sub_total'
    ];
    public $timestamps = false;
}
