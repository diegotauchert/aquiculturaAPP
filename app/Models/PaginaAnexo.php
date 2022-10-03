<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class PaginaAnexo extends Model
{

    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'paginas_anexos';
    protected $fillable = [
        'descricao',
        'foto',
        'arquivo',
        'tipo',
        'ordem',
        'pagina_id'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    public $uploadifyImages = [
        'foto' => ['path' => 'paginas/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'paginas/', 'disk' => 'public']
    ];

    protected $softCascade = ['langs'];

    public function lang($lang)
    {
        if ($this->langs()->where('lang_id', $lang)->count() > 0) {
            return $this->langs()->where('lang_id', $lang)->get()[0];
        }

        return new \App\Models\PaginaAnexoLang;
    }

    public function langs()
    {
        return $this->hasMany('App\Models\PaginaAnexoLang', 'pagina_anexo_id', 'id');
    }

    public function pagina()
    {
        return $this->belongsTo('App\Models\Pagina', 'pagina_id', 'id');
    }

}
