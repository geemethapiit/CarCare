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
            $table->id(); // Primary key for the feedback table
            $table->string('ServiceTypeId'); // Foreign key to `service` table
            $table->string('BranchID'); // Foreign key to `branches` table
            $table->unsignedTinyInteger('rating')->default(0); // Rating out of 5
            $table->text('description')->nullable(); // Feedback description
            $table->unsignedBigInteger('user_id'); // Foreign key to `users` table
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('ServiceTypeId')->references('ServiceTypeId')->on('service')->onDelete('cascade');
            $table->foreign('BranchID')->references('BranchID')->on('branches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
