<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class AcompanhamentoPresenter extends Presenter
{
    public function makeSituacaoAll()
    {
        return $this->makeSituacao(true);
    }

    public function makeSituacao($all = false)
    {
        $arr = [
            '1' => ['Realizado', 'check', 'success'],
            '2' => ['Não Realizado', 'times', 'danger']
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->situacao];
        }
    }
}
