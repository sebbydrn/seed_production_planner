<?php

namespace App\PostProduction;

use Illuminate\Database\Eloquent\Model;

class PostDrying extends Model
{
    protected $connection = "post_production";
    protected $table = "post_drying";
    protected $primaryKey = "post_drying_id";
}
