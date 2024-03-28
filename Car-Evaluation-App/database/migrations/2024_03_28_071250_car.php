<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->integer('model_id');
            $table->year('year');
            $table->integer('used_or_new_id');
            $table->integer('transmission_id');
            $table->integer('drivetype_id');
            $table->integer('fueltype_id');
            $table->integer('fuelconsumption');
            $table->integer('kilometers');
            $table->integer('cylinders');
            $table->integer('bodytype_id');
            $table->integer('doors');
            $table->integer('seats');
            $table->integer('price');
            $table->integer('engine_l');
            $table->integer('state_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
