<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('clientName')->nullable();
            $table->string('email')->nullable();
            $table->string('phoneNo')->nullable();
            $table->text('location')->nullable();
            $table->string('reserveCode')->nullable();
            $table->string('reserveState')->nullable();
            $table->string('clientIp')->nullable();
            $table->date('eventDate')->nullable();
            $table->time('startTime')->nullable();
            $table->time('endTime')->nullable();
            $table->string('eventType')->nullable();
            $table->integer('numbOfPeople')->nullable();
            $table->text('eventInfo')->nullable();
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
        Schema::dropIfExists('reservations');
    }
};
