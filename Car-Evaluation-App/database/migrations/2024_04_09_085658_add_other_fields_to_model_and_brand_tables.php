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
            $table->string('other_name')->nullable();
        });

        Schema::table('brand', function (Blueprint $table) {
            $table->boolean('other')->default(0);
            $table->string('other_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('model', function (Blueprint $table) {
            $table->dropColumn('other');
            $table->dropColumn('other_name');
        });

        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn('other');
            $table->dropColumn('other_name');
        });
    }
};

