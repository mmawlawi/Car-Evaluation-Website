<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('model', function (Blueprint $table) {
            $table->boolean('other')->default(0);
        });

        Schema::table('brand', function (Blueprint $table) {
            $table->boolean('other')->default(0);
        });
    }

    public function down()
    {
        Schema::table('model', function (Blueprint $table) {
            $table->dropColumn('other');
        });

        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn('other');
        });
    }
};

