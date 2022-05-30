<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradaInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_inventarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad_unidad');
            $table->double('cantidad_caja',250,2);
            $table->double('precio_compra_unidad',250,2);
            $table->double('precio_venta_unidad',250,2);
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
        Schema::dropIfExists('entrada_inventarios');
    }
}
