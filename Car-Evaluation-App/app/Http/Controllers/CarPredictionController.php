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
                // Get the prediction from the response
                $prediction = $response->json()['prediction'];
                $missing_fields = $response->json()['missing_fields'];

                // Display the prediction
                return response()->json([
                    'prediction' => $prediction,
                    'missing_fields' => $missing_fields
                ]);
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
            "Model" => "Rexton",
            "Car/Suv" => "Sutherland Isuzu Ute",
            "UsedOrNew" => "DEMO",
            "Transmission" => "Automatic",
            "DriveType" => "AWD",
            "FuelType" => "Diesel",
            "FuelConsumption" => 8.7,
            "CylindersinEngine" => 4,
            "BodyType" => "SUV",
            "Doors" => 4,
            "Seats" => 7,
            "EngineL" => 2.2,
            "State" => "NSW"
        ];

        try {
            // Make a POST request to the Flask API
            $response = Http::post('http://127.0.0.1:5000/predict', $inputData);

            // Check if the request was successful
            if ($response->successful()) {
                // Get the prediction from the response
                $prediction = $response->json()['prediction'];
                $missing_fields = $response->json()['missing_fields'];

                // Display the prediction
                return response()->json([
                    'prediction' => $prediction,
                    'missing_fields' => $missing_fields
                ]);
            } else {
                // Handle the case where the request was not successful
                return response()->json(['error' => 'Failed to get prediction from Flask API'], $response->status());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getFeatureImportance()
    {
        $response = Http::get('http://127.0.0.1:5000/feature-importance');
        if ($response->successful()) {
            $featureImportance = $response->json();
            return response()->json(['feature_importance' => $featureImportance]);
        } else {
            return response()->json(['error' => 'Failed to get feature importance from Flask API'], $response->status());
        }
    }

    public function getFeatureImportanceGraph()
    {
        $response = Http::get('http://127.0.0.1:5000/feature-importance-graph');

        if ($response->successful()) {
            // The response should be the raw image data
            $imageData = $response->body();

            // Store the image data as a temporary file to serve it to the view
            $tempImagePath = storage_path('app/public/feature_importance_graph.png');
            file_put_contents($tempImagePath, $imageData);

            // Return a view and include the path to the temporary image
            return view('feature-importance', ['imagePath' => 'storage/feature_importance_graph.png']);
        } else {
            // Handle errors, such as by displaying an error message
            return back()->with('error', 'Failed to fetch the feature importance graph.');
        }
    }
}
