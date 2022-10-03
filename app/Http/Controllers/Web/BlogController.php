<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
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
    public function index(Request $request, \App\Models\CategoriaPost $categoria = null)
    {
        $f_q = $request->f_q;
        $view = \Request::route()->getName();

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'noticias')->firstOrFail();

        if ($categoria) {
            $posts = \App\Models\Post::where('situacao', '=', '1')->where('categoria_id', '=', $categoria->id)
                ->where(function ($query) use ($f_q) {
                    $qs = explode(' ', $f_q);

                    $query->where('nome', 'like', '%' . $f_q . '%');

                    foreach ($qs as $q) {
                        $query->orWhere('nome', 'like', '%' . $q . '%');
                        $query->orWhere('texto', 'like', '%' . $q . '%');
                    }

                    return $query;
                })
                ->orderBy('posts.data', 'desc')
                ->paginate(15);
        } else {
            $posts = \App\Models\Post::where('situacao', '=', '1')
                ->where('categoria_id', '=', '1')
                ->where(function ($query) use ($f_q) {
                    $qs = explode(' ', $f_q);
                    $query->where('nome', 'like', '%' . $f_q . '%');
                    foreach ($qs as $q) {
                        $query->orWhere('nome', 'like', '%' . $q . '%');
                        $query->orWhere('texto', 'like', '%' . $q . '%');
                    }

                    return $query;
                })
                ->orderBy('id', 'desc')
                ->paginate(15);
        }

        $categorias = \App\Models\CategoriaPost::where('situacao', '=', '1')
            ->whereNull('categoria_id')
            ->orderBy('ordem', 'asc')
            ->orderBy('nome', 'asc');

        $top = \App\Models\Post::where('situacao', '=', '1')
            ->where('categoria_id', '=', '1')
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->orderBy('nome', 'desc')
            ->limit(15);

        $tit = ["Blog e Notícias", "Postagens mais recentes", "Acompanhe por aqui", "Aju Fest", "fas fa-calendar-alt"];

        return view('web.blog.lista', compact(
            'pagina',
            'posts',
            'categoria',
            'categorias',
            'top',
            'f_q',
            'tit',
            'view'
        ));
    }

    public function promocao(Request $request, \App\Models\CategoriaPost $categoria = null){
        $f_q = $request->f_q;
        $view = \Request::route()->getName();

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'noticias')->firstOrFail();
            
        $posts = \App\Models\Post::where('situacao', '=', '1')
            ->where('categoria_id', '=', '2')
            ->where(function ($query) use ($f_q) {
                $qs = explode(' ', $f_q);
                $query->where('nome', 'like', '%' . $f_q . '%');
                foreach ($qs as $q) {
                    $query->orWhere('nome', 'like', '%' . $q . '%');
                    $query->orWhere('texto', 'like', '%' . $q . '%');
                }

                return $query;
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $categorias = \App\Models\CategoriaPost::where('situacao', '=', '1')
            ->whereNull('categoria_id')
            ->orderBy('ordem', 'asc')
            ->orderBy('nome', 'asc');

        $top = \App\Models\Post::where('situacao', '=', '1')
            ->where('categoria_id', '=', '2')
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->orderBy('nome', 'desc')
            ->limit(15);

        $tit = ["Promoções", "Fique antendado em nossas promoções", "fas fa-calendar-alt"];

        return view('web.blog.lista', compact(
            'pagina',
            'posts',
            'categoria',
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
     * @param  \App\Model\Post $post
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, \App\Models\Post $post)
    {
        $view = \Request::route()->getName();
        $view = str_replace(["web.",".id","blog.promocao"],["","","Promoção"],$view);

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'noticias')->firstOrFail();

        $categorias = \App\Models\CategoriaPost::select('categorias_posts.*')
            ->where('situacao', '=', '1')->whereNull('categoria_id')
            ->orderBy('ordem', 'asc')->orderBy('nome', 'asc');

        $categoria = $post->categoria;

        $top = \App\Models\Post::select('posts.*')
            ->where('situacao', '=', '1')
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->orderBy('nome', 'desc')
            ->limit(15);

        if ($post) {
            $post->views += 1;
            $post->save();
        }

        return view('web.blog.ver', compact(
            'pagina',
            'post',
            'categoria',
            'categorias',
            'top',
            'view'
        ));
    }
}
