<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Gestor\Util;

class TrabalheRegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth:gestor', 'auth.unique.user']);
        //$this->middleware('auth');
    }

    protected function guard()
    {
        return Auth::guard('trabalhe');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $next = $request->next;

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'trabalhe')->firstOrFail();

        $vagas = \App\Models\Vaga::where('situacao', '=', '1')
                ->orderBy('nome', 'asc');

        $curriculo = auth()->guard('trabalhe')->user();

        if (!$curriculo) {
            $curriculo = new \App\Models\Curriculo;
        }

        return view('web.trabalhe.register', compact('pagina', 'vagas', 'next', 'curriculo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerPost(Request $request)
    {
        if (auth('trabalhe')->user()) {
            $curriculo = auth('trabalhe')->user();

            $validator = $this->validRegister($request, $curriculo);

            if ($validator->fails()) {
                return redirect()->route('web.trabalhe.register', ['next' => $request->next])
                                ->withErrors($validator)
                                ->withInput();
            }

            return $this->updateRegister($request, $curriculo);
        }

        $curriculo = new \App\Models\Curriculo;

        $validator = $this->validRegister($request, $curriculo);
        if ($validator->fails()) {
            return redirect()->route('web.trabalhe.register', ['next' => $request->next])
                            ->withErrors($validator)
                            ->withInput();
        }

        return $this->storeRegister($request, $curriculo);
    }

    public function updateRegister(Request $request, $curriculo)
    {
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
        $curriculo->cidade_id = $request->f_cidade;
        $curriculo->vaga_id = $request->f_vaga;
        $curriculo->save();

        return redirect()->route('web.trabalhe.register', ['next' => $request->next])
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Currículo atualizado com sucesso!'
        ]);
    }

    public function storeRegister(Request $request, $curriculo)
    {
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
        $curriculo->cidade_id = $request->f_cidade;
        $curriculo->vaga_id = $request->f_vaga;
        $curriculo->situacao = 1;

        if ($request->f_password == $request->f_password_confirmation) {
            $curriculo->password = Hash::make($request->f_password);
        }
        $curriculo->save();

        auth('trabalhe')->login($curriculo);

        return redirect()->route('web.trabalhe.register', ['next' => $request->next])
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Currículo incluído com sucesso!'
        ]);
    }

    public function validRegister(Request $request, $curriculo)
    {
        if($curriculo->id){
            $id = $curriculo->id;
        }else{
            $id = "NULL";
        }

        $rule = [
            'f_nome' => 'required|max:250',
            'f_cpf' => 'required|max:50|cpf|unique:curriculos,cpf,'.$id.',id,deleted_at,NULL',
            'f_rg' => 'required|max:50',
            'f_nascimento' => 'required|date_format:"d/m/Y"',
            'f_sexo' => 'required|numeric',
            'f_estado_civil' => 'required|numeric',
            'f_email' => 'required|email|max:250|unique:curriculos,email,'.$id.',id,deleted_at,NULL',
            'f_telefone' => 'required|max:250',
            'f_endereco' => 'required|max:250',
            'f_numero' => 'required|max:50',
            'f_complemento' => 'nullable|max:100',
            'f_bairro' => 'required|max:100',
            'f_cep' => 'required|max:50',
            'f_estado' => 'required|numeric',
            'f_cidade' => 'required|numeric',
            'foto' => 'mimes:jpg,png,gif,jpeg,bmp'
        ];

        if (!$curriculo->id) {
            $rule['f_password'] = 'required|confirmed|min:5|max:100';
        }

        $validator = validator($request->all(), $rule);

        return $validator;
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

        $validator = $this->validRegister($request, $curriculo);

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

            $html = view('web.trabalhe.foto', compact('curriculo'))->render();
            return response()->json(['html' => $html]);
        }

        return response()->json($ret);
    }
}
