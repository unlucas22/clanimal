<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductForTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_for_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreign('transfer_id')->references('id')->on('transfers');
            $table->unsignedBigInteger('transfer_id');
            $table->foreign('product_stock_id')->references('id')->on('product_stocks');
            $table->unsignedBigInteger('product_stock_id');
            $table->bigInteger('stock');
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
        Schema::dropIfExists('product_for_transfers');
    }
}
