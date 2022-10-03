<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Contato;

class ContatoController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'contato')->firstOrFail();

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

        return view('web.contato.form', compact('pagina', 'promocao', 'video'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send(\Illuminate\Http\Request $request)
    {
        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'contato')->first();

        if (!$pagina) {
            return redirect()->route('web.home');
        }

        $validator = $this->valid($request);
        if ($validator->fails()) {
            return redirect()->route('web.contato')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Mail::send(new Contato($request, $pagina));
        } catch (\Exception $e) {
            return redirect()->route('web.contato')->with('alert', [
                'type' => 'danger',
                'message' => 'Desculpe tente novamente mais tarde! <br />'.$e->getMessage()
            ]);
        }

        return redirect()->route('web.contato')->with('alert', [
            'type' => 'success',
            'message' => 'Sua mensagem foi enviada com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_telefone' => 'required',
            'f_email' => 'required|email',
            'f_estado' => 'required|numeric',
            'f_cidade' => 'required|numeric',
        ]);

        return $validator;
    }
}
