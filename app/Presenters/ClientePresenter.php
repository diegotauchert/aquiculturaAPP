<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ClientePresenter extends Presenter
{

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
            '1' => ['Ativo', 'check', 'success'],
            '2' => ['Inativo', 'times', 'danger']
        ];

        if ($all) {
            return $arr;
        } else {
            return $arr[$this->situacao];
        }
    }
    
}
