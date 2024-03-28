<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transmission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('used_or_new', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        
        Schema::create('brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('model', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('brand_id');
            $table->string('photo_link_1')->nullable();
            $table->string('photo_link_2')->nullable();
            $table->string('photo_link_3')->nullable();
        });

        Schema::create('bodytype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('fueltype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('drivetype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('state', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
    }
};
