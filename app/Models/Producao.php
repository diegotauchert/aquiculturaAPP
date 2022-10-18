<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\ProducaoPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;

class Producao extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;

    protected $presenter = ProducaoPresenter::class;

    protected $table = 'producao';
    protected $fillable = [
        'categoria_id',
        'qtd',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $dates = ['despesca'];
    protected $casts = ['despesca' => 'datetime: d/m/Y H:i:s'];

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id', 'id');
    }

    public function fazenda()
    {
        return $this->belongsTo('App\Models\Fazenda', 'fazenda_id', 'id');
    }

    public function viveiro()
    {
        return $this->belongsTo('App\Models\Viveiro', 'viveiro_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto', 'produto_id', 'id');
    }
}
