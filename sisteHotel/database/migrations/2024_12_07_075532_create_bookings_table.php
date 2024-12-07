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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('email', 200);
            $table->string('phone_number', 200);
            $table->string('check_in', 200);
            $table->string('check_out', 200);
            $table->integer('days');
            $table->integer('price');
            $table->integer('user_id');
            $table->string('room_name', 200);
            $table->string('hotel_name', 200);
            $table->string('status', 200);
            $table->timestamps();
        });
    }
    //Despues de esto, ejecutar el comando php artisan migrate

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
