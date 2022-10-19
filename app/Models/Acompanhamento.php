<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\AcompanhamentoPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;

class Acompanhamento extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;

    protected $presenter = AcompanhamentoPresenter::class;

    protected $table = 'acompanhamento';
    protected $fillable = [
        'arracoamento',
        'horario',
        'data',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $dates = ['data'];

    protected $casts = [
        'data' => 'datetime: d/m/Y H:i:s'
    ];

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id', 'id');
    }

    public function fazenda()
    {
        return $this->belongsTo('App\Models\Fazenda', 'fazenda_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }

    public function viveiro()
    {
        return $this->belongsTo('App\Models\Viveiro', 'viveiro_id', 'id');
    }

    public function producao()
    {
        return $this->belongsTo('App\Models\Producao', 'producao_id', 'id');
    }
}
