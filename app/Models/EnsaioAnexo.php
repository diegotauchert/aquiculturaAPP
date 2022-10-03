<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class EnsaioAnexo extends Model
{
    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'ensaios_anexos';
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
        'foto' => ['path' => 'ensaios/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'ensaios/', 'disk' => 'public']
    ];

    public function ensaio()
    {
        return $this->belongsTo('App\Models\Ensaio', 'post_id', 'id');
    }

}
