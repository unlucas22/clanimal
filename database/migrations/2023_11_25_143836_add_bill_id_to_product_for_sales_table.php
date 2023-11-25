<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillIdToProductForSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_for_sales', function (Blueprint $table) {
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
        Schema::table('product_for_sales', function (Blueprint $table) {
            $table->dropForeign(['bill_id']);
        });
    }
}
