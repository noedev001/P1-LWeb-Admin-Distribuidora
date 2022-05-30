<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_pedido', function (Blueprint $table) {
          $table->increments('id');
          $table->date('fecha_pedido');
          $table->double('precio_venta_unidad',250,2);
          $table->double('precio_total_pedido',250,2);
          $table->integer('cantidad_unidad');
          $table->double('cantidad_caja',250,2);
          $table->integer('pedido_id')->unsigned();
          $table->integer('inventario_id')->unsigned();
          $table->timestamps();

          $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
          $table->foreign('inventario_id')->references('id')->on('inventarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventario_pedido');
    }
}
