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
        'user_id',
    ];

    public $timestamps = false;


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function usedOrNew()
    {
        return $this->belongsTo(UsedOrNew::class);
    }

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }

    public function driveType()
    {
        return $this->belongsTo(Drivetype::class, 'drivetype_id', 'id');
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fueltype_id', 'id');
    }

    public function bodyType()
    {
        return $this->belongsTo(BodyType::class, 'bodytype_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
