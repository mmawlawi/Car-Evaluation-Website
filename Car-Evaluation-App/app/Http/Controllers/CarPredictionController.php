<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\UsedOrNew;
use App\Models\State;
use App\Models\Transmission;
use App\Models\DriveType;
use App\Models\FuelType;
use App\Models\BodyType;

class CarPredictionController extends Controller
{
    public function predict(Request $request)
    {
        // Retrieve the data from the session
        $requestData = $request->session()->get('car_data');
        $predectionData = $this->prepareData($requestData);
        try {
            $response = Http::post('http://127.0.0.1:5000/predict', $predectionData);

            if ($response->successful()) {
                $prediction = $response->json()['prediction'];
                $missing_fields = $response->json()['missing_fields'];

                // Return the view with the prediction data
                return view('price_prediction', ['prediction' => $prediction[0], 'missing_fields' => $missing_fields]);
            } else {
                return response()->json(['error' => 'Failed to get prediction from Flask API'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function prepareData($requestData)
    {
        $currentYear = date('Y');
    
        // Assuming you have methods to get names from IDs or placeholders for these methods
        $brand = isset($requestData['brand_id']) ? Brand::find($requestData['brand_id'])->name : $requestData['other_brand'];
        $model = isset($requestData['model_id']) ? CarModel::find($requestData['model_id'])->name : $requestData['other_model'];
        $usedOrNew = UsedOrNew::find($requestData['used_or_new_id'])->name;
        $state = State::find($requestData['state_id'])->name;
        $transmission = Transmission::find($requestData['transmission_id'])->name;
        $driveType = DriveType::find($requestData['drivetype_id'])->name;
        $fuelType = FuelType::find($requestData['fueltype_id'])->name;
        $bodyType = BodyType::find($requestData['bodytype_id'])->name;
    
        $carAge = $currentYear - $requestData['year'];
    
        return [
            "Brand" => $brand,
            "Year" => (float) $requestData['year'],
            "Model" => $model,
            "UsedOrNew" => $usedOrNew,
            "Transmission" => $transmission,
            "DriveType" => $driveType,
            "FuelType" => $fuelType,
            "FuelConsumption" => (float) $requestData['fuelconsumption'],
            "Kilometres" => (float) $requestData['kilometers'],
            "BodyType" => $bodyType,
            "Doors" => (float) $requestData['doors'],
            "Seats" => (float) $requestData['seats'],
            "EngineL" => (float) $requestData['engine_l'],
            "CarAge" => (float) $carAge,
            "State" => $state
        ];
        //"Car/Suv"
        //"CylindersinEngine"
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
        // Define the path where the image is stored
        $tempImagePath = storage_path('app/public/feature_importance_graph.png');
    
        // Check if the image already exists
        if (!file_exists($tempImagePath)) {
            // If the image does not exist, fetch it from the server
            $response = Http::get('http://127.0.0.1:5000/feature-importance-graph');
    
            if ($response->successful()) {
                // The response should be the raw image data
                $imageData = $response->body();
    
                // Store the image data as a temporary file to serve it to the view
                file_put_contents($tempImagePath, $imageData);
            } else {
                // Handle errors, such as by displaying an error message
                return back()->with('error', 'Failed to fetch the feature importance graph.');
            }
        }
    
        // Whether fetched new or existing, return a view and include the path to the temporary image
        return view('feature-importance', ['imagePath' => 'storage/feature_importance_graph.png']);
    }
    
}
