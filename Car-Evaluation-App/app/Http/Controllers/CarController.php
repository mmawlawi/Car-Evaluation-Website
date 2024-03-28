<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarModel;
class CarController extends Controller
{
    public function sellYourCar()
    {
        return view('sell_your_car');
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
