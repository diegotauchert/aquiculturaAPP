<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\VendaPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;
use Uploadify\Traits\UploadifyTrait;

class Venda extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;
    use UploadifyTrait;

    protected $presenter = VendaPresenter::class;

    protected $table = 'vendas';
    protected $fillable = [
        'nome',
        'arquivo',
        'situacao',
        'data',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $dates = ['data'];
    protected $casts = ['data' => 'datetime: d/m/Y H:i:s'];

    public $uploadifyFiles = [
        'arquivo' => ['path' => 'vendas/', 'disk' => 'public']
    ];

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
}
