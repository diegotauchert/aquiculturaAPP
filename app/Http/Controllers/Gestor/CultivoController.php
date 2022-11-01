<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Hash;

class CultivoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:gestor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $f_p = $request->f_p;
        $f_categoria = $request->f_categoria;

        if ($f_p) {
            $cultivos = \App\Models\Cultivo::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('tipo', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_total', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_unitario', 'like', '%' . $f_p . '%')
                    ->orWhere('quantidade', 'like', '%' . $f_p . '%')
                    ->orWhere('minimo', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        } else {
            $cultivos = \App\Models\Cultivo::where('cliente_id', auth('gestor')->user()->cliente_id)->orderBy('id', 'desc')->paginate(10);
        }

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.cultivos.lista', compact('cultivos', 'cliente', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cultivo = new \App\Models\Cultivo;

        return view('gestor.cultivos.edita', compact('cultivo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cultivo = new \App\Models\Cultivo;

        $validator = $this->valid($request, $cultivo);
        if ($validator->fails()) {
            return redirect()->route('gestor.cultivos.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $cultivo->nome = $request->f_nome;
        $cultivo->categoria_id = $request->f_categoria;
        $cultivo->tipo = $request->f_tipo;
        $cultivo->biometria = $request->f_biometria;
        $cultivo->adensamento = $request->f_adensamento;
        $cultivo->peso = $request->f_peso;
        $cultivo->peso_2 = $request->f_peso_2;
        $cultivo->detalhes = $request->f_detalhes;
        $cultivo->situacao = $request->f_situacao;
        
        if($request->f_povoado){
            $povoado = Carbon::createFromFormat('d/m/Y', $request->f_povoado)->format('Y-m-d H:i:s');
            $cultivo->povoado = $povoado;
        }

        if($request->f_despesca){
            $despesca = Carbon::createFromFormat('d/m/Y', $request->f_despesca)->format('Y-m-d H:i:s');
            $cultivo->despesca = $despesca;
        }

        $cultivo->save();

        return redirect()->route('gestor.cultivos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_categoria' => 'required|numeric',
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric'
        ]);

        return $validator;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('gestor.cultivos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cultivo = \App\Models\Cultivo::findOrFail($id);

        return view('gestor.cultivos.edita', compact('cultivo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cultivo = \App\Models\Cultivo::findOrFail($id);

        $validator = $this->valid($request, $cultivo);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.cultivos.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $cultivo->nome = $request->f_nome;
        $cultivo->categoria_id = $request->f_categoria;
        $cultivo->tipo = $request->f_tipo;
        $cultivo->biometria = $request->f_biometria;
        $cultivo->adensamento = $request->f_adensamento;
        $cultivo->peso = $request->f_peso;
        $cultivo->peso_2 = $request->f_peso_2;
        $cultivo->detalhes = $request->f_detalhes;
        $cultivo->situacao = $request->f_situacao;

        if($request->f_inativar == 1){
            $cultivo->situacao = 3;
        }
        
        if($request->f_povoado){
            $povoado = Carbon::createFromFormat('d/m/Y', $request->f_povoado)->format('Y-m-d H:i:s');
            $cultivo->povoado = $povoado;
        }

        if($request->f_despesca){
            $despesca = Carbon::createFromFormat('d/m/Y', $request->f_despesca)->format('Y-m-d H:i:s');
            $cultivo->despesca = $despesca;
        }

        $cultivo->save();

        return redirect()->route('gestor.cultivos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro alterado com sucesso!'
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cultivo = \App\Models\Cultivo::findOrFail($id);
        $cultivo->delete();

        return redirect()->route('gestor.cultivos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

    public function reportStatusJSON(){
        $cultivos = \App\Models\Cultivo::select("situacao")
            ->where('cliente_id', auth('gestor')->user()->cliente_id)
            ->orderBy('situacao', 'ASC')
            ->get()
            ->toArray();

        if(count($cultivos) > 0){
            for($i =0; $i < count($cultivos); $i++){
                $cultivos[$i]["classificacao"] = $this->classificaStatus($cultivos[$i]["situacao"]);
            }
        }

        return Response::json($cultivos);
    }

    public function classificaStatus($status){
        $classificacao = "";
        switch($status){
            case ($status == 1):
                $classificacao = "Produzindo";
                break;
            case ($status == 2):
                $classificacao = "Manutenção";
                break;
            case ($status == 3):
                $classificacao = "Entre Ciclo";
                break;
        }

        return $classificacao;
    }
}