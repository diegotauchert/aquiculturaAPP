<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class ColunistaAnexo extends Model
{
    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'colunistas_anexos';
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
        'foto' => ['path' => 'colunistas/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'colunistas/', 'disk' => 'public']
    ];

    public function colunista()
    {
        return $this->belongsTo('App\Models\Colunista', 'post_id', 'id');
    }

}
