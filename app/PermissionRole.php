<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $connection = 'rsis';

    protected $table = 'permission_role';

    public $timestamps = false;
}
