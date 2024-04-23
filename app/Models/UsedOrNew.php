<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedOrNew extends Model
{
    protected $table = 'used_or_new';
    protected $fillable = ['id' , 'name'];
    public $timestamps = false;
}
