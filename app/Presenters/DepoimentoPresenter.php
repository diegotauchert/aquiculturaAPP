<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class DepoimentoPresenter extends Presenter
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
}
