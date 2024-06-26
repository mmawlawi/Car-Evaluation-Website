<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'model';
    protected $fillable = ['name' , 'brand_id', 'photo_link_1', 'photo_link_2', 'photo_link_3'];
    public $timestamps = false;

    public function cars()
    {
        return $this->hasMany('App\Models\Car', 'model_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }
    public function getRandomPhotoUrl()
    {
        $photos = array_filter([$this->photo_link_1, $this->photo_link_2, $this->photo_link_3]);
        if (empty($photos)) {
            return null; 
        }
        return $photos[array_rand($photos)];
    }
}
