<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class CoberturaAnexo extends Model
{
    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'cobertura_anexos';
    protected $fillable = [
        'descricao',
        'foto',
        'arquivo',
        'tipo',
        'ordem',
        'post_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    public $uploadifyImages = [
        'foto' => ['path' => 'coberturas/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'coberturas/', 'disk' => 'public']
    ];

    public function cobertura()
    {
        return $this->belongsTo('App\Models\Cobertura', 'post_id', 'id');
    }

}
