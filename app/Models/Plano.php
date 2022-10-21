<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\PlanoPresenter;
use Torzer\Common\Traits\MapDateTimeMutator;

class Plano extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;
    use MapDateTimeMutator;

    protected $presenter = PlanoPresenter::class;

    protected $table = 'planos';
    protected $fillable = [
        'nome',
        'situacao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function fazendas()
    {
        return $this->hasMany('App\Models\Fazenda', 'plano_id', 'id');
    }
}
