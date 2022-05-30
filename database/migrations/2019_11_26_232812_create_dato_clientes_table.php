<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dato_clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direccion',120)->nullable();
            $table->integer('telefono')->nullable();
            $table->string('ci',12)->nullable();
            $table->string('foto',250)->nullable();
            $table->integer('cliente_id')->unsigned();
            $table->integer('user_id')->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dato_clientes');
    }
}
