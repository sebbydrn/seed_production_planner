<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FertilizerInventory extends Model {
    
    protected $table = "fertilizer_inventory";

    protected $primaryKey = "fertilizer_inventory_id";
    
    protected $fillable = [
        'fertilizer_inventory_id',
        'fertilizer',
        'bags',
        'remaining_bags',
        'date_created',
        'date_updated',
    ];

    public $timestamps = false;

}