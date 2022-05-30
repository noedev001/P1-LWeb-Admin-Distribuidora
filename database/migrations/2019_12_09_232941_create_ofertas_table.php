<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->increments('id');
            $table->double('precio_venta_nuevo',250,2);
            $table->integer('cantidad_unidadxcaja');
            $table->integer('unidad_almacen');
            $table->double('caja_almacen',250,2);
            $table->integer('unidad_disponible');
            $table->double('caja_disponible',250,2);
            $table->string('oferta',500)->nullable();
            $table->string('status',20);
            $table->datetime('fecha');
            $table->integer('inventario_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('ofertas');
    }
}
