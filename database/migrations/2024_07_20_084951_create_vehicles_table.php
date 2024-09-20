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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->string('vehicle_number')->primary(); 
            $table->string('vehicle_image')->nullable(); 
            $table->string('model');
            $table->year('year');
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->string('vehicle_book_image')->nullable(); 
            $table->string('status')->default('pending');
            $table->timestamps();

            // Set up foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
