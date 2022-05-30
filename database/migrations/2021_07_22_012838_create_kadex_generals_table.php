<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKadexGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kadex_generals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventario_id')->unsigned();
            $table->integer('cantidad_unidad_entrada')->nullable();
            $table->double('cantidad_caja_entrada',250,2)->nullable();
            $table->double('precio_compra_unidad_entrada',250,2)->nullable();
            $table->double('precio_venta_unidad_entrada',250,2)->nullable();

            $table->integer('cantidad_unidad_salida')->nullable();
            $table->double('cantidad_caja_salida',250,2)->nullable();
            $table->double('precio_venta_unidad_salida',250,2)->nullable();
            $table->string('detalle_salida',250)->nullable();
            $table->string('status_salida',20)->nullable();


            $table->integer('cantidad_total');
            $table->double('saldototal',250,2);
            $table->double('saldototalventa',250,2);
            $table->string('status',20);
            $table->double('precioanterior',250,2);

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
        Schema::dropIfExists('kadex_generals');
    }
}
