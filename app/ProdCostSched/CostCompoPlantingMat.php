<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoPlantingMat extends Model
{
    protected $table = "cost_compo_planting_mat";
    protected $primaryKey = "planting_mat_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'area1',
        'area2',
        'area1_seed_quantity',
        'area1_cost',
        'area1_amount',
        'area2_seed_quantity',
        'area2_cost',
        'area2_amount',
        'sub_total'
    ];
    public $timestamps = false;
}
