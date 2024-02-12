<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoSeedLab extends Model
{
    protected $table = "cost_compo_seed_lab";
    protected $primaryKey = "seed_lab_id";
    protected $fillable = [
        'production_cost_id',
        'amount_s1',
        'amount_s2'
    ];
    public $timestamps = false;
}
