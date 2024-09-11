<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('service_feedback', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('ServiceTypeId'); // Foreign key to the `service` table
            $table->string('BranchId'); // Foreign key to the `branches` table
            $table->unsignedTinyInteger('rating')->default(0); // Rating out of 5
            $table->text('description')->nullable(); // Feedback description
            $table->unsignedBigInteger('user_id');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');



        });
    }

    public function down()
    {
        Schema::dropIfExists('service_feedback');
    }
}

