<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class PostAnexo extends Model
{

    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'posts_anexos';
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
        'foto' => ['path' => 'posts/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'posts/', 'disk' => 'public']
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

}
