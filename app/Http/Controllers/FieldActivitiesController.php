<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeedTraceGeotag\LandPreparation;
use App\SeedTraceGeotag\SeedlingManagement;
use App\SeedTraceGeotag\CropEstablishment;
use App\SeedTraceGeotag\WaterManagement;
use App\SeedTraceGeotag\NutrientManagement;
use App\SeedTraceGeotag\Roguing;
use App\SeedTraceGeotag\PestManagement;
use App\SeedTraceGeotag\Harvesting;

class FieldActivitiesController extends Controller
{
    public function land_preparation($land_preparation_id) {
        $data = LandPreparation::find($land_preparation_id);

        echo json_encode($data);
    }

    public function seedling_management($seedling_management_id) {
        $data = SeedlingManagement::where('seedling_management_id', $seedling_management_id)
        ->with('seed_certification')
        ->first();

        echo json_encode($data);
    }

    public function crop_establishment($crop_establishment_id) {
        $data = CropEstablishment::find($crop_establishment_id);

        echo json_encode($data);
    }

    public function water_management($water_management_id) {
        $data = WaterManagement::find($water_management_id);

        echo json_encode($data);
    }

    public function nutrient_management($nutrient_management_id) {
        $data = NutrientManagement::find($nutrient_management_id);

        echo json_encode($data);
    }

    public function roguing($roguing_id) {
        $data = Roguing::where('roguing_id', $roguing_id)
        ->with('offtypes')
        ->first();

        echo json_encode($data);
    }

    public function pest_management($pest_management_id) {
        $data = PestManagement::find($pest_management_id);

        echo json_encode($data);
    }

    public function harvesting($harvesting_id) {
        $data = Harvesting::find($harvesting_id);

        echo json_encode($data);
    }

    public function map($activity_name, $activity_id) {
        switch ($activity_name) {
            case 'Land Preparation':
                $this->land_preparation($activity_id);
                break;
            case 'Seedling Management':
                $this->seedling_management($activity_id);
                break;
            case 'Crop Establishment':
                $this->crop_establishment($activity_id);
                break;
            case 'Water Management':
                $this->water_management($activity_id);
                break;
            case 'Nutrient Management':
                $this->nutrient_management($activity_id);
                break;
            case 'Roguing':
                $this->roguing($activity_id);
                break;
            case 'Pest Management':
                $this->pest_management($activity_id);
                break;
            case 'Harvesting':
                $this->harvesting($activity_id);
                break;
            default:
                echo json_encode(null);
                break;
        }
    }
}
