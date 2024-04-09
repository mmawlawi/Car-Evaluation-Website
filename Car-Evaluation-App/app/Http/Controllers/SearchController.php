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

        // First, get brand IDs that match the query
        $brandIds = Brand::where('name', 'LIKE', "%{$query}%")->pluck('id')->toArray();
    
        // Now, adjust the query to fetch cars by model name or brand ID with pagination
        // This example assumes there's a direct relationship or a way to correlate cars with brands through models
        $allCars = Car::whereHas('model', function ($q) use ($query, $brandIds) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhereIn('brand_id', $brandIds);
        })->with('model')->paginate(24); // Adjust the pagination size as needed
    
        // Return the paginated list of cars
        return view('browse-cars', compact('allCars'));
    }
}
