<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\BannerPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;
use Uploadify\Traits\UploadifyTrait;

class Banner extends Model
{

    use SoftDeletes;
    use PresentableTrait;
    use MapDateTimeMutator;
    use UploadifyTrait;

    protected $presenter = BannerPresenter::class;
    protected $table = 'banners';
    protected $visible = [
        'id',
        'nome',
        'link',
        'video',
        'categoria',
        'dt_inicio',
        'dt_fim',
        'tipo',
    ];
    protected $fillable = [
        'nome',
        'link',
        'video',
        'categoria',
        'dt_inicio',
        'dt_fim',
        'texto',
        'arquivo',
        'responsivo',
        'ordem',
        'tipo',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $mapDateTimeMutator = [
        'dt_inicio' => ['from' => 'd/m/Y', 'to' => 'Y-m-d'],
        'dt_fim' => ['from' => 'd/m/Y', 'to' => 'Y-m-d']
    ];
    protected $dates = [
        'dt_inicio',
        'dt_fim',
    ];
    protected $casts = [
        'dt_inicio' => 'datetime',
        'dt_fim' => 'datetime',
    ];
    public $uploadifyImages = [
        'arquivo' => ['path' => 'banners/', 'disk' => 'public'],
        'responsivo' => ['path' => 'banners/', 'disk' => 'public'],
    ];

    public function resolveRouteBinding($value)
    {
        return $this->where('situacao', '1')->where('id', $value)->first() ?? abort(404);
    }
}
