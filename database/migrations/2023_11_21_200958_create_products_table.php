<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->foreign('product_category_id')->references('id')->on('product_categories');
            $table->unsignedBigInteger('product_category_id')->nullable();
            
            $table->foreign('product_brand_id')->references('id')->on('product_brands');
            $table->unsignedBigInteger('product_brand_id')->nullable();

            $table->foreign('product_presentation_id')->references('id')->on('product_presentations');
            $table->unsignedBigInteger('product_presentation_id')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->string('name', 200);
            $table->double('precio_compra')->nullable();
            $table->double('precio_venta');
            $table->integer('stock')->default(0);

            $table->integer('amount_presentation')->default(0);

            $table->boolean('active')->default(true);

            $table->string('barcode')->nullable();
            $table->text('palabras_clave')->nullable();
            $table->timestamp('fecha_de_vencimiento')->nullable();
            $table->integer('alerta_stock')->default(1)->nullable();
            $table->string('photo_path', 2048)->nullable();
            
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
        Schema::dropIfExists('products');
    }
}
