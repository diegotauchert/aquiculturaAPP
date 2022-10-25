<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Gestor\Util;

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
        $logs = \App\Models\UsuarioLog::with('usuario')->where('situacao', '=', '1')->orderBy('id', 'desc')->paginate(30);
        if(auth('gestor')->user()->cliente_id){
            $logs = $logs->where('usuario.cliente_id', auth('gestor')->user()->cliente_id);
        }
        if(auth('gestor')->user()->fazenda_id){
            $logs = $logs->where('usuario.fazenda_id', auth('gestor')->user()->fazenda_id);
        }

        $producao = \App\Models\Producao::where('cliente_id', auth('gestor')->user()->cliente_id)->get();

        if(auth('gestor')->user()->fazenda_id){
            $producao = $producao->where('p.fazenda_id', auth('gestor')->user()->fazenda_id);
        }

        return view('gestor.dashboard.lista', compact('logs', 'producao'));
    }
}
