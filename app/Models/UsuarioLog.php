<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\UsuarioLogPresenter;
// use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioLog extends Model
{
    use PresentableTrait;
    // use SoftDeletes;

    protected $presenter = UsuarioLogPresenter::class;
    protected $table = 'usuarios_logs';
    protected $fillable = [
        'data', 'session', 'ip', 'mensagem', 'info', 'tipo', 'situacao', 'usuario_id'
    ];
    protected $guarded = [
        'id'
    ];
    public $timestamps = false;
    public $softdeletes = false;

    protected $dates = [
        'data',
    ];

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }

}
