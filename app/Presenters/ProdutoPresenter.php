<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ProdutoPresenter extends Presenter
{
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

    public function makeCategoriaAll()
    {
        return $this->makeCategoria(true);
    }

    public function makeCategoria($all = false)
    {
        $arr = [
            '1' => ['Peixe', ''],
            '2' => ['Camarão', ''],
            '3' => ['Policultivo', ''],
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->situacao];
        }
    }

    public function getCategoria($index)
    {
        $arr = [
            '1' => 'Peixe',
            '2' => 'Camarão',
            '3' => 'Policultivo',
        ];

        return $arr[$index];
    }
    
}
