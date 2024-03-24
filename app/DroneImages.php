<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DroneImages extends Model
{
    protected $table = 'drone_images';
    protected $primaryKey = 'drone_image_id';
    protected $fillable = ['name', 'link', 'production_plan_id'];
    public $timestamps = false;
}