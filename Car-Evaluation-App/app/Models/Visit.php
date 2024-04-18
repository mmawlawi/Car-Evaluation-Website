<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visit';
    protected $fillable = ['id' , 'visitor_id' , 'owner_id' , 'car_id' , 'guest_id' , 'created_at'];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id' , 'id');
    }

    public function visitor()
    {
        return $this->belongsTo(User::class, 'visitor_id' , 'id');
    }
}
