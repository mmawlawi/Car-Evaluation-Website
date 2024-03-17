<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CarPredictionController extends Controller
{
    public function predict(Request $request)
    {

        $requestData = $request->all();

        try {
            $response = Http::post('http://127.0.0.1:5000/predict', $requestData);

            if ($response->successful()) {
                $prediction = $response->json()['prediction'];
                return response()->json(['prediction' => $prediction]);
            } else {
                return response()->json(['error' => 'Failed to get prediction from Flask API'], $response->status());
            }
        } catch (\Exception $e) { 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function testPrediction()
    {
        // Test data
        $inputData = [
            "Brand" => "Ssangyong",
            "Year" => 2022,
            "Model" => "Rexton",
            "Car/Suv" => "Sutherland Isuzu Ute",
            "UsedOrNew" => "DEMO",
            "Transmission" => "Automatic",
            "DriveType" => "AWD",
            "FuelType" => "Diesel",
            "FuelConsumption" => 8.7,
            "Kilometres" => 5595,
            "CylindersinEngine" => 4,
            "BodyType" => "SUV",
            "Doors" => 4,
            "Seats" => 7,
            "EngineL" => 2.2,
            "CarAge" => 2,
            "State" => "NSW"
        ];

        try {
            // Make a POST request to the Flask API
            $response = Http::post('http://127.0.0.1:5000/predict', $inputData);

            // Check if the request was successful
            if ($response->successful()) {
                // Get the prediction from the response
                $prediction = $response->json()['prediction'];

                // Display the prediction
                return response()->json(['prediction' => $prediction]);
            } else {
                // Handle the case where the request was not successful
                return response()->json(['error' => 'Failed to get prediction from Flask API'], $response->status());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
