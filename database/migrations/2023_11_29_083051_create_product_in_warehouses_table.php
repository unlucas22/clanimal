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

            $table->foreign('product_presentation_id')->references('id')->on('product_presentations');
            $table->unsignedBigInteger('product_presentation_id');

            $table->integer('discount')->default(0)->nullable();
            $table->double('precio_venta_sin_igv');
            $table->double('precio_venta_con_igv');
            $table->integer('amount')->default(1);

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
