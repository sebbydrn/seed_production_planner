<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class SeedCertification extends Model
{
    protected $connection = "seedTraceGeotag";
    protected $table = "seed_certification";
    protected $primaryKey = "seed_certification_id";
}
