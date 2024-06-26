<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\UsedOrNew;
use App\Models\Transmission;
use App\Models\Drivetype;
use App\Models\FuelType;
use App\Models\BodyType;
use App\Models\State;
use App\Models\Visit;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CarController extends Controller
{
    public function sellYourCar()
    {
        $brands = Brand::orderBy('name', 'asc')->get();
        $models = CarModel::orderBy('name', 'asc')->get();
        $usedOrNews = UsedOrNew::all();
        $transmissions = Transmission::all();
        $driveTypes = Drivetype::all();
        $fuelTypes = FuelType::all();
        $bodyTypes = BodyType::all();
        $state = State::all();
        return view('sell_your_car', compact('brands', 'models', 'usedOrNews', 'transmissions', 'driveTypes', 'fuelTypes', 'bodyTypes', 'state'));
    }

    public function submitYourCar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => [
                'required',
                Rule::when($request->input('brand_id') !== 'other', function () {
                    return 'exists:brand,id';
                }, function () {
                    return 'in:other';
                }),
            ],
            'model_id' => [
                'required',
                Rule::when($request->input('model_id') !== 'other', function () {
                    return 'exists:model,id';
                }, function () {
                    return 'in:other';
                }),
            ],
            'state_id' => [
                'nullable',
                Rule::when($request->input('state_id') !== 'other', function () {
                    return 'exists:state,id';
                }, function () {
                    return 'in:other';
                }),
            ],
            'year' => 'required|integer|min:1886|max:' . date('Y'),
            'used_or_new_id' => 'required|integer|exists:used_or_new,id',
            'transmission_id' => 'nullable|integer|exists:transmission,id',
            'drivetype_id' => 'nullable|integer|exists:drivetype,id',
            'fueltype_id' => 'nullable|integer|exists:fueltype,id',
            'bodytype_id' => 'nullable|integer|exists:bodytype,id',
            'doors' => 'nullable|integer|min:1|max:5',
            'seats' => 'nullable|integer|min:1|max:22',
            'cylinders' => 'nullable|integer|min:1|max:12',
            'engine_l' => 'nullable|numeric|min:0|max:8',
            'fuelconsumption' => 'nullable|numeric|min:3|max:30',
            'kilometers' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        // Store the validated data array directly into the session
        $request->session()->put('car_data', $validatedData);

        // Extract names for display
        $displayData = $this->prepareDisplayData($validatedData);
        $request->session()->put('display_car_data', $displayData);

        // Redirect to the predict route, you need to define this route in your web.php
        return redirect()->route('predict');
    }

    private function prepareDisplayData($validatedData)
    {
        $data = [
            'Brand' => $validatedData['brand_id'] !== 'other' ? Brand::find($validatedData['brand_id'])->name : 'Not specified',
            'Model' => $validatedData['model_id'] !== 'other' ? CarModel::find($validatedData['model_id'])->name : 'Not specified',
            'Year' => $validatedData['year'],
            'Used or New' => UsedOrNew::find($validatedData['used_or_new_id'])->name,
            'State' => ($validatedData['state_id'] !== 'other' && isset($validatedData['state_id'])) ? State::find($validatedData['state_id'])->name : 'Not specified',
            'Transmission' => isset($validatedData['transmission_id']) ? Transmission::find($validatedData['transmission_id'])->name : 'Not specified',
            'Drive Type' => isset($validatedData['drivetype_id']) ? DriveType::find($validatedData['drivetype_id'])->name : 'Not specified',
            'Fuel Type' => isset($validatedData['fueltype_id']) ? FuelType::find($validatedData['fueltype_id'])->name : 'Not specified',
            'Body Type' => isset($validatedData['bodytype_id']) ? BodyType::find($validatedData['bodytype_id'])->name : 'Not specified',
            'Doors' => $validatedData['doors'] ?? 'Not specified',
            'Seats' => $validatedData['seats'] ?? 'Not specified',
            'Cylinders' => $validatedData['cylinders'] ?? 'Not specified',
            'Engine Liter' => $validatedData['engine_l'] ?? 'Not specified',
            'Fuel Consumption' => $validatedData['fuelconsumption'] ?? 'Not specified',
            'Kilometers' => $validatedData['kilometers'],
        ];

        // Remove any entries from the data array that are 'Not specified' or 'N/A'
        foreach ($data as $key => $value) {
            if ($value === 'Not specified') {
                unset($data[$key]);
            }
        }

        return $data;
    }

    public function editCar($carId)
    {
        $brands = Brand::orderBy('name', 'asc')->get();
        $models = CarModel::orderBy('name', 'asc')->get();
        $usedOrNews = UsedOrNew::all();
        $transmissions = Transmission::all();
        $driveTypes = DriveType::all();
        $fuelTypes = FuelType::all();
        $bodyTypes = BodyType::all();
        $states = State::all();

        // Retrieve car data from the db
        $car = Car::where('id', $carId)->first()->toArray();
        // If no car is found with the given id, show a 404
        abort_if(!$car, Response::HTTP_NOT_FOUND);
        // Show the edit form view and pass the car object to it
        return view('edit-car', compact('car', 'brands', 'models', 'usedOrNews', 'transmissions', 'driveTypes', 'fuelTypes', 'bodyTypes', 'states'));
    }

    public function updateCar(Request $request, $carId)
    {
        // Find the car by ID
        $car = Car::findOrFail($carId);

        $validator = Validator::make($request->all(), [
            'brand_id' => [
                'required',
                Rule::when($request->input('brand_id') !== 'other', function () {
                    return 'exists:brand,id';
                }, function () {
                    return 'in:other';
                }),
            ],
            'model_id' => [
                'required',
                Rule::when($request->input('model_id') !== 'other', function () {
                    return 'exists:model,id';
                }, function () {
                    return 'in:other';
                }),
            ],
            'state_id' => [
                'nullable',
                Rule::when($request->input('state_id') !== 'other', function () {
                    return 'exists:state,id';
                }, function () {
                    return 'in:other';
                }),
            ],
            'year' => 'required|integer|min:1886|max:' . date('Y'),
            'used_or_new_id' => 'required|integer|exists:used_or_new,id',
            'transmission_id' => 'nullable|integer|exists:transmission,id',
            'drivetype_id' => 'nullable|integer|exists:drivetype,id',
            'fueltype_id' => 'nullable|integer|exists:fueltype,id',
            'bodytype_id' => 'nullable|integer|exists:bodytype,id',
            'doors' => 'nullable|integer|min:1|max:5',
            'seats' => 'nullable|integer|min:1|max:22',
            'cylinders' => 'nullable|integer|min:1|max:12',
            'engine_l' => 'nullable|numeric|min:0|max:8',
            'fuelconsumption' => 'nullable|numeric|min:3|max:30',
            'kilometers' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();

        // Check if the 'brand_id' is 'other', remove it from saving to database
        if (isset($validatedData['brand_id']) && $validatedData['brand_id'] === 'other') {
            unset($validatedData['brand_id']); // Remove 'brand_id' from the array if it is 'other'
        }
        // Check if the 'model_id' is 'other', remove it from saving to database
        if (isset($validatedData['model_id']) && $validatedData['model_id'] === 'other') {
            unset($validatedData['model_id']); // Remove 'model_id' from the array if it is 'other'
        }
        // Check if the 'state_id' is 'other', remove it from saving to database
        if (isset($validatedData['state_id']) && $validatedData['state_id'] === 'other') {
            unset($validatedData['state_id']); // Remove 'state_id' from the array if it is 'other'
        }

        // Update the car with validated data
        $car->update($validatedData);

        // Redirect back to a specific page, such as the car details or car list page with a success message
        return redirect()->route('my-cars')->with('success', 'Car updated successfully!');
    }

    public function deleteCar($carId)
    {
        $car = Car::findOrFail($carId); // Ensure the car exists
        $car->delete(); // Delete the car

        return redirect()->route('my-cars')->with('status', 'Car deleted successfully.');
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

        foreach ($allCars as $car) {
            $car->random_photo_url = $car->model->getRandomPhotoUrl();
        }

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
        foreach ($allCars as $car) {
            $car->random_photo_url = $car->model->getRandomPhotoUrl();
        }

        // reload other necessary data
        $brands = Brand::select('id', 'name')->distinct()->get();
        $minYear = Car::min('year');
        $maxYear = Car::max('year');
        $minPrice = Car::min('price');
        $maxPrice = Car::max('price');

        return view('browse-cars', compact('allCars', 'brands', 'minYear', 'maxYear', 'minPrice', 'maxPrice'));
    }

    public function showCarDetails(Car $car)
    {

        $brand = $car->brand->name ?? 'Not Specified';
        $model = $car->model->name ?? 'Not Specified';
        $usedOrNew = $car->usedOrNew->name ?? 'Not Specified';
        $transmission = $car->transmission->name ?? 'Not Specified';
        $drive = $car->driveType->name ?? 'Not Specified';
        $fuel = $car->fuelType->name ?? 'Not Specified';
        $body = $car->bodyType->name ?? 'Not Specified';
        $state = $car->state->name ?? 'Not Specified';
        $price = $car->price ?? 'Not Specified';
        $year = $car->year ?? 'Not Specified';
        $fuelconsumption = $car->fuelconsumption ?? 'Not Specified';
        $cylinders = $car->cylinders ?? 'Not Specified';
        $kilometers = $car->kilometers ?? 'Not Specified';
        $doors = $car->doors ?? 'Not Specified';
        $seats = $car->seats ?? 'Not Specified';
        $enginesize = $car->engine_l ?? 'Not Specified';
        $carModelInstance = $car->model ?? 'Not Specified';
        $photolink = $carModelInstance->getRandomPhotoUrl();
        $seller = $car->user ?? 'Not Specified';
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

        if ($seller) {
            $carDetails['sellerName'] = $seller->name;
            $carDetails['sellerEmail'] = $seller->email;
            $carDetails['sellerPhone'] = $seller->phone_number;
        } else {
            $carDetails['sellerName'] = 'N/A';
            $carDetails['sellerEmail'] = 'N/A';
            $carDetails['sellerPhone'] = 'N/A';
        }
        if (!Auth::check()) {
            $visit = new Visit();
            $visit->visitor_id = 0;
            $visit->owner_id = $car->user_id;
            $visit->car_id = $car->id;
            $visit->guest_id = rand(10000000, 99999999);
            $alreadyexists = Visit::where('owner_id', $car->user_id)->where('visitor_id', 0)->where('car_id', $car->id)->first();
            if (!$alreadyexists){
                $visit->save();
            }
            else if ((Carbon::now())->diffInMinutes($alreadyexists->created_at) > 60) {
                $visit->save();
            }
            
        }
        else if (Auth::user()->id != $car->user_id) {
            $visit = new Visit();
            $visit->visitor_id = Auth::user()->id;
            $visit->owner_id = $car->user_id;
            $visit->car_id = $car->id;
            $alreadyexists = Visit::where('owner_id', $car->user_id)->where('visitor_id', Auth::user()->id)->where('car_id', $car->id)->first();
            if (!$alreadyexists) {
                $visit->save();
            }
        }
        return view('car-details', $carDetails);
    }
}
