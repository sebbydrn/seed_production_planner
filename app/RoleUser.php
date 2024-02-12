<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $connection = 'rsis';

    protected $table = 'role_user';

    public $timestamps = false;
}
