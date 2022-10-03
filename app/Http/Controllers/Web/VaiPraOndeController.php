<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VaiPraOndeController extends Controller
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
    public function index(Request $request, \App\Models\VaiPraOndeCategoria $categoria = null)
    {
        $f_q = $request->f_q;

        $view = \Request::route()->getName();

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'vai-pra-onde')->firstOrFail();

        $posts = \App\Models\VaiPraOnde::where('situacao', 1)
            ->where(function ($query) use ($f_q) {
                $qs = explode(' ', $f_q);
                
                $query->where('categoria_id', 2);
                $query->where('nome', 'like', '%' . $f_q . '%');

                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                }

                return $query;
            })
            ->orderBy('nome', 'ASC')
            ->paginate(15);

        $categorias = \App\Models\VaiPraOndeCategoria::where('situacao', '=', '1')
            ->orderBy('ordem', 'asc')
            ->orderBy('nome', 'asc');

        $top = \App\Models\VaiPraOnde::where('situacao', 1)
            ->where('views', '>', 0)
            ->orderBy('views', 'DESC')
            ->orderBy('nome', 'DESC')
            ->limit(15);
        
        $tit = ["Vai Pra Onde?"];

        return view('web.vaipraonde.lista', compact(
            'pagina',
            'posts',
            'categorias',
            'top',
            'f_q',
            'tit',
            'view'
        ));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\VaiPraOnde $post
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, \App\Models\VaiPraOnde $post)
    {
        $view = "Vai Pra Onde?";

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'vai-pra-onde')->firstOrFail();

        $categorias = \App\Models\VaiPraOndeCategoria::where('situacao', '=', '1')
            ->orderBy('ordem', 'asc')
            ->orderBy('nome', 'asc');

        $categoria = $post->categoria;

        $top = \App\Models\VaiPraOnde::where('situacao', '=', '1')
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->orderBy('nome', 'desc')
            ->limit(15);

        if ($post) {
            $post->views += 1;
            $post->save();
        }

        return view('web.vaipraonde.ver', compact(
            'pagina',
            'post',
            'categoria',
            'categorias',
            'top',
            'view'
        ));
    }
}
