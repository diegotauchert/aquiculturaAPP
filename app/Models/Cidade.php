<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model
{

    use SoftDeletes;

    protected $table = 'cidades';
    protected $visible = [
        'id', 'nome'
    ];
    protected $fillable = [
        'nome', 'ibge_code', 'estado_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'estado_id', 'id');
    }

}
