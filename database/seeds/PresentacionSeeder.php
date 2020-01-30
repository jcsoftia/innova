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
           " BLISTER ",
           " BOLSA  X 50 UN ",
           " ROLLO ",
           "AMPOLLA",
           "BARRA ",
           "BOLSA",
           "BOTELLA ",
           "CAJA",
           "CAJA ",
           "CAPSULA",
           "CAPSULA ",
           "CAPSULAS",
           "CARTUCHO",
           "CARTUCHO ",
           "CASSETTE ",
           "CJA ",
           "CJA  X 200GRS ",
           "CREMA ",
           "FRASCO",
           "FRASCO ",
           "GALON ",
           "GEL ",
           "GOTAS ",
           "GOTAS  ",
           "GOTAS  OFTALMICAS ",
           "GRAMOS ",
           "JARABE ",
           "JERINGA",
           "JERINGA ",
           "JUEGO ",
           "KIT",
           "KIT ",
           "LAMINA",
           "LIBRA",
           "METRO",
           "PAQUETE",
           "PAQUETE ",
           "PAR ",
           "PARES ",
           "POMADA",
           "PORCION",
           "PORCION ",
           "POTE",
           "POTE ",
           "ROLLO ",
           "SACHET",
           "SACHET ",
           "SET",
           "SOBRE",
           "SOBRE ",
           "SOBRES ",
           "SOLUCION ",
           "SPRAY ",
           "SUSPENSIÓN ",
           "TABLETA",
           "TABLETA ",
           "TABLETA COMPRIMIDO",
           "TABLETAS",
           "TABLETAS ",
           "TAPER ",
           "TIRA ",
           "TUBO ",
           "TUBOS ",
           "UND",
           "UND ",
           "UND  ",
           "UNGÜENTO ",
           "-"
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
