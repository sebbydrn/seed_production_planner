<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FertilizerDistributionList extends Model {
    
    protected $table = "fertilizer_distribution_list";

    protected $primaryKey = "fertilizer_distribution_list_id";
    
    protected $fillable = [
        'fertilizer_distribution_list_id',
        'farmer_id',
        'fertilizer',
        'quantity',
        'area',
        'date_distributed',
        'semester',
        'year'
    ];

    public $timestamps = false;

}