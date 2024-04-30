<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductForPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_for_packs', function (Blueprint $table) {
            $table->id();
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('product_id');
            $table->foreign('pack_id')->references('id')->on('packs');
            $table->unsignedBigInteger('pack_id');
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
        Schema::dropIfExists('product_for_packs');
    }
}
