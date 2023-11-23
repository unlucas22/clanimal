<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presales', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('client_id');
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->unsignedBigInteger('sale_id');
            $table->text('description');
            $table->double('price');
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
        Schema::dropIfExists('presales');
    }
}
