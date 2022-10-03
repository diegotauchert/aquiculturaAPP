<?php

namespace App\Http\Controllers\Web;

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
        //        $this->middleware('auth');
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
            ->where('link', 'busca')->firstOrFail();

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

        $agendas = \App\Models\Agenda::where('situacao', '=', '1')
            ->where(function ($query) use ($palavra) {
                $qs = explode(' ', $palavra);

                $query->where('nome', 'like', '%' . $palavra . '%');

                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                }

                return $query;
            })
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $coberturas = \App\Models\Cobertura::where('situacao', '=', '1')
            ->where(function ($query) use ($palavra) {
                $qs = explode(' ', $palavra);

                $query->where('nome', 'like', '%' . $palavra . '%');

                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                }

                return $query;
            })
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $colunistas = \App\Models\Colunista::where('situacao', '=', '1')
            ->where(function ($query) use ($palavra) {
                $qs = explode(' ', $palavra);

                $query->where('nome', 'like', '%' . $palavra . '%');

                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                }

                return $query;
            })
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();
        
        $promocao = \App\Models\Post::select('posts.*')
            ->where('posts.situacao', '=', '1')
            ->where('posts.categoria_id', 2)
            ->where(function ($query) use ($palavra) {
                $qs = explode(' ', $palavra);

                $query->where('nome', 'like', '%' . $palavra . '%');

                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                }

                return $query;
            })
            ->orderBy('posts.data', 'desc')
            ->get();
        
        $video = \App\Models\Video::where('situacao', '=', '1')
            ->where(function ($query) use ($palavra) {
                $qs = explode(' ', $palavra);

                $query->where('nome', 'like', '%' . $palavra . '%');

                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                }

                return $query;
            })
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $items = collect($blog->all())
            ->merge($agendas->all())
            ->merge($colunistas->all())
            ->merge($coberturas->all())
            ->merge($video->all())
            ->merge($promocao->all());

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
