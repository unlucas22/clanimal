<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->unsignedBigInteger('supplier_id');
            $table->enum('status', ['crédito', 'contado', 'pendiente' ,'cancelado'])->default('pendiente');
            $table->enum('key_type', ['factura', 'boleta de compra', 'nota de venta']);
            $table->string('value_type')->nullable();
            $table->double('total')->default(0);
            $table->text('motivo')->nullable();
            $table->text('observation')->nullable();
            $table->timestamp('fecha');
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
        Schema::dropIfExists('warehouses');
    }
}
