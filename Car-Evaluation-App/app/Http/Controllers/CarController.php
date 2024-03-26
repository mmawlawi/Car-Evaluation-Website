<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarController extends Controller
{
    public function sellYourCar()
    {
        return view('sell_your_car');
    }

    
}
