<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoProdContract extends Model
{
    protected $table = "cost_compo_prod_contract";
    protected $primaryKey = "prod_contract_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'seed_volume',
        'buying_price',
        'amount'
    ];
    public $timestamps = false;
}
