<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeedInventory extends Model {
    
    protected $table = "seed_inventory";

    protected $primaryKey = "seed_inventory_id";
    
    protected $fillable = [
        'seed_inventory_id',
        'variety',
        'bags',
        'seed_type',
        'remaining_bags',
        'date_created',
        'date_updated',
        'kilograms',
        'kilograms_remaining',
    ];

    public $timestamps = false;

}