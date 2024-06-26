<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('client_id');
            $table->boolean('active')->default(false);
            $table->enum('metodo_de_pago', ['efectivo', 'tarjeta', 'virtual', 'credito'])->default('efectivo');
            $table->foreign('referente_id')->references('id')->on('users');
            $table->unsignedBigInteger('referente_id')->nullable();
            $table->double('total');
            $table->double('igv');
            $table->string('razon_social')->nullable();
            $table->string('ruc')->nullable();
            $table->string('enlace')->nullable();
            $table->boolean('factura')->default(false);
            $table->enum('status', ['en proceso', 'completado', 'cancelado'])->default('en proceso');
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
        Schema::dropIfExists('bills');
    }
}
