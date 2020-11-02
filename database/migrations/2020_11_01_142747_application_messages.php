<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApplicationMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_id')->index();
            $table->unsignedBigInteger('message_id')->index();
            $table->enum('status', ['pending', 'failed', 'success'])->index();
            $table->timestamps();
            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_messages');
    }
}
