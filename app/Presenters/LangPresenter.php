<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class LangPresenter extends Presenter
{

    public function traducao($chave) {
        $traducao = [
            'no-data' => [
                1 => 'Não há dados cadastrados!',
                2 => 'No data registered!',
                3 => 'No data registered!'
            ],
            'success-send' => [
                1 => 'Cadastro realizado!',
                2 => 'Registration done!',
                3 => '¡Registro hecho!'
            ],
            'error-last' => [
                1 => 'Desculpe, tente novamente mais tarde.',
                2 => 'Sorry, try again later.',
                3 => 'Lo sentimos, intente nuevamente más tarde.'
            ],
            'input-null' => [
                1 => 'Preencha os campos para continuar!',
                2 => 'Fill in the fields to continue!',
                3 => '¡Complete los campos para continuar!'
            ],
            'mes-01' => [
                1 => 'Janeiro',
                2 => 'January',
                3 => 'Enero'
            ],
            'mes-02' => [
                1 => 'Fevereiro',
                2 => 'February',
                3 => 'Febrero'
            ],
            'mes-03' => [
                1 => 'Março',
                2 => 'March',
                3 => 'Marzo'
            ],
            'mes-04' => [
                1 => 'Abril',
                2 => 'April',
                3 => 'Abril'
            ],
            'mes-05' => [
                1 => 'Maio',
                2 => 'May',
                3 => 'Mayo'
            ],
            'mes-06' => [
                1 => 'Junho',
                2 => 'June',
                3 => 'Junio'
            ],
            'mes-07' => [
                1 => 'Julho',
                2 => 'July',
                3 => 'Julio'
            ],
            'mes-08' => [
                1 => 'Agosto',
                2 => 'August',
                3 => 'Agosto'
            ],
            'mes-09' => [
                1 => 'Setembro',
                2 => 'September',
                3 => 'Septiembre'
            ],
            'mes-10' => [
                1 => 'Outubro',
                2 => 'October',
                3 => 'Octubre'
            ],
            'mes-11' => [
                1 => 'Novembro',
                2 => 'November',
                3 => 'Noviembre'
            ],
            'mes-12' => [
                1 => 'Dezembro',
                2 => 'December',
                3 => 'Diciembre'
            ],
        ];

        return (array_key_exists($chave, $traducao) ? $traducao[$chave][$this->id] : '');
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
