<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('client_id');
            $table->boolean('active')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->string('razon_social')->nullable();
            $table->enum('metodo_de_pago', ['efectivo', 'tarjeta', 'virtual', 'credito'])->default('efectivo');
            $table->string('tarjeta')->nullable();
            $table->string('ruc')->nullable();
            $table->boolean('factura')->default(false);
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
        Schema::dropIfExists('sales');
    }
}
