<?php

namespace App\SeedTraceGeotag;

use Illuminate\Database\Eloquent\Model;

class DiseaseManagement extends Model {
    
	protected $connection = "seedTraceGeotag";
	protected $table = "disease_management";
    protected $primaryKey = "disease_management_id";
	protected $fillable = ['disease_management_id', 'production_plot_code', 'crop_phase', 'disease_type', 'other_disease', 'control_type', 'control_spec', 'chemical_used', 'active_ingredient', 'application_mode', 'brand_name', 'formulation', 'unit', 'total_chemical_used', 'tank_load_no', 'tank_load_volume', 'tank_load_rate', 'datetime_start', 'datetime_end', 'labor_cost', 'workers_no', 'remarks', 'image', 'location_point'];
	public $timestamps = false;

}
