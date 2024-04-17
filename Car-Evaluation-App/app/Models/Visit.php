<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visit';
    protected $fillable = ['id' , 'visitor_id' , 'owner_id' , 'car_id' , 'guest_id' , 'created_at'];
}
