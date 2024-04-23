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

    public function __construct()
    {
        $this->middleware('auth')->only('myCars');
    }

    public function submitPrice(Request $request)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            // Redirect the user to the login page with a message
            return redirect()->route('login')->with('status', 'You need to log in to add the car to the marketplace.');
        }
        // Retrieve car data from session
        $carData = $request->session()->get('car_data');

        // Ensure there is car data in the session
        if (!$carData) {
            return back()->with('error', 'No car data found. Please submit car details first.');
        }

        // Validate user price input
        $validated = $request->validate([
            'userPrice' => 'required|numeric|min:0' // ensure the price is a number and not negative
        ]);

        // Add user id and price to the car data
        $carData = array_merge($carData, [
            'user_id' => auth()->id(),
            'price' => $validated['userPrice']
        ]);

        // Check if the 'brand_id' is 'other', remove it from saving to database
        if (isset($carData['brand_id']) && $carData['brand_id'] === 'other') {
            unset($carData['brand_id']); // Remove 'brand_id' from the array if it is 'other'
        }
        // Check if the 'model_id' is 'other', remove it from saving to database
        if (isset($carData['model_id']) && $carData['model_id'] === 'other') {
            unset($carData['model_id']); // Remove 'model_id' from the array if it is 'other'
        }
        // Check if the 'state_id' is 'other', remove it from saving to database
        if (isset($carData['state_id']) && $carData['state_id'] === 'other') {
            unset($carData['state_id']); // Remove 'state_id' from the array if it is 'other'
        }

        // Create the car in the database
        $car = new Car($carData);
        $car->save();

        // Clear the car data from the session after saving to database
        $request->session()->forget('car_data');

        // Redirect to a confirmation page or somewhere relevant
        return redirect()->route('my-cars')->with('status', 'Car submitted successfully.');
    }

    public function myCars()
    {
        // Retrieve the authenticated user's ID
        $userId = auth()->id();

        // Query the Car model to get all cars that belong to the current user
        $cars = Car::where('user_id', $userId)->get();

        // Return the view with the cars
        return view('my-cars', compact('cars'));
    }
}
