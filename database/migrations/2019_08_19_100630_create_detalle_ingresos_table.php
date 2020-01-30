<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idingreso')->unsigned();
            $table->foreign('idingreso')->references('id')->on('ingresos')->onDelete('cascade');
            $table->bigInteger('idmedicamento')->unsigned();
            $table->foreign('idmedicamento')->references('id')->on('medicamentos');
            $table->integer('cantidad');
            $table->string('lote');
            $table->decimal('precio', 11, 2);
            $table->decimal('costo', 11, 2);
            $table->date('fecha_vencimiento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_ingresos');
    }
}
