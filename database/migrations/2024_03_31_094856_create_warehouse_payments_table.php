<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_payments', function (Blueprint $table) {
            $table->id();
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->unsignedBigInteger('warehouse_id');
            $table->integer('cuotas')->default(3);
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
        Schema::dropIfExists('warehouse_payments');
    }
}
