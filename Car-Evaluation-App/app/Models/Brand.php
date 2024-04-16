<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $fillable = ['id' , 'name', 'other'];
    public $timestamps = false;

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

}
