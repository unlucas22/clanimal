<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManpowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manpowers', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            
            $table->string('contact_name_emergency')->nullable();
            $table->string('contact_phone_emergency')->nullable();
            $table->string('contact_type_emergency')->nullable();

            $table->string('cuenta_bancaria');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->unsignedBigInteger('payment_method_id');

            $table->timestamp('fecha_de_contratacion');
            $table->timestamp('fecha_de_cese')->nullable();

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
        Schema::dropIfExists('manpowers');
    }
}
