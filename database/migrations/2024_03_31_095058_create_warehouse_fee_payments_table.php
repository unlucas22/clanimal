<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseFeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreign('warehouse_payment_id')->references('id')->on('warehouse_payments');
            $table->unsignedBigInteger('warehouse_payment_id');
            $table->date('fecha');
            $table->double('cuota');
            $table->enum('status', ['completado', 'en espera'])->default('en espera');
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
        Schema::dropIfExists('warehouse_fee_payments');
    }
}
