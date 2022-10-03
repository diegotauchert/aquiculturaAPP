<?php

namespace App\Gestor;

use Illuminate\Support\Facades\Auth;

class Util
{

    public static function saudacao()
    {
        if (date("H") < 12 && date("H") >= 5) {
            $msg = "Bom Dia";
        } else if (date("H") >= 12 && date("H") < 19) {
            $msg = "Boa Tarde";
        } else if (date("H") >= 19 && date("H") < 24) {
            $msg = "Boa Noite";
        } else if (date("H") >= 0 && date("H") < 5) {
            $msg = "Boa Madrugada";
        } else {
            $msg = "";
        }

        return $msg;
    }

    public static function permissao($guard, $route)
    {
        $modulos = Auth::guard($guard)->user()->permissoes()
                        ->select('permissoes.*')
                        ->leftJoin('modulos', 'modulos.id', '=', 'permissoes.modulo_id')
                        ->where('modulos.link', 'like', '%' . $route . '%')
                        ->where('modulos.situacao', '=', 1)->get();

        if (count($modulos) > 0) {
            return true;
        }

        return false;
    }

    public static function msgPermissao($guard)
    {
        return [
            'type' => 'warning',
            'message' => 'Desculpe <b>' . auth()->guard($guard)->user()->present()->apelido . '</b>, sem permissão para esta ação!'
        ];
    }

    public static function removeMaksValor($value)
    {
        $decimalsOptions = [
            'setDecimalsFrom' => ',',
            'setDecimalsTo' => '.',
            'setThounsandFrom' => '.',
            'setThounsandTo' => '',
            'getDecimalsFrom' => '.',
            'getDecimalsTo' => ',',
            'getThounsandFrom' => ',',
            'getThounsandTo' => '.',
            'decimals' => 2,
        ];

        $parts = explode($decimalsOptions['setDecimalsFrom'], $value);
        $temp = str_replace($decimalsOptions['setDecimalsFrom'], '+++|||', str_replace($decimalsOptions['setThounsandFrom'], '|||+++', $value));
        $temp = str_replace(['|||+++', '+++|||'], ['', '.'], $temp);

        return number_format((float) $temp, $decimalsOptions['decimals'], $decimalsOptions['setDecimalsTo'], $decimalsOptions['setThounsandTo']);
    }

    public static function maksValor($value)
    {
        $decimalsOptions = [
            'setDecimalsFrom' => ',',
            'setDecimalsTo' => '.',
            'setThounsandFrom' => '.',
            'setThounsandTo' => '',
            'getDecimalsFrom' => '.',
            'getDecimalsTo' => ',',
            'getThounsandFrom' => ',',
            'getThounsandTo' => '.',
            'decimals' => 2,
        ];

        $parts = explode($decimalsOptions['getDecimalsFrom'], $value);
        $temp = str_replace($decimalsOptions['getDecimalsFrom'], '+++|||', str_replace($decimalsOptions['getThounsandFrom'], '|||+++', $value));
        $temp = str_replace(['|||+++', '+++|||'], ['', '.'], $temp);

        return number_format((float) $temp, $decimalsOptions['decimals'], $decimalsOptions['getDecimalsTo'], $decimalsOptions['getThounsandTo']);
    }

    public static function diasEntre($data_inicial, $data_final)
    {
        $time_inicial = strtotime($data_inicial);
        $time_final = strtotime($data_final);

        $diferenca = $time_final - $time_inicial;

        $dias = (int) floor($diferenca / (60 * 60 * 24));

        return $dias;
    }

    public static function meses($val)
    {
        $meses = [
            "01" => "Janeiro",
            "02" => "Fevereiro",
            "03" => "Março",
            "04" => "Abril",
            "05" => "Maio",
            "06" => "Junho",
            "07" => "Julho",
            "08" => "Agosto",
            "09" => "Setembro",
            "10" => "Outubro",
            "11" => "Novembro",
            "12" => "Dezembro"
        ];

        return $meses[$val];
    }

    public static function mostraData(\DateTime $date = null)
    {
        if (empty($date)) {
            $date = new \DateTime();
        }

        return $date->format('d') . " de " . mb_strtolower(Util::meses($date->format('m'))) . " de " . $date->format('Y');
    }

    public static function somaData($data, $dias, $meses, $anos)
    {
        $data = explode("/", $data);
        $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $anos));

        return $newData;
    }

    public static function formatTelefone($fone)
    {
        return "+55".str_replace([' ', '(', ')', '-', '+55'],"", strip_tags($fone));
    }

    public static function resize($file, $w, $h)
    {
        \Image::make($file)->resize($w, $h, function($c) {
            $c->aspectRatio();
            $c->upsize();
        })->save();
    }

}
