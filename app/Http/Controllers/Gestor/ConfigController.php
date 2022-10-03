<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
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
        $configs = \App\Models\Config::all();

        return view('gestor.configs.form', compact('configs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->valid($request);
        if ($validator->fails()) {
            return redirect()->route('gestor.configs.index')
                            ->withErrors($validator)->withInput();
        }

        foreach ($request->f_conf as $id => $valor) {
            $config = \App\Models\Config::find($id);

            if (!$config) {
                $config = new \App\Models\Config(['id' => $id]);
            }

            if ($id == 'seo_keyword') {
                $this->storeSEO($config, $valor);
            } else {
                $config->valor = $valor;
                $config->save();
            }
        }

        return redirect()->route('gestor.configs.index')->with('alert', [
            'type' => 'success', 'message' => 'Configurações alterado com sucesso!'
        ]);
    }

    public function storeSEO($config, $valor)
    {
        $config->resetSEOKeywordAttribute();

        foreach ($valor as $key) {
            $config->setSEOKeywordAttribute($key);
        }
        
        $config->save();
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
//            'f_valor' => 'required|max:250',
//            'f_config' => 'required|unique:configs,id',
        ]);

        return $validator;
    }

}
