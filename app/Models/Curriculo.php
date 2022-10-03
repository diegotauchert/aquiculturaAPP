<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\CurriculoPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;
use App\Gestor\Util;
use Uploadify\Traits\UploadifyTrait;

class Curriculo extends Authenticatable
{

    use Notifiable;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;
    use UploadifyTrait;

    protected $presenter = CurriculoPresenter::class;
    protected $table = 'curriculos';
    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'nascimento',
        'sexo',
        'estado_civil',
        'email',
        'telefone',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cargo',
        'experiencia',
        'formacao',
        'qualificacao',
        'cursos',
        'idiomas',
        'salario',
        'foto',
        'situacao',
        'cidade_id',
        'vaga_id'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $dates = [
        'nascimento',
        'email_verified_at',
    ];
    protected $mapDateTimeMutator = [
        'nascimento' => ['from' => 'd/m/Y', 'to' => 'Y-m-d']
    ];

    protected $softCascade = ['cidade', 'vaga'];

    public function setSalarioAttribute($val)
    {
        $this->attributes['salario'] = Util::removeMaksValor($val);
    }

    public function getSalarioAttribute()
    {
        if ($this->attributes) {
            return Util::maksValor($this->attributes['salario']);
        }
    }
    public $uploadifyImages = [
        'foto' => ['path' => 'curriculos/', 'disk' => 'public'],
    ];

    public function cidade()
    {
        return $this->belongsTo('App\Models\Cidade', 'cidade_id', 'id');
    }

    public function vaga()
    {
        return $this->belongsTo('App\Models\Vaga', 'vaga_id', 'id');
    }

    public function registerLogs($msg = null, $ip = null, $session = null, $info = null, $tipo = null, $situacao = 1)
    {
        // Cadastra na tabela usuarios_logs um novo registro com as informações do usuário logado
       return $this->logs()->insertGetId([
            'curriculo_id' => $this->id,
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
