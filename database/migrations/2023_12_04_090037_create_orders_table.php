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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('clientName')->nullable();
            $table->string('email')->nullable();
            $table->string('phoneNo')->nullable();
            $table->text('location')->nullable();
            $table->string('orderCode')->nullable();
            $table->text('foodItems')->nullable()->comment('foodId,quantity,price,subTotal');
            $table->string('orderStage')->nullable();
            $table->string('clientIp')->nullable();
            $table->string('orderHandler')->nullable();
            $table->string('totalAmount')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
