<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            // $table->timestamps();
        });
        DB::table('roles')->insert(array('id'=>'1', 'nombre'=>'ADMINISTRADOR', 'descripcion'=>'LOS ADMINISTARDORES'));
        DB::table('roles')->insert(array('id'=>'2', 'nombre'=>'VENDEDOR', 'descripcion'=>'LOS VENDEDORES'));
        DB::table('roles')->insert(array('id'=>'3', 'nombre'=>'ALAMACENERO', 'descripcion'=>'LOS DE ALMACEN'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rols');
    }
}
