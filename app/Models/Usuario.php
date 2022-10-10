<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\UsuarioPresenter;
use Uploadify\Traits\UploadifyTrait;

class Usuario extends Authenticatable
{

    use Notifiable;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use UploadifyTrait;

    protected $presenter = UsuarioPresenter::class;
    protected $table = 'usuarios';

    protected $fillable = [
        'nome', 'login', 'email', 'tipo', 'situacao'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $dates = [
        'email_verified_at',
    ];
    public $uploadifyImages = [
        'foto' => ['path' => 'usuarios/', 'disk' => 'public'],
    ];
    protected $softCascade = ['permissoes'];

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id', 'id');
    }

    public function fazenda()
    {
        return $this->belongsTo('App\Models\Fazenda', 'fazenda_id', 'id');
    }

    public function permissoes()
    {
        return $this->hasMany('App\Models\Permissao', 'usuario_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\UsuarioLog', 'usuario_id', 'id');
    }

    public function registerLogs($msg = null, $ip = null, $session = null, $info = null, $tipo = null, $situacao = 1)
    {
        // Cadastra na tabela usuarios_logs um novo registro com as informações do usuário logado
        return $this->logs()->insertGetId([
                    'usuario_id' => $this->id,
                    'data' => now(),
                    'session' => $session,
                    'ip' => $ip,
                    'mensagem' => $msg,
                    'info' => $info,
                    'tipo' => $tipo,
                    'situacao' => $situacao,
        ]);
    }

}
