<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ModuloPresenter extends Presenter
{

    public function links() {
        $links = explode(',', $this->link);

        return $links;
    }

    public function makeMenuAll()
    {
        return $this->makeMenu(true);
    }

    public function makeMenu($all = false)
    {
        $arr = [
            '1' => ['Aplicações', 'rocket'],
            '2' => ['Cadastros', 'folder-open'],
            '3' => ['Relatórios', 'chart-pie'],
            '4' => ['Ajustes', 'cogs']
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->menu];
        }
    }

    public function filterMenu($nav)
    {
        $arr = [
            '1' => ['Aplicações', 'rocket'],
            '2' => ['Cadastros', 'folder-open'],
            '3' => ['Relatórios', 'chart-pie'],
            '4' => ['Ajustes', 'cogs']
        ];

        return $arr[$nav];
    }

    public function makeSituacaoAll()
    {
        return $this->makeSituacao(true);
    }

    public function makeSituacao($all = false)
    {
        $arr = [
            '1' => ['Ativo', 'check'],
            '2' => ['Inativo', 'times']
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->situacao];
        }
    }

    public function makeExibeAll()
    {
        return $this->makeExibe(true);
    }

    public function makeExibe($all = false)
    {
        $arr = [
            '1' => ['Sim', 'check'],
            '2' => ['Não', 'times']
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->exibe];
        }
    }

}
