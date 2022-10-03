<?php

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Gestor\Util;

class CurriculoController extends Controller
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
            $curriculos = \App\Models\Curriculo::select('curriculos.*')
                    ->leftJoin('vagas', 'curriculos.vaga_id', '=', 'vagas.id')
                    ->where('curriculos.nome', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.cpf', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.rg', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.email', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.telefone', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.cargo', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.experiencia', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.formacao', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.qualificacao', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.cursos', 'like', '%' . $f_p . '%')
                    ->orWhere('curriculos.idiomas', 'like', '%' . $f_p . '%')
                    ->orWhere('vagas.nome', 'like', '%' . $f_p . '%')
                    ->orderBy('curriculos.updated_at', 'desc')
                    ->paginate(15);
        } else {
            $curriculos = \App\Models\Curriculo::orderBy('updated_at', 'desc')->paginate(15);
        }

        return view('gestor.curriculos.lista', compact('curriculos', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $curriculo = new \App\Models\Curriculo;
        $s_estados = \App\Models\Estado::orderBy('nome', 'asc')->get();
        $s_vagas = \App\Models\Vaga::orderBy('nome', 'asc')->get();

        return view('gestor.curriculos.edita', compact('curriculo', 's_estados', 's_vagas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curriculo = new \App\Models\Curriculo;

        $validator = $this->valid($request, $curriculo);
        if ($validator->fails()) {
            return redirect()->route('gestor.curriculos.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $curriculo->nome = $request->f_nome;
        $curriculo->cpf = $request->f_cpf;
        $curriculo->rg = $request->f_rg;
        $curriculo->nascimento = $request->f_nascimento;
        $curriculo->sexo = $request->f_sexo;
        $curriculo->estado_civil = $request->f_estado_civil;
        $curriculo->email = $request->f_email;
        $curriculo->telefone = $request->f_telefone;
        $curriculo->endereco = $request->f_endereco;
        $curriculo->numero = $request->f_numero;
        $curriculo->complemento = $request->f_complemento;
        $curriculo->bairro = $request->f_bairro;
        $curriculo->cep = $request->f_cep;
        $curriculo->cargo = $request->f_cargo;
        $curriculo->experiencia = $request->f_experiencia;
        $curriculo->formacao = $request->f_formacao;
        $curriculo->qualificacao = $request->f_qualificacao;
        $curriculo->cursos = $request->f_cursos;
        $curriculo->idiomas = $request->f_idiomas;
        $curriculo->salario = $request->f_salario;
        $curriculo->situacao = $request->f_situacao;
        $curriculo->cidade_id = $request->f_cidade;
        $curriculo->vaga_id = $request->f_vaga;
        $curriculo->foto = $request->f_foto;
        $curriculo->password = Hash::make($request->f_password);
        $curriculo->save();

        return redirect()->route('gestor.curriculos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $curriculo)
    {
        $rule = [
            'f_nome' => 'required|max:250',
            'f_cpf' => 'required|max:50|cpf|unique:curriculos,cpf' . ($curriculo->id ? ',' . $curriculo->id : ''),
            'f_rg' => 'required|max:50',
            'f_nascimento' => 'required|date_format:"d/m/Y"',
            'f_sexo' => 'required|numeric',
            'f_estado_civil' => 'required|numeric',
            'f_email' => 'required|email|max:250|unique:curriculos,email' . ($curriculo->id ? ',' . $curriculo->id : ''),
            'f_telefone' => 'required|max:250',
            'f_endereco' => 'required|max:250',
            'f_numero' => 'required|max:50',
            'f_complemento' => 'nullable|max:100',
            'f_bairro' => 'required|max:100',
            'f_cep' => 'required|max:50',
            'f_estado' => 'required|numeric',
            'f_cidade' => 'required|numeric',
            'f_situacao' => 'required|numeric',
            'foto' => 'mimetypes:jpg,png,gif,jpeg,bmp'
        ];

        if ($request->f_password) {
            $rule['f_password'] = 'required|confirmed|min:3|max:100';
        }

        $validator = validator($request->all(), $rule);

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
        return redirect()->route('gestor.curriculos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curriculo = \App\Models\Curriculo::findOrFail($id);
        $s_estados = \App\Models\Estado::orderBy('nome', 'asc')->get();
        $s_vagas = \App\Models\Vaga::orderBy('nome', 'asc')->get();

        return view('gestor.curriculos.edita', compact('curriculo', 's_estados', 's_vagas'));
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
        $curriculo = \App\Models\Curriculo::findOrFail($id);

        $validator = $this->valid($request, $curriculo);
        if ($validator->fails()) {
            return redirect()->route('gestor.curriculos.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $curriculo->nome = $request->f_nome;
        $curriculo->cpf = $request->f_cpf;
        $curriculo->rg = $request->f_rg;
        $curriculo->nascimento = $request->f_nascimento;
        $curriculo->sexo = $request->f_sexo;
        $curriculo->estado_civil = $request->f_estado_civil;
        $curriculo->email = $request->f_email;
        $curriculo->telefone = $request->f_telefone;
        $curriculo->endereco = $request->f_endereco;
        $curriculo->numero = $request->f_numero;
        $curriculo->complemento = $request->f_complemento;
        $curriculo->bairro = $request->f_bairro;
        $curriculo->cep = $request->f_cep;
        $curriculo->cargo = $request->f_cargo;
        $curriculo->experiencia = $request->f_experiencia;
        $curriculo->formacao = $request->f_formacao;
        $curriculo->qualificacao = $request->f_qualificacao;
        $curriculo->cursos = $request->f_cursos;
        $curriculo->idiomas = $request->f_idiomas;
        $curriculo->salario = $request->f_salario;
        $curriculo->situacao = $request->f_situacao;
        $curriculo->cidade_id = $request->f_cidade;
        $curriculo->vaga_id = $request->f_vaga;
        $curriculo->foto = $request->f_foto;

        if ($request->f_password && ($request->f_password == $request->f_password_confirmation)) {
            $curriculo->password = Hash::make($request->f_password);
        }
        $curriculo->save();

        return redirect()->route('gestor.curriculos.index')
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
        $curriculo = \App\Models\Curriculo::findOrFail($id);
        $curriculo->delete();

        return redirect()->route('gestor.curriculos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

    public function getPDF($id)
    {
        $curriculo = \App\Models\Curriculo::findOrFail($id);

        $pdf = \PDF::loadView('gestor.curriculos.pdf', compact('curriculo'));
        $pdf->setPaper('P', 'Portrait');
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(277, 732, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream();
        //return $pdf->download('contrato-' . $curriculo->id . '.pdf');
    }


    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 public function uploadDelete(Request $request, \App\Models\Curriculo $curriculo)
 {
     if ($request->nome == "foto") {
         if ($curriculo->foto) {
             Storage::disk($curriculo->uploadifyImages['foto']['disk'])->delete($curriculo->uploadifyImages['foto']['path'] . 'w_50/' . $curriculo->foto);
             $curriculo->foto->delete();

             $curriculo->foto = null;
             $curriculo->save();

             return response()->json(['ok']);
         }
     }

     return response()->json([]);
 }

 /**
  * Display a listing of the resource.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function upload(Request $request, \App\Models\Curriculo $curriculo)
 {
     if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
         return $this->uploadArquivo($request, $curriculo);
     }

     return response()->json(['error' => 'Erro ao enviar']);
 }

 public function uploadArquivo(Request $request, \App\Models\Curriculo $curriculo)
 {
     $ret = [];

     $validator = $this->valid($request, $curriculo);

     if ($curriculo->foto) {
         Storage::disk($curriculo->uploadifyImages['foto']['disk'])->delete($curriculo->uploadifyImages['foto']['path'] . 'w_50/' . $curriculo->foto);
         $curriculo->foto->delete();
     }

     $name = "foto-" . $curriculo->id . "-" . uniqid(date('YmdHis'));
     $extension = $request->foto->extension();
     $nameFile = "{$name}.{$extension}";

     Util::resize($request->file('foto'), 1600, 650);

     $upload = $request->foto->storeAs($curriculo->uploadifyImages['foto']['path'], $nameFile, $curriculo->uploadifyImages['foto']);

     Util::resize($request->file('foto'), 50, 50);

     $upload = $request->foto->storeAs($curriculo->uploadifyImages['foto']['path'] . 'w_50/', $nameFile, $curriculo->uploadifyImages['foto']);

     if (!$upload) {
         $ret['error'] = 'Erro ao enviar';
     } else {
         $curriculo->foto = $nameFile;
         $curriculo->save();

         $html = view('gestor.curriculos.foto', compact('curriculo'))->render();
         return response()->json(['html' => $html]);
     }

     return response()->json($ret);
 }

}
