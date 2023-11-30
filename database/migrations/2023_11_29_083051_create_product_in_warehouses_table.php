<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_in_warehouses', function (Blueprint $table) {
            $table->id();

            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->unsignedBigInteger('warehouse_id');

            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('product_id');

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
        Schema::dropIfExists('product_in_warehouses');
    }
}
