<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    protected $table = 'fueltype';
    protected $fillable = ['id' , 'name'];
    public $timestamps = false;
}
