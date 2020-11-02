<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->string('app_version')->nullable();
            $table->string('identifier');
            $table->string('token')->unique();
            $table->enum('type', ['ios', 'android']);
            $table->string('device_model')->nullable();
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('time_zone')->nullable();
            $table->timestamps();
            $table->index(['app_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
