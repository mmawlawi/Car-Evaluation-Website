<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyType extends Model
{
    protected $table = 'bodytype';
    protected $fillable = ['id' , 'name'];
    public $timestamps = false;
}
