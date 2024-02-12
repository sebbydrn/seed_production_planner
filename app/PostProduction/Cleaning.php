<?php

namespace App\PostProduction;

use Illuminate\Database\Eloquent\Model;

class Cleaning extends Model
{
    protected $connection = "post_production";
    protected $table = "cleaning";
    protected $primaryKey = "cleaning_id";
}
