<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('medicamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->double('precio_venta', 3)->nullable();
            $table->double('precio_compra', 3)->default(0)->nullable();
            $table->double('stock', 3)->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion');
            $table->bigInteger('producto_id')->unsigned();
            $table->bigInteger('presentacion_id')->unsigned();
            $table->bigInteger('concentracion_id')->unsigned();
            $table->bigInteger('laboratorio_id')->unsigned();
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('presentacion_id')->references('id')->on('presentaciones');
            $table->foreign('concentracion_id')->references('id')->on('concentraciones');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicamentos');
    }
}
