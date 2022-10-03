<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\DepoimentoPresenter;
use Uploadify\Traits\UploadifyTrait;

class Depoimento extends Model
{

    use SoftDeletes;
    use PresentableTrait;
    use UploadifyTrait;

    protected $presenter = DepoimentoPresenter::class;
    protected $table = 'depoimentos';
    protected $visible = [
        'id',
        'nome',
        'nota',
        'descricao',
        'ordem',
        'foto',
    ];
    protected $fillable = [
        'nome',
        'nota',
        'descricao',
        'ordem',
        'foto',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public $uploadifyImages = [
        'foto' => ['path' => 'depoimentos/', 'disk' => 'public'],
    ];

    public function resolveRouteBinding($value)
    {
        return $this->where('situacao', '1')->where('id', $value)->first() ?? abort(404);
    }
}
