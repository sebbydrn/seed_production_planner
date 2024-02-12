<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionPlotCode extends Model {
    
	protected $primaryKey = "production_plot_code_id";
	protected $fillable = ['production_plot_code_id', 'production_plan_id', 'production_plot_code', 'season_code'];
	public $timestamps = false;

}
