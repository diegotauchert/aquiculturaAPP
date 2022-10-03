<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\ModuloPresenter;

class Modulo extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;

    protected $presenter = ModuloPresenter::class;

    protected $table = 'modulos';
    protected $fillable = [
        'nome', 'link', 'menu', 'situacao', 'exibe', 'modulo_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $softCascade = ['modulos'];

    public function referencia()
    {
        return $this->belongsTo('App\Models\Modulo', 'modulo_id', 'id');
    }

    public function modulos()
    {
        return $this->hasMany('App\Models\Modulo', 'modulo_id', 'id');
    }

    public function resetLinkAttribute() {
        $this->attributes['link'] = null;
    }
    
    public function setLinkAttribute($link) {
        $this->attributes['link'] = $this->attributes['link'] . ($this->attributes['link'] ? ',' : '') . $link;
    }
    
}
