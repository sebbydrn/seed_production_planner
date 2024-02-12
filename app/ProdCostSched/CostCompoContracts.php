<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoContracts extends Model
{
    protected $table = "cost_compo_contracts";
    protected $primaryKey = "contract_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'months_no',
        'sub_total'
    ];
    public $timestamps = false;

    public function positions() {
        return $this->hasMany('\App\ProdCostSched\CostCompoContractPosition', 'contract_id', 'contract_id');
    }
}
