<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
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
            $menus = \App\Models\Menu::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('link', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        } else {
            $menus = \App\Models\Menu::orderBy('id', 'desc')->paginate(10);
        }

        return view('gestor.menus.lista', compact('menus', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = new \App\Models\Menu;
        $s_menus = \App\Models\Menu::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();
        
        return view('gestor.menus.edita', compact('menu', 's_menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = new \App\Models\Menu;

        $validator = $this->valid($request, $menu);
        if ($validator->fails()) {
            return redirect()->route('gestor.menus.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $menu->nome = $request->f_nome;
        $menu->link = $request->f_link;
        $menu->situacao = $request->f_situacao;
        $menu->exibe = $request->f_exibe;
        $menu->ordem = $request->f_ordem;
        $menu->menu_id = $request->f_menu;
        $menu->save();

        return redirect()->route('gestor.menus.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $menu)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            'f_exibe' => 'required|numeric',
            'f_ordem' => 'nullable|numeric',
            'f_link' => 'required|max:250',
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
        return redirect()->route('gestor.menus.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        $s_menus = \App\Models\Menu::where('id', '<>', $id)
                        ->where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();
        return view('gestor.menus.edita', compact('menu', 's_menus'));
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
        $menu = \App\Models\Menu::findOrFail($id);

        $validator = $this->valid($request, $menu);
        if ($validator->fails()) {
            return redirect()->route('gestor.menus.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $menu->nome = $request->f_nome;
        $menu->link = $request->f_link;
        $menu->situacao = $request->f_situacao;
        $menu->exibe = $request->f_exibe;
        $menu->ordem = $request->f_ordem;
        $menu->menu_id = $request->f_menu;
        $menu->save();
        
        return redirect()->route('gestor.menus.index')
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
        $menu = \App\Models\Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('gestor.menus.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

}
