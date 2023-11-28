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
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->double('amount')->default(0);
            $table->enum('status', ['validacion', 'completado', 'rechazado'])->default('validacion');
            $table->timestamp('closed_at')->nullable();
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
