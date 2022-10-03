<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popups = \App\Models\Banner::select('banners.*')
            ->where('situacao', '=', '1')->where('tipo', '=', '1')
            ->where(function ($query) {
                return $query->whereRaw('? between dt_inicio and dt_fim', [date('Y-m-d')])
                    ->orWhere(function ($query) {
                        return $query->whereNull('dt_inicio')->whereNull('dt_fim');
                    });
            })->orderBy('ordem', 'asc')->orderBy('nome', 'asc');

        $banners = \App\Models\Banner::select('banners.*')
            ->where('banners.tipo', '=', '2')
            ->where('banners.situacao', '=', '1')
            ->where(function ($query) {
                $query->whereNotNull('banners.arquivo')
                      ->orWhereNotNull('banners.responsivo');
            })
            ->where(function ($query) {
                return $query->whereRaw('? between dt_inicio and dt_fim', [date('Y-m-d')])
                    ->orWhere(function ($query) {
                        return $query->whereNull('dt_inicio')->whereNull('dt_fim');
                    });
            })->orderBy('ordem', 'asc')->orderBy('nome', 'asc')->limit(5);


        $posts = \App\Models\Post::select('posts.*')
            ->where('posts.situacao', '=', '1')
            ->where('posts.categoria_id', 1)
            ->where('data', '<=', \Carbon\Carbon::now())
            ->orderBy('posts.data', 'desc')
            ->limit(4);
    
        $agendas = \App\Models\Agenda::where('situacao', '=', '1')
            // ->where('data', '>=', \Carbon\Carbon::now())
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit(8);

        $coberturas = \App\Models\Cobertura::where('situacao', '=', '1')
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit(2);

        $colunistas = \App\Models\Colunista::where('situacao', '=', '1')
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit(3);
        
        $promocao = \App\Models\Post::select('posts.*')
            ->where('posts.situacao', '=', '1')
            ->where('posts.categoria_id', 2)
            // ->where('data', '<=', \Carbon\Carbon::now())
            ->orderBy('posts.data', 'desc')
            ->limit(1);
        
        $video = \App\Models\Video::where('situacao', '=', '1')
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit(1);

        return view('web.home.lista', compact('popups', 'banners', 'posts', 'agendas', 'coberturas', 'colunistas', 'promocao', 'video'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Pagina $pagina
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, \App\Models\Pagina $pagina)
    {
        $promocao = \App\Models\Post::select('posts.*')
            ->where('posts.situacao', '=', '1')
            ->where('posts.categoria_id', 2)
            // ->where('data', '<=', \Carbon\Carbon::now())
            ->orderBy('posts.data', 'desc')
            ->limit(1);
        
        $video = \App\Models\Video::where('situacao', '=', '1')
            ->orderBy('data', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit(1);

        return view('web.pagina.lista', compact('pagina', 'promocao', 'video'));
    }
}
