<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\ServicoPresenter;

class Servico extends Model
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use PresentableTrait;

    protected $presenter = ServicoPresenter::class;

    protected $table = 'servicos';
    protected $fillable = [
        'nome', 
        'descricao', 
        'texto', 
        'situacao', 
        'views', 
        'icone', 
        'seo_keyword', 
        'seo_description', 
        'categoria_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $softCascade = ['anexos'];

    public function resetSEOKeywordAttribute() {
        $this->attributes['seo_keyword'] = null;
    }
    
    public function setSEOKeywordAttribute($seo_keyword) {
        $this->attributes['seo_keyword'] = $this->attributes['seo_keyword'] . ($this->attributes['seo_keyword'] ? ',' : '') . $seo_keyword;
    }
    
    public function categoria()
    {
        return $this->belongsTo('App\Models\CategoriaServico', 'categoria_id', 'id');
    }
    
    public function anexos()
    {
        return $this->hasMany('App\Models\ServicoAnexo', 'servico_id', 'id');
    }
    
}
