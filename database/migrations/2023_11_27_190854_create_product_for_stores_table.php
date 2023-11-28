<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductForStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_for_stores', function (Blueprint $table) {
            $table->id();
            $table->string('stock');
            $table->timestamp('fecha');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('product_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('company_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('product_for_stores');
    }
}
