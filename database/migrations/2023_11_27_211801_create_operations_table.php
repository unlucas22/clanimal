<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->foreign('cash_register_id')->references('id')->on('cash_registers');
            $table->unsignedBigInteger('cash_register_id')->nullable();
            $table->enum('metodo_de_pago', ['efectivo', 'tarjeta', 'virtual'])->default('efectivo');
            $table->double('amount')->default(1);
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
        Schema::dropIfExists('operations');
    }
}
