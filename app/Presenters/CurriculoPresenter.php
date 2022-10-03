<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class CurriculoPresenter extends Presenter
{

    public function apelido()
    {
        $out = explode(' ', trim($this->nome));
        
        return $out[0];
    }
    
    public function makeSexoAll()
    {
        return $this->makeSexo(true);
    }

    public function makeSexo($all = false)
    {
        $arr = [
            '1' => 'Masculino',
            '2' => 'Feminino',
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->sexo];
        }
    }
    
    public function makeEstadoCivilAll()
    {
        return $this->makeEstadoCivil(true);
    }

    public function makeEstadoCivil($all = false)
    {
        $arr = [
            '1' => 'Casado(a)',
            '3' => 'Divorciado(a)',
            '5' => 'Outro',
            '6' => 'Separado(a)',
            '2' => 'Solteiro(a)',
            '7' => 'União Estável',
            '4' => 'Viúvo(a)',
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->estado_civil];
        }
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

}
