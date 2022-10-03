<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepoimentoController extends Controller
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
    public function index(Request $request)
    {
        $f_q = $request->f_q;

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'testimonials')->firstOrFail();

        $depoimentos = \App\Models\Depoimento::select('depoimentos.*')
            ->where('situacao', '=', '1')
            ->orderBy('id', 'desc')
            ->where(function ($query) use ($f_q) {
                $qs = explode(' ', $f_q);

                $query->where('depoimentos.nome', 'like', '%' . $f_q . '%');

                foreach ($qs as $q) {
                    $query->orWhere('depoimentos.nome', 'like', '%' . $q . '%');
                    $query->orWhere('depoimentos.descricao', 'like', '%' . $q . '%');
                }

                return $query;
            })
            ->paginate(15);

        return view('web.depoimentos.lista', compact(
            'pagina',
            'depoimentos',
            'f_q'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Depoimento $depoimento
     * @return \Illuminate\Http\Response
     */
    public function depoimento(Request $request, \App\Models\Depoimento $depoimento)
    {
        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'testimonials')->firstOrFail();

        return view('web.depoimentos.ver', compact(
            'pagina',
            'depoimento'
        ));
    }
}
