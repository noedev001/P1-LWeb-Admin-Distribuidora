<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad_unidad')->nullable();
            $table->integer('cantidad_caja')->nullable();
            $table->double('precio_unidad',250,2)->nullable();
            $table->double('precio_total',250,2)->nullable();
            $table->datetime('fecha_entrega');
            $table->string('estatus');
            $table->datetime('fecha_compra');
            $table->integer('oferta')->nullable();
            $table->integer('cliente_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
