<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeedDistributionList extends Model {
    
    protected $table = "seed_distribution_list";

    protected $primaryKey = "seed_distribution_list_id";
    
    protected $fillable = [
        'seed_distribution_list_id',
        'farmer_id',
        'variety',
        'quantity',
        'area',
        'date_distributed',
        'semester',
        'year'
    ];

    public $timestamps = false;

}