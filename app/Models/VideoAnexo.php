<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class VideoAnexo extends Model
{
    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'videos_anexos';
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
        'foto' => ['path' => 'videos/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'videos/', 'disk' => 'public']
    ];

    public function video()
    {
        return $this->belongsTo('App\Models\Video', 'post_id', 'id');
    }

}
