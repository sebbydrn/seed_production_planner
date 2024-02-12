<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    protected $table = "farmers";
    protected $primaryKey = "farmer_id";
	protected $fillable = ['rsbsa_no', 'farmer_id', 'first_name', 'last_name', 'middle_name', 'suffix', 'birthdate', 'sex', 'barangay'];
	public $timestamps = false;
}