<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class PaginaPresenter extends Presenter
{

    public function emails()
    {
        $emails = explode(',', $this->email);

        return $emails;
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
    
    public function makeTextoFullAll()
    {
        return $this->makeTextoFull(true);
    }

    public function makeTextoFull($all = false)
    {
        $arr = [
            '1' => ['Sim', 'check'],
            '2' => ['Não', 'times']
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->texto_full];
        }
    }

}
