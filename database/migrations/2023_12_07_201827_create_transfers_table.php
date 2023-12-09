<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('company_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['completado', 'en proceso', 'cancelado']);
            $table->timestamp('fecha_envio');
            $table->timestamp('fecha_recepcion')->nullable();
            $table->text('motivo')->nullable();
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
        Schema::dropIfExists('transfers');
    }
}
