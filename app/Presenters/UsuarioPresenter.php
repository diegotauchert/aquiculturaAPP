<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class UsuarioPresenter extends Presenter
{

    public function apelido()
    {
        $out = explode(' ', trim($this->nome));
        
        return $out[0];
    }

    public function ultimoLog()
    {
        return $logs;
    }

    public function makeTipoAll()
    {
        return $this->makeTipo(true);
    }

    public function makeTipo($all = false)
    {
        $arr = [
            '1' => ['Sistema', 'code'],
            '2' => ['Administrador', 'users-cog'],
            '3' => ['Gerente', 'user-cog'],
            '4' => ['Proprietário', 'user'],
            '5' => ['Gestor', 'user'],
            '6' => ['Engenheiro', 'user'],
            '7' => ['Técnico', 'user'],
            '8' => ['Produção', 'user'],
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->tipo];
        }
    }

    public function makeSituacaoAll()
    {
        return $this->makeSituacao(true);
    }

    public function makeSituacao($all = false)
    {
        $arr = [
            '1' => ['Liberado', 'check'],
            '2' => ['Bloqueado', 'times']
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->situacao];
        }
    }

}
