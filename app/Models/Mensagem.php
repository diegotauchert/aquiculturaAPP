<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\MensagemPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;
use Uploadify\Traits\UploadifyTrait;

class Mensagem extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;
    use UploadifyTrait;

    protected $presenter = MensagemPresenter::class;

    protected $table = 'mensagens';
    protected $fillable = [
        'nome',
        'arquivo',
        'data',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $dates = ['data'];
    protected $casts = ['data' => 'datetime: d/m/Y H:i:s'];

    public $uploadifyFiles = [
        'arquivo' => ['path' => 'mensagens/', 'disk' => 'public']
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

    public function remetente()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id_remetente', 'id');
    }

    public function destinatario()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id_destino', 'id');
    }
}
