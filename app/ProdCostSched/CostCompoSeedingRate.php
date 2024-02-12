<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoSeedingRate extends Model
{
    protected $table = "cost_compo_seeding_rate";
    protected $primaryKey = "seeding_rate_id";
    protected $fillable = [
        'production_cost_id',
        'seeding_rate'
    ];
    public $timestamps = false;
}
