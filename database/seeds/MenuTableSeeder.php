<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Menu::truncate();

        DB::table('menus')->insert(['id' => 1, 'nome' => 'Menu Topo', 'link' => 'menu-topo', 'menu_id' => NULL,  'ordem' => '1', 'exibe' => '2', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('menus')->insert(['id' => 2, 'nome' => 'Como Funciona', 'link' => 'como-funciona', 'menu_id' => '1', 'ordem' => '2', 'exibe' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('menus')->insert(['id' => 3, 'nome' => 'Seja Um Afiliado', 'link' => 'seja-um-afiliado', 'menu_id' => '1', 'ordem' => '3', 'exibe' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('menus')->insert(['id' => 4, 'nome' => 'Fale Conosco', 'link' => 'contato', 'menu_id' => '1', 'ordem' => '4', 'exibe' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
