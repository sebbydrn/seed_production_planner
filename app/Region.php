<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $connection = "seed_grow";
    protected $table = "regions";
}
