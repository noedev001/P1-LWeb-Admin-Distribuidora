<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asunto',500);
            $table->double('monto',250,2);
            $table->string('foto',500)->nullable()->default('');
            $table->string('fotoweb',500)->nullable()->default('');
            $table->string('estado',50);
            $table->DateTime('fecha');
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
        Schema::dropIfExists('depositos');
    }
}
