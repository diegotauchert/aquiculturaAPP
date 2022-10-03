<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\DownloadPresenter;
use Uploadify\Traits\UploadifyTrait;

class Download extends Model
{

    use SoftDeletes;
    use PresentableTrait;
    use UploadifyTrait;

    protected $presenter = DownloadPresenter::class;
    protected $table = 'downloads';
    protected $fillable = [
        'nome',
        'link',
        'descricao',
        'situacao'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    public $uploadifyFiles = [
        'arquivo' => ['path' => 'downloads/', 'disk' => 'public'],
    ];
}
