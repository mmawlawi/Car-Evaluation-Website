<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'car';
    protected $fillable = [
        'id',
        'brand_id',
        'model_id',
        'year',
        'used_or_new_id',
        'transmission_id',
        'drivetype_id',
        'fueltype_id',
        'fuelconsumption',
        'kilometers',
        'cylinders',
        'bodytype_id',
        'doors',
        'seats',
        'price',
        'engine_l',
        'state_id',
    ];

    public $timestamps = false;

    public function model()
    {
        return $this->belongsTo('App\Models\CarModel', 'model_id');
    }
}
