<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LangsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Lang::truncate();

        DB::table('langs')->insert(['id' => 1, 'nome' => 'Português', 'sigla' => 'pt-br', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('langs')->insert(['id' => 2, 'nome' => 'English', 'sigla' => 'en', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('langs')->insert(['id' => 3, 'nome' => 'Espanhol', 'sigla' => 'es', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }

}
