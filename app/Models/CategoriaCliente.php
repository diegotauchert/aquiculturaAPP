<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\CategoriaClientePresenter;

class CategoriaCliente extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;

    protected $presenter = CategoriaClientePresenter::class;
    protected $table = 'categorias_clientes';
    protected $fillable = [
        'nome', 'ordem', 'situacao', 'categoria_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $softCascade = ['referencia', 'clientes', 'categorias'];

    public function referencia()
    {
        return $this->belongsTo('App\Models\CategoriaCliente', 'categoria_id', 'id');
    }
    
    public function clientes()
    {
        return $this->hasMany('App\Models\Cliente', 'categoria_id', 'id');
    }
    
    public function categorias()
    {
        return $this->hasMany('App\Models\CategoriaCliente', 'categoria_id', 'id');
    }

}
