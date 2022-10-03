<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrigemTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Origem::truncate();

        DB::table('origem')->insert(['id' => 1, 'nome' => 'Facebook', 'ordem' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('origem')->insert(['id' => 2, 'nome' => 'Instagram', 'ordem' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('origem')->insert(['id' => 3, 'nome' => 'Google', 'ordem' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('origem')->insert(['id' => 4, 'nome' => 'Referral Friend', 'ordem' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('origem')->insert(['id' => 5, 'nome' => 'I saw the store', 'ordem' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('origem')->insert(['id' => 6, 'nome' => 'Others', 'ordem' => '1', 'situacao' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
