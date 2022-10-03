<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\ConfigPresenter;

class Config extends Model
{

    use PresentableTrait;

    protected $presenter = ConfigPresenter::class;
    protected $table = 'configs';
    public $keyType = 'string';
    protected $fillable = [
        'id', 'valor'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function resetSEOKeywordAttribute()
    {
        $this->attributes['valor'] = null;
    }

    public function setSEOKeywordAttribute($seo_keyword)
    {
        $this->attributes['valor'] = $this->attributes['valor'] . ($this->attributes['valor'] ? ',' : '') . $seo_keyword;
    }

}
