<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key for the products table
            $table->string('product_name');
            $table->decimal('price', 8, 2); // Example price column

            // Foreign key that references `ServiceTypeId` in the `service` table
            $table->string('ServiceTypeId');
            $table->foreign('ServiceTypeId')->references('ServiceTypeId')->on('service')->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
}
