<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldoInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_inventarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad_total');
            $table->double('saldototal',250,2);
            $table->double('saldototalventa',250,2);
            $table->string('status',20);
            $table->double('precioanterior',250,2);
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
        Schema::dropIfExists('saldo_inventarios');
    }
}
