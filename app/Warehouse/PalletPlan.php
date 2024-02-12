<?php

namespace App\Warehouse;

use Illuminate\Database\Eloquent\Model;

class PalletPlan extends Model
{
    protected $connection = "warehouse";
    protected $table = "pallet_plan";
    protected $primaryKey = "pallet_plan_id";
}
