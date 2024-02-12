<?php

namespace App\PostProduction;

use Illuminate\Database\Eloquent\Model;

class ProcessingCode extends Model
{
    protected $connection = "post_production";
    protected $table = "processing_codes";
    protected $primaryKey = "processing_code_id";
}
