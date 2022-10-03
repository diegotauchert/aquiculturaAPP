<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class VaiPraOndeAnexo extends Model
{
    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'vaipraonde_anexos';
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
        'foto' => ['path' => 'vaipraonde/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'vaipraonde/', 'disk' => 'public']
    ];

    public function vaipraonde()
    {
        return $this->belongsTo('App\Models\VaiPraOnde', 'post_id', 'id');
    }

}
