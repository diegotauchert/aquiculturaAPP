<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\CategoriaPostPresenter;

class CategoriaPost extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;

    protected $presenter = CategoriaPostPresenter::class;
    protected $table = 'categorias_posts';
    protected $fillable = [
        'nome', 'ordem', 'situacao', 'categoria_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $softCascade = ['referencia', 'posts', 'categorias'];

    public function referencia()
    {
        return $this->belongsTo('App\Models\CategoriaPost', 'categoria_id', 'id');
    }
    
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'categoria_id', 'id');
    }
    
    public function categorias()
    {
        return $this->hasMany('App\Models\CategoriaPost', 'categoria_id', 'id');
    }

}
