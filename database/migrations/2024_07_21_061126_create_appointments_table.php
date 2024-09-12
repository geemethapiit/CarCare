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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('AppointmentID');
            $table->date('date');
            $table->time('time');
            $table->string('status');
            $table->string('ServiceTypeId');
            $table->string('BranchID');
            $table->string('vehicle_number');
            $table->unsignedBigInteger('user_id'); // Foreign key column
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('vehicle_number')->references('Vehicle_Number')->on('vehicles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ServiceTypeId')->references('ServiceTypeId')->on('service')->onDelete('cascade');
            $table->foreign('BranchID')->references('BranchID')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
