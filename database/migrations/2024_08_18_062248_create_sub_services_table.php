<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_services', function (Blueprint $table) {
            $table->string('SubServiceId')->primary(); // Primary key for the `sub_services` table
            $table->string('SubServiceName');
            $table->string('ServiceTypeId'); // Foreign key to the `service` table
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('ServiceTypeId')
                ->references('ServiceTypeId')
                ->on('service')
                ->onDelete('cascade'); // Optional: cascades delete action from `service` to `sub_services`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_services');
    }
}
