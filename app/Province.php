<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $connection = "seed_grow";
    protected $table = "provinces";
}
