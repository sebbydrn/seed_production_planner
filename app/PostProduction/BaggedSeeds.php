<?php

namespace App\PostProduction;

use Illuminate\Database\Eloquent\Model;

class BaggedSeeds extends Model
{
    protected $connection = "post_production";
    protected $table = "bagged_seeds";
    protected $primaryKey = "bagged_seeds_id";
}
