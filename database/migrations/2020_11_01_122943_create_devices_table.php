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
            $table->text('app_id');
            $table->text('app_version');
            $table->text('token');
            $table->enum('type', ['ios', 'android']);
            $table->string('device_model');
            $table->string('language');
            $table->string('country');
            $table->string('time_zone');
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
