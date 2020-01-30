<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array('id'=>'1','usuario'=>'admin','password'=>'$2y$10$SpKQa9GQGSw1Sp4GIdleperzNJbPMP3ZIWpg9dY.ZgvpjJ.G/3c0S', 'condicion'=>'1', 'id_rol'=>1, 'remember_token'=>'drs'));
    }
}
