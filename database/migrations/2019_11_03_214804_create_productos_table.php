<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('marca');
            $table->string('modelo')->nullable()->default('');;
            $table->string('medida')->nullable()->default('');;
            $table->string('serie')->nullable()->default('');;
            $table->string('descripcion')->nullable()->default('');;
            $table->string('nota')->nullable()->default('');;
            $table->string('avatar',500)->nullable()->default('');
            $table->string('avatarurl',500)->nullable()->default('');
            $table->integer('categoria_id')->unsigned();
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
