<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\ProdutoPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;

class Lote extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;

    protected $presenter = ProdutoPresenter::class;

    protected $table = 'produtos_lote';
    protected $fillable = [
        'nome',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $dates = [
        'validade',
    ];
    protected $casts = [
        'validade' => 'datetime: d/m/Y H:i:s',
    ];

    public function resolveRouteBinding($value)
    {
        return $this->where('situacao', '1')->where('id', $value)->first() ?? abort(404);
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id', 'id');
    }

    public function fazenda()
    {
        return $this->belongsTo('App\Models\Fazenda', 'fazenda_id', 'id');
    }

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto', 'produto_id', 'id');
    }
}
