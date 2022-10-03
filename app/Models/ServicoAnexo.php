<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uploadify\Traits\UploadifyTrait;

class ServicoAnexo extends Model
{

    use SoftDeletes;
    use UploadifyTrait;

    protected $table = 'servicos_anexos';
    protected $fillable = [
        'descricao',
        'foto',
        'arquivo',
        'tipo',
        'ordem',
        'servico_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    public $uploadifyImages = [
        'foto' => ['path' => 'servicos/', 'disk' => 'public']
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'servicos/', 'disk' => 'public']
    ];

    public function servico()
    {
        return $this->belongsTo('App\Models\Servico', 'servico_id', 'id');
    }

}
