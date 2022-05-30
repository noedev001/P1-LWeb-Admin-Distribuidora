<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('producto_id')->unsigned();
            $table->integer('cantidad_unidad_caja');
            $table->integer('cantidad_unidad_almacen');
            $table->double('cantidad_caja_almacen',250,2);

            $table->integer('cantidad_unidad_almacen_dis');
            $table->double('cantidad_caja_almacen_dis',250,2);

            $table->double('precio_compra_unidad',250,2);
            $table->double('precio_venta_unidad',250,2);
            $table->date('fecha_vencimiento');

            $table->string('status',20);

            $table->string('publicado',10);
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventarios');
    }
}
