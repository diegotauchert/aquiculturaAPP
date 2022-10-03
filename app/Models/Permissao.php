<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissao extends Model
{

    use SoftDeletes;

    protected $table = 'permissoes';
    protected $fillable = [
        'usuario_id', 'modulo_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function modulo()
    {
        return $this->belongsTo('App\Models\Modulo', 'modulo_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }

    public function modulos()
    {
        return $this->hasMany('App\Models\Modulo', 'modulo_id', 'id');
    }

    public function usuarios()
    {
        return $this->hasMany('App\Models\Usuario', 'usuario_id', 'id');
    }

}
