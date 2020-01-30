<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PersonaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ConcentracionSeeder::class);
        $this->call(LaboratorioSeeder::class);
        $this->call(PresentacionSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(MedicamentoSeeder::class);
            //$this->call(IngresoSeeder::class);
        
    }
}
