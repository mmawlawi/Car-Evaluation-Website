<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drivetype extends Model
{
    protected $table = 'drivetype';
    protected $fillable = ['id' , 'name'];
    public $timestamps = false;
}
