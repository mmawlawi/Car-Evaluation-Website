<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Brand;
use App\Models\CarModel;

class Attributes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('data_labels.json');
        $json = File::get($path);
        $data = json_decode($json, true);
        
        foreach ($data['Brand-Model'] as $brandName => $models) {
            // Create the brand
            $brand = new Brand();
            $brand->name = $brandName;
            $brand->save();

            // Iterate over the models for this brand
            foreach ($models as $modelName) {
                // Create the car model
                $carModel = new CarModel();
                $carModel->name = $modelName;
                $carModel->brand_id = $brand->id;
                $carModel->save();
            }
        }
    }
}
