<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\FazendaPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;

class Fazenda extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;

    protected $presenter = FazendaPresenter::class;

    protected $table = 'fazendas';
    protected $fillable = [
        'nome',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function resolveRouteBinding($value)
    {
        return $this->where('situacao', '1')->where('id', $value)->first() ?? abort(404);
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id', 'id');
    }

    public function usuarios()
    {
        return $this->hasMany('App\Models\Usuario', 'fazenda_id', 'id');
    }
}
