<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $table = 'estados';
    protected $fillable = [
        'nome', 'sigla'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $softCascade = ['cidades'];

    public function cidades()
    {
        return $this->hasMany('App\Models\Cidade', 'estado_id', 'id');
    }

}
