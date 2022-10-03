<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\ColunistaPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;

class Colunista extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;

    protected $presenter = ColunistaPresenter::class;

    protected $table = 'colunistas';
    protected $fillable = [
        'nome',
        'local',
        'autor',
        'instagram',
        'video',
        'data',
        'texto',
        'situacao',
        'views',
        'seo_keyword',
        'seo_description',
        'categoria_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $mapDateTimeMutator = [
        'data' => ['from' => 'd/m/Y H:i:s', 'to' => 'Y-m-d H:i:s'],
    ];
    protected $dates = [
        'data',
    ];
    protected $casts = [
        'data' => 'datetime: d/m/Y H:i:s',
    ];

    protected $softCascade = ['anexos'];

    public function resetSEOKeywordAttribute() {
        $this->attributes['seo_keyword'] = null;
    }

    public function setSEOKeywordAttribute($seo_keyword) {
        $this->attributes['seo_keyword'] = $this->attributes['seo_keyword'] . ($this->attributes['seo_keyword'] ? ',' : '') . $seo_keyword;
    }

    public function resolveRouteBinding($value)
    {
        return $this->where('situacao', '1')->where('id', $value)->first() ?? abort(404);
    }

    public function anexos()
    {
        return $this->hasMany('App\Models\ColunistaAnexo', 'post_id', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\ColunistaCategoria', 'categoria_id', 'id');
    }

}
