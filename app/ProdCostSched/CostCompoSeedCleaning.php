<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoSeedCleaning extends Model
{
    protected $table = "cost_compo_seed_cleaning";
    protected $primaryKey = "seed_cleaning_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'ave_bags',
        'bags_no',
        'cost',
        'amount'
    ];
    public $timestamps = false;
}
