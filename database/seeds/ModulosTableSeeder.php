<?php

use Illuminate\Database\Seeder;

class ModulosTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function subModulo($rules, $modulo, $id)
    {
        foreach ($rules as $rule => $rule_link) {
            $new_link = "";

            if (is_array($rule_link)) {
                foreach ($rule_link as $k => $link) {
                    $new_link = $new_link . ($k > 0 ? ',' : '') . $modulo['link'] . $link;
                }
            } else {
                $new_link = $modulo['link'] . $rule_link;
            }

            DB::table('modulos')->insert([
                'modulo_id' => $id, 'nome' => $rule,
                'link' => $new_link, 'menu' => $modulo['menu'],
                'situacao' => $modulo['situacao'], 'exibe' => '2',
            ]);
        }
    }

    public function run()
    {
        //    \App\Models\Modulo::truncate();
        $rules = [
            'Incluir' => [
                '.create',
                '.store'
            ],
            'Editar' => [
                '.edit',
                '.update'
            ],
            'Excluir' => '.destroy',
        ];

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Usuários',
            'link' => 'gestor.usuarios',
            'menu' => '4',
            'situacao' => '1',
            'exibe' => '1',
        ];
        $id = DB::table('modulos')->insertGetId([
            'nome' => $modulo['nome'], 'link' => $modulo['link'] . '.index',
            'menu' => $modulo['menu'], 'situacao' => $modulo['situacao'],
            'exibe' => $modulo['exibe'],
        ]);
        $this->subModulo($rules, $modulo, $id);

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Módulos',
            'link' => 'gestor.modulos',
            'menu' => '4',
            'situacao' => '1',
            'exibe' => '1',
        ];
        $id = DB::table('modulos')->insertGetId([
            'nome' => $modulo['nome'], 'link' => $modulo['link'] . '.index',
            'menu' => $modulo['menu'], 'situacao' => $modulo['situacao'],
            'exibe' => $modulo['exibe'],
        ]);
        $this->subModulo($rules, $modulo, $id);

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Planos',
            'link' => 'gestor.planos',
            'menu' => '2',
            'situacao' => '1',
            'exibe' => '1',
        ];

        $id = DB::table('modulos')->insertGetId([
            'nome' => $modulo['nome'], 'link' => $modulo['link'] . '.index',
            'menu' => $modulo['menu'], 'situacao' => $modulo['situacao'],
            'exibe' => $modulo['exibe'],
        ]);
        $this->subModulo($rules, $modulo, $id);

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Clientes',
            'link' => 'gestor.clientes',
            'menu' => '2',
            'situacao' => '1',
            'exibe' => '1',
        ];

        $id = DB::table('modulos')->insertGetId([
            'nome' => $modulo['nome'], 'link' => $modulo['link'] . '.index',
            'menu' => $modulo['menu'], 'situacao' => $modulo['situacao'],
            'exibe' => $modulo['exibe'],
        ]);
        $this->subModulo($rules, $modulo, $id);

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Categorias de Clientes',
            'link' => 'gestor.categorias-clientes',
            'menu' => '2',
            'situacao' => '1',
            'exibe' => '1',
        ];
        $id = DB::table('modulos')->insertGetId([
            'nome' => $modulo['nome'], 'link' => $modulo['link'] . '.index',
            'menu' => $modulo['menu'], 'situacao' => $modulo['situacao'],
            'exibe' => $modulo['exibe'],
        ]);
        $this->subModulo($rules, $modulo, $id);

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Menus',
            'link' => 'gestor.menus',
            'menu' => '2',
            'situacao' => '1',
            'exibe' => '1',
        ];
        $id = DB::table('modulos')->insertGetId([
            'nome' => $modulo['nome'], 'link' => $modulo['link'] . '.index',
            'menu' => $modulo['menu'], 'situacao' => $modulo['situacao'],
            'exibe' => $modulo['exibe'],
        ]);
        $this->subModulo($rules, $modulo, $id);

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Configurações',
            'link' => 'gestor.configs.index,gestor.configs.store',
            'menu' => '4',
            'situacao' => '1',
            'exibe' => '1',
        ];
        $id = DB::table('modulos')->insertGetId([
            'nome' => $modulo['nome'], 'link' => $modulo['link'] . '.index',
            'menu' => $modulo['menu'], 'situacao' => $modulo['situacao'],
            'exibe' => $modulo['exibe'],
        ]);

        $rules = [
            'Incluir' => [
                '.create',
                '.store'
            ],
            'Editar' => [
                '.edit',
                '.update'
            ],
            'Excluir' => '.destroy',
        ];
    }
}
