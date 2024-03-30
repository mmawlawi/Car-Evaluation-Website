<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\UsedOrNew;
use App\Models\Transmission;
use App\Models\DriveType;
use App\Models\FuelType;
use App\Models\BodyType;

class CarController extends Controller
{
    public function sellYourCar()
    {
        $brands = Brand::orderBy('name', 'asc')->get();
        $models = CarModel::orderBy('name', 'asc')->get();
        $usedOrNews = UsedOrNew::all();
        $transmissions = Transmission::all();
        $driveTypes = DriveType::all();
        $fuelTypes = FuelType::all();
        $bodyTypes = BodyType::all();
        return view('sell_your_car', compact('brands', 'models', 'usedOrNews', 'transmissions', 'driveTypes', 'fuelTypes', 'bodyTypes'));
    }

    public function submitYourCar(Request $request)
    {
        $validatedData = $request->validate([
            'brand_id' => 'nullable|integer|exists:brands,id', // This can be nullable if 'other' is chosen
            'model_id' => 'nullable|integer|exists:models,id', // This can be nullable if 'other' is chosen
            'other_brand' => 'required_if:brand_id,other|string|max:255',
            'other_model' => 'required_if:model_id,other|string|max:255',
            'year' => 'required|integer|min:1886|max:' . date('Y'),
            'used_or_new_id' => 'required|integer|exists:used_or_news,id',
            'transmission_id' => 'required|integer|exists:transmissions,id',
            'drivetype_id' => 'required|integer|exists:drivetypes,id',
            'fueltype_id' => 'required|integer|exists:fueltypes,id',
            'bodytype_id' => 'required|integer|exists:bodytypes,id',
            'doors' => 'required|integer|min:1|max:5',
            'seats' => 'required|integer|min:1|max:9',
            'engine_l' => 'required|numeric',
            'fuelconsumption' => 'required|numeric',
            'kilometers' => 'required|integer|min:0',
        ]);
    }


    public function featured()
    {
        $cars = Car::inRandomOrder()->limit(6)->get();

        foreach ($cars as $car) {
            $carModel = $car->model;

            if ($carModel && ($carModel->photo_link_1 && $carModel->photo_link_2 && $carModel->photo_link_3)) {
                $randomIndex = mt_rand(1, 3);
                $randomPhoto = optional($carModel)->{"photo_link_$randomIndex"};
                $car->random_photo = $randomPhoto;
            }
        }

        return view('home', compact('cars'));
    }
}
