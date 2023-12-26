<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserForSpreadsheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_for_spreadsheets', function (Blueprint $table) {
            $table->id();
            $table->foreign('spreadsheet_id')->references('id')->on('spreadsheets');
            $table->unsignedBigInteger('spreadsheet_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->double('descuento')->nullable();
            $table->double('bonificacion')->nullable();
            $table->integer('dias_no_laborados')->nullable();
            $table->integer('minutos_de_tardanzas')->nullable();
            $table->text('observation')->nullable();
            $table->enum('status', ['pendiente', 'validacion', 'completado', 'cancelado'])->default('pendiente');
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
        Schema::dropIfExists('user_for_spreadsheets');
    }
}
