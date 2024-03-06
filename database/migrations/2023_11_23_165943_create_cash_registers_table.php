<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/* SIN USAR */
class CreateCashRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->foreign('casher_id')->references('id')->on('cashers');
            $table->unsignedBigInteger('casher_id');
            $table->double('en_caja')->default(0);
            $table->double('total_efectivo')->nullable();
            $table->double('total_tarjeta')->nullable();
            $table->double('total_virtual')->nullable();
            $table->double('total_credito')->nullable();
            $table->enum('status', ['en proceso', 'validacion', 'completado', 'rechazado'])->default('validacion');
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('validated_at')->nullable();
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
        Schema::dropIfExists('cash_registers');
    }
}
