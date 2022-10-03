<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class BannerPresenter extends Presenter
{

    public function alvo()
    {
        $url = parse_url($this->link);
        $url_cur = parse_url(url()->current());

        if (array_key_exists('host', $url)) {
            if ($url_cur['host'] != $url['host']) {
                echo "ok";
                return ' target="_blank"';
            }
        }

        return "";
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

    public function makeTipoAll()
    {
        return $this->makeTipo(true);
    }

    public function makeTipo($all = false)
    {
        $arr = [
            '1' => 'Pop-Up',
            '2' => 'Banner Principal'
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->tipo];
        }
    }

}
