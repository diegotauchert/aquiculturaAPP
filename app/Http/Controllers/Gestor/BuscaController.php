<?php

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class BuscaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:gestor', 'auth.unique.user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $palavra = $request->p;

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'search')->firstOrFail();

        $blog = \App\Models\Post::where('situacao', '=', '1')
            ->where(function ($query) use ($palavra) {
                $qs = explode(' ', $palavra);

                $query->where('nome', 'like', '%' . $palavra . '%');

                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                }

                return $query;
            })->get();

        $paginas = \App\Models\Pagina::where('situacao', '1')
            ->where(function ($query) use ($palavra) {
                $qs = explode(' ', $palavra);

                $query->where('nome', 'like', '%' . $palavra . '%');

                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                    $query->orWhere('seo_keyword', 'like', '%' . $q . '%');
                    $query->orWhere('seo_description', 'like', '%' . $q . '%');
                }

                return $query;
            })->get();

        $items = collect($paginas->all())
            ->merge($blog->all())
            ->sortBy('paginas.nome');

        $buscas = $this->paginate($items, 50, $request->page, url()->current());

        return view('web.busca.lista', compact('pagina', 'buscas', 'palavra'));
    }

    public function paginate($items, $perPage = 15, $page = null, $baseUrl = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ?
            $items : Collection::make($items);

        $lap = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        return $lap;
    }
}
