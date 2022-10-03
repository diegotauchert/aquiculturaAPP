<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CidadeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware(['auth:gestor', 'auth.unique.user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        if (isset($id)) {
            $cidades = \App\Models\Cidade::where('estado_id', '=', $id)
                    ->orderBy('nome', 'asc')
                    ->get();
        } else {
            $cidades = \App\Models\Cidade::get();
        }

        return response()->json($cidades)
                        ->withCallback($request->input('callback'));
    }

}
