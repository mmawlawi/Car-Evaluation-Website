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
use App\Models\State;

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
        $state = State::all();
        return view('sell_your_car', compact('brands', 'models', 'usedOrNews', 'transmissions', 'driveTypes', 'fuelTypes', 'bodyTypes', 'state'));
    }

    public function submitYourCar(Request $request)
    {
        $validatedData = $request->validate([
            'brand_id' => 'nullable|integer|exists:brand,id',
            'model_id' => 'nullable|integer|exists:model,id',
            'other_brand' => 'required_if:brand_id,other|string|max:255',
            'other_model' => 'required_if:model_id,other|string|max:255',
            'year' => 'required|integer|min:1886|max:' . date('Y'),
            'used_or_new_id' => 'required|integer|exists:used_or_new,id',
            'transmission_id' => 'nullable|integer|exists:transmission,id',
            'drivetype_id' => 'nullable|integer|exists:drivetype,id',
            'fueltype_id' => 'nullable|integer|exists:fueltype,id',
            'bodytype_id' => 'nullable|integer|exists:bodytype,id',
            'doors' => 'nullable|integer|min:1|max:5',
            'seats' => 'nullable|integer|min:1|max:9',
            'engine_l' => 'nullable|numeric',
            'fuelconsumption' => 'nullable|numeric',
            'kilometers' => 'nullable|integer|min:0',
            'state_id' => 'nullable|integer|exists:state,id',
        ]);

        $car = new Car();
        $car->brand_id = $validatedData['brand_id'] ?? null;
        $car->model_id = $validatedData['model_id'] ?? null;
        $car->year = $validatedData['year'];
        $car->used_or_new_id = $validatedData['used_or_new_id'];
        $car->transmission_id = $validatedData['transmission_id'] ?? null;
        $car->drivetype_id = $validatedData['drivetype_id'] ?? null;
        $car->fueltype_id = $validatedData['fueltype_id'] ?? null;
        $car->fuelconsumption = $validatedData['fuelconsumption'] ?? null;
        $car->kilometers = $validatedData['kilometers'] ?? null;
        $car->bodytype_id = $validatedData['bodytype_id'] ?? null;
        $car->doors = $validatedData['doors'] ?? null;
        $car->seats = $validatedData['seats'] ?? null;
        $car->engine_l = $validatedData['engine_l'] ?? null;
        $car->state_id = $validatedData['state_id'] ?? null;

        $car->save(); // This will insert the new car record into the database
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

    public function browse_cars()
    {
        $allCars = Car::with('model.brand')->paginate(24);
        $brands = Brand::select('id', 'name')->distinct()->get();
        $minYear = Car::min('year');
        $maxYear = Car::max('year');
        $minPrice = Car::min('price');
        $maxPrice = Car::max('price');

        return view('browse-cars', compact('allCars', 'brands', 'minYear', 'maxYear', 'minPrice', 'maxPrice'));
    }


    public function getModelsByBrand(Request $request, $brandId)
    {
        $models = CarModel::whereHas('brand', function ($query) use ($brandId) {
            $query->where('brand_id', $brandId);
        })->orderBy('name', 'asc')->get();

        return response()->json($models);
    }

    public function filterCars(Request $request)
    {
        $query = Car::with('model.brand');

        if ($request->filled('make_filter')) {
            $query->whereHas('model.brand', function ($q) use ($request) {
                $q->where('id', $request->make_filter);
            });
        }

        if ($request->filled('model_filter')) {
            $query->whereHas('model', function ($q) use ($request) {
                $q->where('id', $request->model_filter);
            });
        }

        if ($request->filled('year_min') && $request->filled('year_max')) {
            $query->whereBetween('year', [$request->year_min, $request->year_max]);
        }

        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        $allCars = $query->paginate(24);

        // reload other necessary data
        $brands = Brand::select('id', 'name')->distinct()->get();
        $minYear = Car::min('year');
        $maxYear = Car::max('year');
        $minPrice = Car::min('price');
        $maxPrice = Car::max('price');

        return view('browse-cars', compact('allCars', 'brands', 'minYear', 'maxYear', 'minPrice', 'maxPrice'));
    }

    public function showCarDetails(Car $car) {
        
        $brand = $car->brand->name;
        $model = $car->model->name;
        $usedOrNew = $car->usedOrNew->name; 
        $transmission = $car->transmission->name;
        $drive = $car->driveType->name; 
        $fuel = $car->fuelType->name;
        $body = $car->bodyType->name;
        $state = $car->state->name;
        $price = $car->price;
        $year = $car->year;
        $fuelconsumption = $car->fuelconsumption;
        $cylinders = $car->cylinders;
        $kilometers = $car->kilometers;
        $doors = $car->doors;
        $seats = $car->seats;
        $enginesize = $car->engine_l;
        $photolink = CarModel::where('id' , $car->model)->first->photo_link_1;
        $carDetails = compact(
            'brand',
            'model',
            'usedOrNew',
            'transmission',
            'drive',
            'fuel',
            'body',
            'state',
            'price',
            'year',
            'fuelconsumption',
            'cylinders',
            'kilometers',
            'doors',
            'seats',
            'enginesize',
            'photolink'
        );

        return view('car-details' , $carDetails);
    }
}
