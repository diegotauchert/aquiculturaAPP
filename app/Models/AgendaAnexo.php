<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class AgendaAnexo extends Model
{
    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'agenda_anexos';
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
        'foto' => ['path' => 'agendas/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'agendas/', 'disk' => 'public']
    ];

    public function agenda()
    {
        return $this->belongsTo('App\Models\Agenda', 'post_id', 'id');
    }

}
