<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'model';
    protected $fillable = ['name' , 'brand_id', 'photo_link_1', 'photo_link_2', 'photo_link_3', 'other', 'other_name'];
    public $timestamps = false;

    public function cars()
    {
        return $this->hasMany('App\Models\Car', 'model_id');
    }
}
