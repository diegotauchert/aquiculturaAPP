<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ServicoPresenter extends Presenter
{

    public function capa()
    {
        $foto = $this->anexos->where('tipo', '=', 1)->sortBy('ordem')->first();

        if($foto) {
            return $foto->foto;
        }

        return '';
    }

    public function seoKeywords()
    {
        $seo_keywords = explode(',', $this->seo_keyword);

        return $seo_keywords;
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
