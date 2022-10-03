<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\PaginaPresenter;

class Pagina extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;

    protected $presenter = PaginaPresenter::class;
    protected $table = 'paginas';
    protected $fillable = [
        'nome',
        'descricao',
        'link',
        'email',
        'video',
        'texto',
        'texto_full',
        'situacao',
        'seo_keyword',
        'seo_description'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $softCascade = ['anexos'];

    public function resetEmailAttribute()
    {
        $this->attributes['email'] = null;
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = $this->attributes['email'] . ($this->attributes['email'] ? ',' : '') . $email;
    }

    public function resetSEOKeywordAttribute()
    {
        $this->attributes['seo_keyword'] = null;
    }

    public function setSEOKeywordAttribute($seo_keyword)
    {
        $this->attributes['seo_keyword'] = $this->attributes['seo_keyword'] . ($this->attributes['seo_keyword'] ? ',' : '') . $seo_keyword;
    }

    public function resolveRouteBinding($value)
    {
        return $this->where('situacao', '1')->where('link', $value)->first() ?? abort(404);
    }

    public function anexos()
    {
        return $this->hasMany('App\Models\PaginaAnexo', 'pagina_id', 'id');
    }
}
