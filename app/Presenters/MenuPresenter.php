<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class MenuPresenter extends Presenter
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
