<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreign('product_presentation_id')->references('id')->on('product_presentations');
            $table->unsignedBigInteger('product_presentation_id');
            $table->integer('amount')->default(1);
            $table->integer('discount')->nullable();
            $table->double('precio_venta_sin_igv');
            $table->double('precio_venta_con_igv');
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
        Schema::dropIfExists('product_details');
    }
}
