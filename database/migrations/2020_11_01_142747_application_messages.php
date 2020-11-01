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
            $table->id();
            $table->text('app_id');
            $table->unsignedInteger('message_id');
            $table->enum('status', ['pending', 'failed', 'success']);
            $table->timestamps();
            $table->index(['message_id', 'status']);
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
