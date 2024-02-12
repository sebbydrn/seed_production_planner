<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Passwords;
use DB;

class User extends Authenticatable
{
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = 'rsis';

    protected $primaryKey = 'user_id';

    protected $fillable = ['firstname', 'middlename', 'lastname', 'extname', 'username', 'email', 'secondaryemail', 'birthday', 'sex', 'country', 'region', 'province', 'municipality', 'barangay', 'philrice_idno', 'designation', 'fullname', 'isactive', 'isapproved', 'cooperative', 'agency', 'school', 'contact_no'];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'password'
    ];

    public function passwords() {
        return $this->hasOne('App\Passwords', 'user_id');
    }

    public function getPasswordAttribute() {
        return $this->passwords->getAttribute('password');
    }

    public function affiliation() {
        return $this->hasOne('App\AffiliationUser', 'user_id', 'user_id');
    }

    public function add_log($log) {
        DB::connection('rsis')->table('activities_user')->insert($log);
    }
}