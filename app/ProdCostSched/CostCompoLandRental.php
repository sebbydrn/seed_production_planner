<?php

namespace App\ProdCostSched;

use Illuminate\Database\Eloquent\Model;

class CostCompoLandRental extends Model
{
    protected $table = "cost_compo_land_rental";
    protected $primaryKey = "land_rental_id";
    protected $fillable = [
        'production_cost_id',
        'sem',
        'area',
        'cost',
        'amount'
    ];
    public $timestamps = false;
}
