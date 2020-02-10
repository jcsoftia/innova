<?php

use Illuminate\Database\Seeder;
use App\Models\Presentacion;

class PresentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Presentacion = [
            "SOBRE",
            "UND",
            "PAR",
            "TABLETA",
            "BOLSA",
            "FRASCO",
            "PORCION",
            "FCO",
            "AMPOLLA",
            "SOLUCION",
            "POTE",
            "CAJA",
            "JARABE",
            "POMADA",
            "CAPSULA",
            "SUSPENSIÓN",
            "CASSETTE",
            "TIRA",
            "COMPRIMIDO",
            "ROLLO",
            "BOTELLA",
            "SACHET",
            "METRO",
            "KIT",
            "SPRAY",
            "LAMINA",
            "BARRA",
            "FRASCO AMPOLLA",
            "GOTAS",
            "PAQUETE",
            "SET",
            "GRS",
            "GALON",
            "TUBO",
            "CJA",
            "BOLSA X 50 UN",
            "GRANULADOS",
            "YARDAS",
            "GEL",
            "GRAGEAS",
            "GRAMOS",
            "JUEGO",
            "LIBRA",
            "CARTUCHO",
            "JERINGA",
            "UNGÜENTO",
            "PASTA DENTAL",
            "CREMA",
            "BLISTER",
            "LITRO",
            "KILO",
            
        ];
        for ($i=0; $i < count($Presentacion); $i++) { 
            Presentacion::create([
                'nombre'=>strtoupper($Presentacion[$i]),
                'descripcion'=>strtoupper(" $i"),
                'condicion' => 1
            ]);
        }
    }
}
