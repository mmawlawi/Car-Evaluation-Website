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
        $requestData = $request->session()->get('car_data');
        $predictionData = $this->prepareData($requestData);
        try {
            $response = Http::post('http://127.0.0.1:5000/predict', $predictionData);

            if ($response->successful()) {
                $prediction = $response->json()['prediction'];
                $missing_fields = $response->json()['missing_fields'];
                $featureImportance = $this->getFeatureImportance();
                $confidence = $this->calculateConfidenceInterval($predictionData, $featureImportance);
                return view('price_prediction', [
                    'prediction' => $prediction[0],
                    'missing_fields' => $missing_fields,
                    'confidenceInterval' => $confidence
                ]);
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
        $data = [];

        if (isset($requestData['brand_id'])) {
            $brand = Brand::find($requestData['brand_id']);
            if ($brand) {
                $data["Brand"] = $brand->name;
            }
        } elseif (!empty($requestData['other_brand'])) {
            $data["Brand"] = $requestData['other_brand'];
        }

        if (isset($requestData['model_id'])) {
            $model = CarModel::find($requestData['model_id']);
            if ($model) {
                $data["Model"] = $model->name;
            }
        } elseif (!empty($requestData['other_model'])) {
            $data["Model"] = $requestData['other_model'];
        }

        if (isset($requestData['used_or_new_id'])) {
            $usedOrNew = UsedOrNew::find($requestData['used_or_new_id']);
            if ($usedOrNew) {
                $data["UsedOrNew"] = $usedOrNew->name;
            }
        }

        if (isset($requestData['state_id'])) {
            $state = State::find($requestData['state_id']);
            if ($state) {
                $data["State"] = $state->name;
            }
        }

        if (isset($requestData['transmission_id'])) {
            $transmission = Transmission::find($requestData['transmission_id']);
            if ($transmission) {
                $data["Transmission"] = $transmission->name;
            }
        }

        if (isset($requestData['drivetype_id'])) {
            $driveType = DriveType::find($requestData['drivetype_id']);
            if ($driveType) {
                $data["DriveType"] = $driveType->name;
            }
        }

        if (isset($requestData['fueltype_id'])) {
            $fuelType = FuelType::find($requestData['fueltype_id']);
            if ($fuelType) {
                $data["FuelType"] = $fuelType->name;
            }
        }

        if (isset($requestData['bodytype_id'])) {
            $bodyType = BodyType::find($requestData['bodytype_id']);
            if ($bodyType) {
                $data["BodyType"] = $bodyType->name;
            }
        }

        // Handling numerical values
        if (!empty($requestData['year'])) {
            $data["Year"] = (float) $requestData['year'];
            $data["CarAge"] = (float) ($currentYear - $requestData['year']);
        }

        if (isset($requestData['fuelconsumption'])) {
            $data["FuelConsumption"] = (float) $requestData['fuelconsumption'];
        }

        if (isset($requestData['cylinders'])) {
            $data["CylindersinEngine"] = (float) $requestData['cylinders'];
        }

        if (isset($requestData['kilometers'])) {
            $data["Kilometres"] = (float) $requestData['kilometers'];
        }

        if (isset($requestData['doors'])) {
            $data["Doors"] = (float) $requestData['doors'];
        }

        if (isset($requestData['seats'])) {
            $data["Seats"] = (float) $requestData['seats'];
        }

        if (isset($requestData['engine_l'])) {
            $data["EngineL"] = (float) $requestData['engine_l'];
        }

        return $data;
    }

    public function getFeatureImportance()
    {
        $response = Http::get('http://127.0.0.1:5000/feature-importance');
        if ($response->successful()) {
            return $response->json();
        } else {
            return [];
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

    private function calculateConfidenceInterval($predictionData, $featureImportance)
    {
        $baseAccuracy = 0.85; // 85% base accuracy
        $totalImportance = array_sum(array_values($featureImportance));
        $providedImportance = 0;

        // Calculate the proportion of provided importance
        foreach ($predictionData as $key => $value) {
            if (!empty($value) && array_key_exists($key, $featureImportance)) {
                $providedImportance += $featureImportance[$key];
            }
        }

        $confidenceScore = $providedImportance / $totalImportance;
        $adjustedAccuracy = $baseAccuracy * $confidenceScore;

        return [
            'lower' => max(0, $adjustedAccuracy - 0.1),  // assuming a ±10% range for simplicity
            'upper' => min(1, $adjustedAccuracy + 0.1)
        ];
    }
}
