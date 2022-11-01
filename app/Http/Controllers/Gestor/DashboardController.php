<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Gestor\Util;
use DB;

class DashboardController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produtos = null;
        $clientesAtivos = null;
        $clientesInativos = null;
        $clientesTeste = null;

        $logs = \App\Models\UsuarioLog::with('usuario')->where('situacao', '=', '1')->orderBy('id', 'desc')->paginate(30);

        if(auth('gestor')->user()->cliente_id){
            $logs = $logs->where('usuario.cliente_id', auth('gestor')->user()->cliente_id);
        }
        if(auth('gestor')->user()->fazenda_id){
            $logs = $logs->where('usuario.fazenda_id', auth('gestor')->user()->fazenda_id);
        }

        $producao = \App\Models\Producao::where('cliente_id', auth('gestor')->user()->cliente_id)->orderBy("id", "DESC")->limit(12)->get();

        if(auth('gestor')->user()->fazenda_id){
            $producao = $producao->where('p.fazenda_id', auth('gestor')->user()->fazenda_id);
        }

        if(auth('gestor')->user()->tipo == 4){
            $produtos = \App\Models\Produto::where('cliente_id', auth('gestor')->user()->cliente_id)
                                            ->where('quantidade', '<=', DB::raw('minimo'))
                                            ->get();
        }

        if(auth('gestor')->user()->tipo <= 3){
            $clientesAtivos = \App\Models\Cliente::where('situacao', "1")->count();
            $clientesInativos = \App\Models\Cliente::where('situacao', "2")->count();
            $clientesTeste = \App\Models\Cliente::where('externo', "1")->where('situacao', "1")->count();
        }

        return view('gestor.dashboard.lista', compact('logs', 'producao', 'produtos', 'clientesAtivos', 'clientesInativos', 'clientesTeste'));
    }
}
