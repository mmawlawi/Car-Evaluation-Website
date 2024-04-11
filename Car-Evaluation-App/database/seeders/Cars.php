<?php

namespace Database\Seeders;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Car;
use App\Models\Drivetype;
use App\Models\FuelType;
use App\Models\State;
use App\Models\Transmission;
use App\Models\UsedOrNew;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class Cars extends Seeder
{
    public function run(): void
    {
        $path = storage_path('Modified Australian Vehicle Prices.csv');
        $file = fopen($path, 'r');
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $rowData = array_combine($header, $row);

            $newcar = new Car();
            
            $brand_id = (Brand::where('name' , $rowData['Brand'])->first());
            $model_id = (CarModel::where('name' , $rowData['Model'])->first());
            $uon_id = (UsedOrNew::where('name' , $rowData['UsedOrNew'])->first());
            $trans_id = (Transmission::where('name' , $rowData['Transmission'])->first());
            $drivetype_id = (Drivetype::where('name' , $rowData['DriveType'])->first());
            $fueltype_id = (FuelType::where('name' , $rowData['FuelType'])->first());
            $bodytype_id = (BodyType::where('name' , $rowData['BodyType'])->first());
            $state_id = (State::where('name' , $rowData['State'])->first());
            
            if ($brand_id) {
                $newcar->brand_id = (int)$brand_id->id;
            }
            
            if ($model_id) {
                $newcar->model_id = (int)$model_id->id;
            }
            
            if ($uon_id) {
                $newcar->used_or_new_id = (int)$uon_id->id;
            }
            
            if ($trans_id) {
                $newcar->transmission_id = (int)$trans_id->id;
            }
            
            if ($drivetype_id) {
                $newcar->drivetype_id = (int)$drivetype_id->id;
            }
            
            if ($fueltype_id) {
                $newcar->fueltype_id = (int)$fueltype_id->id;
            }
            
            if ($bodytype_id) {
                $newcar->bodytype_id = (int)$bodytype_id->id;
            }
            
            if ($state_id) {
                $newcar->state_id = (int)$state_id->id;
            }
            

            $newcar->year = (int)$rowData['Year'];
            $newcar->fuelconsumption =  (float)$rowData['FuelConsumption'];
            $newcar->kilometers =  (int)$rowData['Kilometres'];
            $newcar->cylinders =  (int)$rowData['CylindersinEngine'];
            $newcar->doors =  (int)$rowData['Doors'];
            $newcar->seats =  (int)$rowData['Seats'];
            $newcar->price =  (int)$rowData['Price'];
            $newcar->engine_l =  (float)$rowData['EngineL'];
            
            $newcar->save();
        }
    }
}
