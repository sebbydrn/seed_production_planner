<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $connection = "seed_grow";
    protected $table = "municipalities";
}
