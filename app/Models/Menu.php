<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\MenuPresenter;

class Menu extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;

    protected $presenter = MenuPresenter::class;
    protected $table = 'menus';
    protected $fillable = [
        'nome',
        'link',
        'situacao',
        'exibe',
        'ordem',
        'menu_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $softCascade = ['referencia', 'itens'];

    public function referencia()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id', 'id');
    }

    public function itens()
    {
        return $this->hasMany('App\Models\Menu', 'menu_id', 'id');
    }

}
