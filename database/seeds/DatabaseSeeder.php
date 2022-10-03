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
        $this->call([
            ModulosTableSeeder::class,
            UsuariosTableSeeder::class,
            OrigemTableSeeder::class,
            LangsTableSeeder::class,
            ConfigTableSeeder::class,
            MenuTableSeeder::class
        ]);
    }
}
