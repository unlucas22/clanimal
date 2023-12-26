<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->double('total_efectivo')->nullable();
            $table->double('total_tarjetas')->nullable();

            $table->enum('status', ['validacion', 'completado', 'observado'])->default('validacion');

            $table->timestamp('reported_at');
            $table->timestamp('validated_at')->nullable();

            $table->text('observation')->nullable();

            $table->string('numero_operacion')->nullable();
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
        Schema::dropIfExists('finances');
    }
}
