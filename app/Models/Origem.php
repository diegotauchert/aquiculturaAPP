<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\OrigemPresenter;

class Origem extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;

    protected $presenter = OrigemPresenter::class;
    protected $table = 'origem';
    protected $fillable = [
        'nome', 'ordem', 'situacao'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function pessoas()
    {
        return $this->hasMany('App\Models\Pessoa', 'origem_id', 'id');
    }
}
