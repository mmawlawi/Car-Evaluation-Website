<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarPredictionController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Controller;

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
Route::get('/home', [CarController::class, 'featured'])->name('home');

// Route::post('/car-prediction', [CarPredictionController::class, 'predict']);
// Route::post('/test-prediction', [CarPredictionController::class, 'testPrediction']);

Route::get('/sell-your-car', [CarController::class, 'sellYourCar'])->name('sell-your-car');
Route::post('/submit-your-car', [CarController::class, 'submitYourCar'])->name('submit-your-car');
Route::get('/cars', [CarController::class, 'browse_cars'])->name('browse-cars');

Route::get('/predict', [CarPredictionController::class, 'predict'])->name('predict');
Route::get('/predict/confidence-interval', [CarPredictionController::class, 'getConfidenceInterval']);
Route::get('/predict/feature-importance', [CarPredictionController::class, 'getFeatureImportance']);
Route::get('/predict/feature-importance-graph', [CarPredictionController::class, 'getFeatureImportanceGraph']);

Route::post('/submit-price', [Controller::class, 'submitPrice'])->name('submit-price');

Route::get('/models/{brandId}',  [CarController::class, 'getModelsByBrand']);
Route::get('/filter-cars', [CarController::class, 'filterCars']);

Route::get('/search', [SearchController::class, 'search'])->name('search-cars');

Route::post('/send-mail', [ContactController::class, 'sendMail'])->name('send-mail');

Route::get('/my-cars', [Controller::class, 'myCars'])->name('my-cars');

Route::get('/edit-car/{carId}', [CarController::class, 'editCar'])->name('edit-car');
Route::put('/update-car/{carId}', [CarController::class, 'updateCar'])->name('update-car');
Route::delete('/delete-car/{carId}',  [CarController::class, 'deleteCar'])->name('delete-car');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/car/{car}' , [CarController::class , 'showCarDetails'])->name('cardetails');