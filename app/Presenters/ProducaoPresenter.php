<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ProducaoPresenter extends Presenter
{
    public function makeSituacaoAll()
    {
        return $this->makeSituacao(true);
    }

    public function makeSituacao($all = false)
    {
        $arr = [
            '1' => ['Ativo', 'check', 'success'],
            '2' => ['Inativo', 'times', 'danger']
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
            '1' => ['Reajuste de Ração', ''],
            '2' => ['Parâmetro da Água', ''],
            '3' => ['Acompanhamento Semanal', ''],
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->categoria_id];
        }
    }

    public function getCategoria($index)
    {
        $arr = [
            '1' => 'Reajuste de Ração',
            '2' => 'Parâmetro da Água',
            '3' => 'Acompanhamento Semanal',
        ];

        return $arr[$index];
    }
    
}
