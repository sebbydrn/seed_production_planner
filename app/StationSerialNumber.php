<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StationSerialNumber extends Model
{
    protected $connection = "rsis";
    protected $table = "philrice_station_serial_numbers";
    protected $primaryKey = "serial_number_id";
}
