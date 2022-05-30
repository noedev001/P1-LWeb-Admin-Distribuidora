<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('forma_pago',40);
            $table->datetime('fecha_pago');
            $table->double('monto',250,2);
            $table->string('foto_pago',200)->nullable()->default('');
            $table->string('foto_url',200)->nullable()->default('');
            $table->datetime('fecha_entrega');
            $table->datetime('fecha_deposito')->nullable();
            $table->string('status',40);
            $table->integer('cliente_id')->unsigned();
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
        Schema::dropIfExists('pagos');
    }
}
