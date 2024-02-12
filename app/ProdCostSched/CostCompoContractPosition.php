<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoContractPosition extends Model
{
    protected $table = "cost_compo_contract_positions";
    protected $primaryKey = "contract_position_id";
    protected $fillable = [
        'contract_id',
        'contract_no',
        'position',
        'monthly_rate',
        'monthly_cost',
        'amount'
    ];
    public $timestamps = false;
}
