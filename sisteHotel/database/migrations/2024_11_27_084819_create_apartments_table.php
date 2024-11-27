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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('image', 255)->nullable();
            $table->integer('max_persons');
            $table->integer('size');
            $table->string('view', 255);
            $table->integer('num_beds');
            $table->decimal('price', 10, 2);
            $table->foreignId('hotel_id')->constrained('hotels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
