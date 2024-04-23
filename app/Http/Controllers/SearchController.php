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

        
        $brandIds = Brand::where('name', 'LIKE', "%{$query}%")->pluck('id')->toArray();
    
        $allCars= Car::whereHas('model', function ($q) use ($query, $brandIds) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhereIn('brand_id', $brandIds);
        })->with('model')->paginate(24); 
        foreach ($allCars as $car) {
            $car->random_photo_url = $car->model->getRandomPhotoUrl();
        }
        $minYear = 1978;
        $maxYear = date("Y");
        $minPrice = 100;
        $maxPrice = 100000;
        $brands = Brand::select('id', 'name')->distinct()->get();
        return view('browse-cars', compact('brands' , 'allCars' , 'minYear' , 'maxYear' , 'minPrice' , 'maxPrice'));
    }
}
