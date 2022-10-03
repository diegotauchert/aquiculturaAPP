<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Indicador;

class IndicadorController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'indicador')->firstOrFail();

        return view('web.indicador', compact('pagina'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $validator = $this->valid($request);
        if ($validator->fails()) {
            return redirect()->route('web.indicador')
                ->withErrors($validator)
                ->withInput();
        }

        $indicador = new \App\Models\Indicador;

        try {
            //dd($request->all());
            $this->storeRegister($request, $indicador);

            //Mail::send(new Indicador($request, $pagina));

        } catch (\Exception $e) {

            return redirect()->route('web.home')->with('alert', [
                'type' => 'danger',
                'message' => 'Desculpe tente novamente mais tarde!'
            ]);
        }

        if (request()->segment(1) == "indicador") {
            return redirect()->route('web.indicador')->with('alert', [
                'type' => 'success',
                'message' => 'Sua mensagem foi enviada com sucesso!'
            ]);
        }
        if (request()->segment(1) == "recomendador") {
            return redirect()->route('web.recomendador')->with('alert', [
                'type' => 'success',
                'message' => 'Sua mensagem foi enviada com sucesso!'
            ]);
        }
        if (request()->segment(1) == "recommender") {
            return redirect()->route('web.recommender')->with('alert', [
                'type' => 'success',
                'message' => 'Sua mensagem foi enviada com sucesso!'
            ]);
        }
    }

    public function storeRegister(Request $request, $indicador)
    {
        $indicador->nome = $request->f_nome;
        $indicador->endereco = $request->f_endereco;
        $indicador->email = $request->f_email;
        $indicador->telefone = $request->f_telefone;
        $indicador->whatsapp = $request->f_whatsapp;
        $indicador->conheceu = $request->f_conheceu;
        $indicador->equipamento = $request->f_equipamento;
        $indicador->mensagem = $request->f_mensagem;
        $indicador->cidade_id = $request->f_cidade;
        $indicador->situacao = 2;

        $indicador->save();
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_telefone' => 'required',
            'f_email' => 'required|email',
            'f_equipamento' => 'required|numeric',
            'f_cidade' => 'required|numeric',
            'f_estado' => 'required|numeric'
        ]);

        return $validator;
    }
}
