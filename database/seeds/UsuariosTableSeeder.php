<?php

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        \App\Models\Usuario::truncate();

        $modulos = \App\Models\Modulo::all();

        $id = DB::table('usuarios')->insertGetId([
            'nome' => 'Diego Tauchert',
            'login' => 'dtauchert',
            'email' => 'diego.tauchert@gmail.com',
            'password' => password_hash('vagalume', PASSWORD_DEFAULT),
            //            'senha' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'tipo' => '1',
            'situacao' => '1',
        ]);

        foreach ($modulos as $modulo) {
            DB::table('permissoes')->insert([
                'usuario_id' => $id,
                'modulo_id' => $modulo->id,
                'created_at' => now()
            ]);
        }

        $id = DB::table('usuarios')->insertGetId([
            'nome' => 'Fabtech Admin',
            'login' => 'root@admin',
            'email' => 'fabiocoriolano@fabtechinfo.com.br',
            'password' => password_hash('vagalume', PASSWORD_DEFAULT),
            //            'senha' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'tipo' => '1',
            'situacao' => '1',
        ]);

        foreach ($modulos as $modulo) {
            DB::table('permissoes')->insert([
                'usuario_id' => $id,
                'modulo_id' => $modulo->id,
                'created_at' => now()
            ]);
        }
    }
}
