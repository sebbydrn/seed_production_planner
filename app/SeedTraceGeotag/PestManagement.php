<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class PestManagement extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "pest_management";
    protected $primaryKey = "pest_management_id";
	protected $fillable = ['pest_management_id', 'production_plot_code', 'crop_phase', 'pest_type', 'pest_spec', 'control_type', 'control_spec', 'chemical_used', 'active_ingredient', 'application_mode', 'brand_name', 'formulation', 'unit', 'total_chemical_used', 'tank_load_no', 'tank_load_volume', 'tank_load_rate', 'datetime_start', 'datetime_end', 'labor_cost', 'workers_no', 'remarks', 'image', 'location_point'];
	public $timestamps = false;

}
