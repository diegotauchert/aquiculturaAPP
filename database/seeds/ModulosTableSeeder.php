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
               'nome' => 'Páginas',
               'link' => 'gestor.paginas',
               'menu' => '2',
               'situacao' => '1',
               'exibe' => '1'
           ];
           $id = DB::table('modulos')->insertGetId([
               'nome' => $modulo['nome'], 'link' => $modulo['link'] . '.index',
               'menu' => $modulo['menu'], 'situacao' => $modulo['situacao'],
               'exibe' => $modulo['exibe'],
           ]);
           $this->subModulo($rules, $modulo, $id);

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Newsletter',
            'link' => 'gestor.interessados',
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
            'nome' => 'Banners',
            'link' => 'gestor.banners',
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
            'nome' => 'Categorias Banners',
            'link' => 'gestor.banners-categorias',
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
            'nome' => 'Notícias/Promoções',
            'link' => 'gestor.posts',
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
            'nome' => 'Categorias Notícias/Promoções',
            'link' => 'gestor.categorias-posts',
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
            'nome' => 'Depoimentos',
            'link' => 'gestor.depoimentos',
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
            'nome' => 'Idiomas',
            'link' => 'gestor.langs',
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

        $modulo = [
            'modulo_id' => null,
            'nome' => 'Downloads',
            'link' => 'gestor.downloads',
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
            'nome' => 'Agenda Categorias',
            'link' => 'gestor.agendas-categorias',
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
            'nome' => 'Agenda',
            'link' => 'gestor.agendas',
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
            'nome' => 'Cobertura Categorias',
            'link' => 'gestor.coberturas-categorias',
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
            'nome' => 'Coberturas',
            'link' => 'gestor.coberturas',
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
            'nome' => 'Colunistas Categorias',
            'link' => 'gestor.colunistas-categorias',
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
            'nome' => 'Colunistas',
            'link' => 'gestor.colunistas',
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
            'nome' => 'Colunistas Posts',
            'link' => 'gestor.colunistas.post',
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
            'nome' => 'Ensaios Categorias',
            'link' => 'gestor.ensaios-categorias',
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
            'nome' => 'Ensaios',
            'link' => 'gestor.ensaios',
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
            'nome' => 'Vai pra Onde / Categorias',
            'link' => 'gestor.vaipraonde-categorias',
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
            'nome' => 'Vai pra Onde',
            'link' => 'gestor.vaipraonde',
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
            'nome' => 'TV AjuFest Categorias',
            'link' => 'gestor.videos-categorias',
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
            'nome' => 'TV AjuFest',
            'link' => 'gestor.videos',
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
    }
}
