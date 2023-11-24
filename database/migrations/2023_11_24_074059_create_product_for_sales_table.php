<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductForSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_for_sales', function (Blueprint $table) {
            $table->id();
            $table->foreign('product_detail_id')->references('id')->on('product_details');
            $table->unsignedBigInteger('product_detail_id');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->integer('cantidad');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_for_sales');
    }
}
