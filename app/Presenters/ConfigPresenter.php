<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ConfigPresenter extends Presenter
{

    public function seoKeywords()
    {
        $seo_keywords = explode(',', $this->valor);
        
        return $seo_keywords;
    }

}
