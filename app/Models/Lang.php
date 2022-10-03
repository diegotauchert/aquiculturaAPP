<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\LangPresenter;

class Lang extends Model
{

    use SoftDeletes;
    use PresentableTrait;

    protected $presenter = LangPresenter::class;

    protected $table = 'langs';
    protected $fillable = [
        'nome', 'sigla', 'situacao'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function resolveRouteBinding($value)
    {
        return $this->where('situacao', '1')->where('sigla', $value)->first() ?? abort(404);
    }

}
