<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function submitPrice(Request $request)
    {
        // Check if the user is logged in
        if (!auth()->check()) {
            // Redirect to login with a message
            return redirect()->route('login')->with('status', 'Please log in to submit your price.');
        }
    
        // Retrieve car data from session
        $carData = $request->session()->get('car_data');
    
        // Ensure there is car data in the session
        if (!$carData) {
            return back()->with('error', 'No car data found. Please submit car details first.');
        }
    
        // Add user id to the car data
        $carData['user_id'] = auth()->id();
    
        // Add the price submitted by the user to the car data
        $carData['price'] = $request->input('userPrice');
    
        // Create the car in the database
        $car = new Car($carData);
        $car->save();
    
        // Redirect to a confirmation page or somewhere relevant
        return redirect()->route('home')->with('status', 'Car submitted successfully.');
    }
    
}
