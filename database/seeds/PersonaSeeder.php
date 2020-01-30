<?php

use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    private function getFullname()
	{
		$apellidos = ['TORRES','LOPEZ','PEREZ','CHAVEZ','VASQUEZ','VALENCIA','RAMIREZ','MENDOZA','SUAREZ'];
		$nombres = ['RUTH','JUAN CARLOS','EDGAR','VICTORIA','CHLOET','MARIO','MICHAEL','FERNANDA','ANDREA'];
		$n = rand(1,2);
		$name = "";
		switch($n){
			case 1:{
				$name = $nombres[rand(0,8)];
			};break;
			case 2:{
				$name = $nombres[rand(0,8)]." ".$nombres[rand(0,8)];
			};break;
		}
		$fullname = $apellidos[rand(0,8)].' '.$apellidos[rand(0,8)].' '.$name;
		return $fullname;
	}
    public function run()
    {
        DB::table('personas')->insert([
            'nombre'=>$this->getFullname(),
            'tipo_documento'=>'DNI',
            'num_documento'=>mt_rand(10000000, 99999999),
            'direccion'=>str_random(10),
            'telefono'=>mt_rand(900000000, 999999999),
            'email'=>"usuario@gmail.com",
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
