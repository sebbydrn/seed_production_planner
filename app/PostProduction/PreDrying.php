<?php

namespace App\PostProduction;

use Illuminate\Database\Eloquent\Model;

class PreDrying extends Model
{
    protected $connection = "post_production";
    protected $table = "pre_drying";
    protected $primaryKey = "pre_drying_id";
}
