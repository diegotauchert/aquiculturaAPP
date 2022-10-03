<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\RegiaoPresenter;
use Uploadify\Traits\UploadifyTrait;

class Regiao extends Model
{

    use SoftDeletes;
    use PresentableTrait;
    use UploadifyTrait;

    protected $presenter = RegiaoPresenter::class;
    protected $table = 'regioes';
    protected $fillable = [
        'nome',
        'pontos',
        'situacao'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'regioes/', 'disk' => 'public'],
    ];

    public function representantes()
    {
        return $this->hasMany('App\Models\Representante', 'regiao_id', 'id');
    }

}
