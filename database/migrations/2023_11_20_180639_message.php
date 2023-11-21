<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Message extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {

            $table->id();
            $table->unsignedInteger('sender_id');
            $table->unsignedInteger('receiver_id');
            $table->unsignedBigInteger('conversation_id');
            $table->boolean('read')->default(0)->nullable();
            $table->text('body')->nullable();
            $table->string('type')->nullable();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->foreign('conversation_id')->references('id')->on('conversations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
