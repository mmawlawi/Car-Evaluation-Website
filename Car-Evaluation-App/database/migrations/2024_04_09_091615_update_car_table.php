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
        Schema::table('car', function (Blueprint $table) {
            $table->integer('used_or_new_id')->change();
            $table->integer('transmission_id')->nullable()->change();
            $table->integer('drivetype_id')->nullable()->change();
            $table->integer('fueltype_id')->nullable()->change();
            $table->integer('bodytype_id')->nullable()->change();
            $table->integer('doors')->nullable()->change();
            $table->integer('seats')->nullable()->change();
            $table->float('engine_l')->nullable()->change();
            $table->float('fuelconsumption')->nullable()->change();
            $table->integer('kilometers')->nullable()->change();
            $table->integer('cylinders')->nullable()->change();
            $table->integer('state_id')->nullable()->change();
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
