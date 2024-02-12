<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model {
    
	protected $primaryKey = "plot_id";
	protected $fillable = ['plot_id', 'name', 'coordinates', 'area', 'is_active', 'farmer_id'];
	public $timestamps = false;

	public function activities() {
		return $this->hasMany('App\PlotActivities', 'plot_id', 'plot_id');
	}

}
