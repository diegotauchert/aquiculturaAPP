<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class InteressadoController extends Controller
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
    public function create(Request $request)
    {
        // dd($request);

        $interessado = new \App\Models\Interessado;

        $validator = $this->valid($request);
        if ($validator->fails()) {
            return redirect()->route('web.home')
                            ->withErrors($validator)
                            ->withInput();
        }

        $interessado->nome = $request->f_nome;
        $interessado->email = $request->f_email;
        // $interessado->telefone = " ";
        // $interessado->obs = " ";
        $interessado->situacao = 1;
        $interessado->save();

        // $this->emails($request, $interessado);

        return redirect()->route('web.home')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_email' => 'required|email|unique:interessados,email',
        ]);

        return $validator;
    }
}
