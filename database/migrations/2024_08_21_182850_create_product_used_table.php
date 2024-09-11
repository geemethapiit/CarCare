<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUsedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_used', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key to `products` table
            $table->foreignId('service_record_id')->constrained('service_records')->onDelete('cascade'); // Foreign key to `service_records` table
            $table->integer('quantity')->nullable(); // Optional: Quantity of the product used
            $table->timestamps(); // Timestamps for record creation and update
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_service_records');
    }
}

