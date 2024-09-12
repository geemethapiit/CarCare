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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('BranchID'); 
            $table->string('ServiceTypeId');
            $table->unsignedBigInteger('AppointmentID');
            $table->unsignedBigInteger('user_id'); // Add the user_id column
            $table->text('feedback');
            $table->unsignedTinyInteger('rating');
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('BranchID')->references('BranchID')->on('branches')->onDelete('cascade');
            $table->foreign('ServiceTypeId')->references('ServiceTypeId')->on('service')->onDelete('cascade');
            $table->foreign('AppointmentID')->references('AppointmentID')->on('appointments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add a foreign key for the user_id
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
