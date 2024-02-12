<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionPlot extends Model {
    
	protected $primaryKey = "production_plot_id";
	protected $fillable = ['production_plot_id', 'production_plan_id', 'plot_id'];
	public $timestamps = false;

	public function area() {
		return $this->belongsTo('App\Plot', 'plot_id', 'plot_id');
	}

}
