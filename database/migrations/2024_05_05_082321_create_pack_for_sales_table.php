<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackForSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_for_sales', function (Blueprint $table) {
            $table->id();
            $table->foreign('pack_id')->references('id')->on('packs');
            $table->unsignedBigInteger('pack_id');
            $table->integer('cantidad');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->unsignedBigInteger('bill_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pack_for_sales');
    }
}
