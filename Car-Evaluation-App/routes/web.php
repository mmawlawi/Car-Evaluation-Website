<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarPredictionController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SearchController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CarController::class, 'featured'])->name('home');


// Route::post('/car-prediction', [CarPredictionController::class, 'predict']);

// Route::post('/test-prediction', [CarPredictionController::class, 'testPrediction']);

Route::get('/feature-importance', [CarPredictionController::class, 'getFeatureImportance']);
Route::get('/feature-importance-graph', [CarPredictionController::class, 'getFeatureImportanceGraph']);

Route::get('/sell-your-car', [CarController::class, 'sellYourCar'])->name('sell-your-car');
Route::post('/submit-your-car', [CarController::class, 'submitYourCar'])->name('submit-your-car');
Route::get('/cars', [CarController::class, 'browse_cars'])->name('browse-cars');
Route::get('/predict', [CarPredictionController::class, 'predict'])->name('predict');

Route::get('/search', [SearchController::class, 'search'])->name('search-cars');