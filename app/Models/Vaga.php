<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\VagaPresenter;

class Vaga extends Model
{

    use SoftDeletes;
    use PresentableTrait;

    protected $presenter = VagaPresenter::class;
    protected $table = 'vagas';
    protected $fillable = [
        'nome',
        'texto',
        'situacao'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

}
