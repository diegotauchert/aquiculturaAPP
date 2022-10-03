<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\EnsaioPresenter;
use App\Gestor\Util;
use Uploadify\Traits\UploadifyTrait;

class EnsaioCategoria extends Model
{
    use Notifiable;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use UploadifyTrait;

    protected $presenter = EnsaioPresenter::class;

    protected $table = 'categorias_ensaios';
    protected $fillable = [
        'nome',
        'ordem',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public $uploadifyImages = [
        'foto' => ['path' => 'categorias/', 'disk' => 'public'],
    ];

    public function resolveRouteBinding($value)
    {
        return $this->where('situacao', '1')->where('id', $value)->first() ?? abort(404);
    }

    public function ensaios()
    {
        return $this->hasMany('App\Models\Ensaio', 'categoria_id', 'id');
    }

}
