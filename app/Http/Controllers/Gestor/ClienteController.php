<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
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
        $f_p = $request->f_p;

        if ($f_p) {
            $clientes = \App\Models\Cliente::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('texto', 'like', '%' . $f_p . '%')
                    ->orWhere('email', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $clientes = \App\Models\Cliente::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.clientes.lista', compact('clientes', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = new \App\Models\Cliente;

        $s_categorias = \App\Models\CategoriaCliente::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();
        $usuario = null;

        return view('gestor.clientes.edita', compact('cliente', 'usuario', 's_categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userIsNotAvailable = \App\Models\Usuario::where('login', '=', strtolower($request->f_usuario))->first();

        if ($userIsNotAvailable) {
            return redirect()->route('gestor.clientes.create')
                            ->with('alert', [
                                'type' => 'danger',
                                'message' => 'O Usuário já existe no sistema. Tente com outro login'
                            ]);
        }

        $cliente = new \App\Models\Cliente;

        $validator = $this->valid($request, $cliente);
        if ($validator->fails()) {
            return redirect()->route('gestor.clientes.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $cliente->nome = $request->f_nome;
        $cliente->email = $request->f_email;
        $cliente->telefone = $request->f_telefone;
        $cliente->cpf = $request->f_cpf;
        $cliente->rg = $request->f_rg;
        $cliente->orgao = $request->f_orgao;
        $cliente->uf = $request->f_uf;
        $cliente->cep = $request->f_cep;
        $cliente->endereco = $request->f_endereco;
        $cliente->numero = $request->f_numero;
        $cliente->bairro = $request->f_bairro;
        $cliente->cidade = $request->f_cidade;
        $cliente->estado = $request->f_estado;
        $cliente->complemento = $request->f_complemento;
        $cliente->plano = $request->f_plano;
        $cliente->fazendas = $request->f_fazendas;
        $cliente->valor = $request->f_valor;
        
        $cliente->obs = $request->f_texto;
        $cliente->situacao = $request->f_situacao;

        if($request->f_validade){
            $validade = Carbon::createFromFormat('d/m/Y', $request->f_validade)->format('Y-m-d H:i:s');
            $cliente->validade = $validade;
        }
        
        if($request->f_data){
            $data = Carbon::createFromFormat('d/m/Y', $request->f_data)->format('Y-m-d H:i:s');
            $cliente->dt_nasc = $data;
        }
        $cliente->categoria_id = $request->f_categoria;

        $isSaved = $cliente->save();

        if($isSaved){
            $this->saveUsuario($cliente, $request);
        }

        return redirect()->route('gestor.clientes.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            // 'f_fazendas' => 'required|numeric',
            'f_usuario' => 'required|max:250',
            'f_password' => 'required|confirmed|min:3|max:250',
            'f_password_confirmation' => 'required|min:3|max:250',
            'f_data' => 'date_format:"d/m/Y"|nullable'
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
        return redirect()->route('gestor.clientes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = \App\Models\Cliente::findOrFail($id);
        $usuario = \App\Models\Usuario::where('cliente_id', '=', $id)->first();

        $s_categorias = \App\Models\CategoriaCliente::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();

        return view('gestor.clientes.edita', compact('cliente', 'usuario', 's_categorias'));
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
        $cliente = \App\Models\Cliente::findOrFail($id);

        $validator = $this->valid($request, $cliente);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.clientes.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $cliente->nome = $request->f_nome;
        $cliente->email = $request->f_email;
        $cliente->telefone = $request->f_telefone;
        $cliente->cpf = $request->f_cpf;
        $cliente->rg = $request->f_rg;
        $cliente->orgao = $request->f_orgao;
        $cliente->uf = $request->f_uf;
        $cliente->cep = $request->f_cep;
        $cliente->endereco = $request->f_endereco;
        $cliente->numero = $request->f_numero;
        $cliente->bairro = $request->f_bairro;
        $cliente->cidade = $request->f_cidade;
        $cliente->estado = $request->f_estado;
        $cliente->complemento = $request->f_complemento;
        $cliente->plano = $request->f_plano;
        $cliente->fazendas = $request->f_fazendas;
        $cliente->valor = $request->f_valor;
        $cliente->categoria_id = $request->f_categoria;
        
        $cliente->obs = $request->f_texto;
        $cliente->situacao = $request->f_situacao;

        if($request->f_validade){
            $validade = Carbon::createFromFormat('d/m/Y', $request->f_validade)->format('Y-m-d H:i:s');
            $cliente->validade = $validade;
        }
        
        if($request->f_data){
            $data = Carbon::createFromFormat('d/m/Y', $request->f_data)->format('Y-m-d H:i:s');
            $cliente->dt_nasc = $data;
        }

        $isSaved = $cliente->save();

        // if($isSaved){
        //     $this->saveUsuario($cliente, $request);
        // }

        return redirect()->route('gestor.clientes.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro alterado com sucesso!'
        ]);
    }

    public function anexos(Request $request, $cliente)
    {
        if ($request->f_foto) {
            if (count($request->f_foto['descricao']) > 0) {
                $k = 0;
                foreach ($request->f_foto['descricao'] as $k => $descricao) {
                    $anexo = \App\Models\ClienteAnexo::find($request->f_foto['codigo'][$k]);
                    $anexo->descricao = $descricao;
                    $anexo->ordem = $k + 1;
                    $anexo->save();
                }
            }
        }

        if ($request->f_arquivo) {
            if (count($request->f_arquivo['descricao']) > 0) {
                $k = 0;
                foreach ($request->f_arquivo['descricao'] as $k => $descricao) {
                    $anexo = \App\Models\ClienteAnexo::find($request->f_arquivo['codigo'][$k]);
                    $anexo->descricao = $descricao;
                    $anexo->ordem = $k + 1;
                    $anexo->save();
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = \App\Models\Cliente::findOrFail($id);
        $cliente->delete();

        $usuario = \App\Models\Usuario::where('cliente_id', '=', $id)->first();

        if($usuario){
            $usuario->delete();
        }

        return redirect()->route('gestor.clientes.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

    public function saveUsuario(\App\Models\Cliente $cliente, Request $request)
    {
        $usuario = new \App\Models\Usuario;

        if ($request->f_password == $request->f_password_confirmation) {
            $usuario->password = Hash::make($request->f_password);
        }

        $usuario->password_decoded = $request->f_password;
        $usuario->nome = $cliente->nome;
        $usuario->login = $request->f_usuario;
        $usuario->cliente_id = $cliente->id;
        $usuario->email = $cliente->email ?? 'admin-'.uniqid().'@gmail.com';
        $usuario->tipo = 4;
        $usuario->situacao = 1;

        $usuario->save();
    }
}
