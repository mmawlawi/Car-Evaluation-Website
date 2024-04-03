<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarModel;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $brandIds = Brand::where('name', 'LIKE', "%{$query}%")->pluck('id');

        $modelIds = CarModel::where(function ($q) use ($query, $brandIds) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhereIn('brand_id', $brandIds);
        })->pluck('id');

       
        $cars = Car::with('model')->whereIn('model_id', $modelIds)->take(50)->get();
        $carsByBrand = Car::with('model')->whereIn('brand_id', $brandIds)->take(50)->get();

        // Merge the two collections if needed. Ensure no duplicate cars are added.
        $allCars = $cars->merge($carsByBrand)->unique('id');

        // Assuming you want to uniquely return cars either by brand or model without duplicates
        // $allCars = $cars->concat($carsByBrand)->unique('id')->take(100);
        //dd($allCars);
        // Return results - adapt this part to your application's response requirement (view, JSON, etc.)
        return view('browse-cars', compact('allCars'));
    }
}
