@extends('layouts.gestor.publica')

@section('title', __('gestor_dashboard.register'))

@section('content')
<div id="login">
    <form class="form-horizontal auth-form my-4" method="POST" action="{{ route('gestor.register', ['next' => $next]) }}">
        @csrf

        @if (session('alert'))
        @alert(['type' => session('alert')['type']])
        {!! session('alert')['message'] !!}
        @endalert
        @endif

        <p class="alert alert-success"><strong><i class="dripicons-information mr-1" style="vertical-align: sub;"></i> Nós te daremos 15 dias de avaliação gratuita</strong></p>
        <div class="form-row">
            <div class="form-group w-100 mb-1">
                <label for="f_nome">* Nome</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-user"></i>
                    </span>
                    <input required name="f_nome" value="{{old('f_nome')}}" type="text" id="f_nome" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="Digite seu nome" />
                </div>
                @error('f_nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_email">* @lang('gestor_dashboard.email')</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-card"></i>
                    </span>
                    <input required name="f_email" value="{{old('f_email')}}" type="email" id="f_email" class="form-control @error('f_email') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_dashboard.title_email')">
                </div>
                @error('f_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_telefone">* Telefone/Celular</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-phone"></i>
                    </span>
                    <input name="f_telefone" required value="{{old('f_telefone')}}" type="text" id="f_telefone" class="form-control masktelefone @error('f_telefone') is-invalid @enderror" maxlength="250" placeholder="Informe seu celular ou telefone" />
                </div>
                @error('f_telefone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_dt_nasc">* Data de Nascimento</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-calendar"></i>
                    </span>
                    <input name="f_dt_nasc" required value="{{old('f_dt_nasc')}}" type="text" id="f_dt_nasc" class="form-control maskdate @error('f_dt_nasc') is-invalid @enderror" maxlength="250" placeholder="Informe sua data de nascimento" />
                </div>
                @error('f_dt_nasc')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_cpf">* CPF</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-card"></i>
                    </span>
                    <input name="f_cpf" required value="{{old('f_cpf')}}" type="text" id="f_cpf" class="form-control maskcpf @error('f_cpf') is-invalid @enderror" maxlength="250" placeholder="Informe seu CPF" />
                </div>
                @error('f_cpf')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_rg">* RG</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-card"></i>
                    </span>
                    <input name="f_rg" required value="{{old('f_rg')}}" type="text" id="f_rg" class="form-control @error('f_rg') is-invalid @enderror" maxlength="250" placeholder="Informe seu RG" />
                </div>
                @error('f_rg')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_cep">* CEP</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-map"></i>
                    </span>
                    <input name="f_cep" value="{{old('f_cep')}}" required type="text" id="f_cep" class="form-control maskcep @error('f_cep') is-invalid @enderror" maxlength="10" placeholder="Informe seu CEP" />
                    <input name="f_rua" value="{{old('f_rua')}}" type="hidden" id="f_rua" />
                    <input name="f_bairro" value="{{old('f_bairro')}}" type="hidden" id="f_bairro" />
                    <input name="f_cidade" value="{{old('f_cidade')}}" type="hidden" id="f_cidade" />
                    <input name="f_uf" value="{{old('f_uf')}}" type="hidden" id="f_uf" />
                </div>
                <div id="endereco" class="mb-2 px-3"></div>
                @error('f_cep')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_numero">* Número</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-location"></i>
                    </span>
                    <input name="f_numero" value="{{old('f_numero')}}" required type="text" id="f_numero" class="form-control @error('f_numero') is-invalid @enderror" maxlength="10" placeholder="Informe seu Número de Endereço" />
                </div>
                @error('f_numero')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_usuario" class="form-control-label">* Login</label>
                <div class="input-group mb-3">
                    <span class="auth-form-icon">
                        <i class="dripicons-user"></i>
                    </span>
                    <input name="f_usuario" value="{{old('f_usuario')}}" required id="f_usuario" type="text" class="form-control @error('f_usuario') is-invalid @enderror" maxlength="250" placeholder="Digite seu login" />
                </div>
                @error('f_usuario')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_password_new" class="form-control-label">* Senha</label>
                <div class="input-group mb-3">
                    <input name="f_password" required value="{{old('f_password')}}" id="f_password" type="password" value="" class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="Informe uma senha" />

                    <div class="input-group-append">
                        <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')/@lang('gestor.hide')" type="button"><span class="fas fa-eye"></span></button>
                    </div>
                </div>
                @error('f_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group w-100 mb-1">
                <label for="f_password_confirmation" class="form-control-label">* Repetir a senha</label>
                <div class="input-group mb-3">
                    <input name="f_password_confirmation" value="{{old('f_password_confirmation')}}" required id="f_password_confirmation" type="password" value="" class="form-control @error('f_password_confirmation') is-invalid @enderror" maxlength="100" placeholder="Repita a senha acima" />
                    <div class="input-group-append">
                        <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')/@lang('gestor.hide')" type="button"><span class="fas fa-eye"></span></button>
                    </div>
                </div>
                @error('f_password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="dripicons-user mr-1" style="vertical-align: sub;"></i> Cadastrar</button>
        <a href="{{ route('gestor.login', ['next' => $next]) }}" class="btn btn-sm btn-block"><span class="fas fa-chevron-left"></span> @lang('gestor_dashboard.voltar')</a>
    </form>
</div>

<script>
    let cep = document.getElementById("f_cep");

    cep.addEventListener('blur', function (evt) {
        pesquisacep(this.value);
    });

    function limpa_formulário_cep() {
        document.getElementById('endereco').innerHTML = '';
        document.getElementById('f_rua').value = '';
        document.getElementById('f_bairro').value = '';
        document.getElementById('f_cidade').value = '';
        document.getElementById('f_uf').value = '';
    }

    function cepCallback(conteudo) {
        if (!("erro" in conteudo)) {
            let endereco = "Seu endereço é: "+conteudo.logradouro+', '+conteudo.bairro+', '+conteudo.localidade+', '+conteudo.uf;
            document.getElementById('endereco').innerHTML = endereco;
            document.getElementById('f_rua').value = conteudo.logradouro;
            document.getElementById('f_bairro').value = conteudo.bairro;
            document.getElementById('f_cidade').value = conteudo.localidade;
            document.getElementById('f_uf').value = conteudo.uf;
        }else {
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                document.getElementById('endereco').innerHTML = "...";
                document.getElementById('f_rua').value = "...";
                document.getElementById('f_bairro').value = "...";
                document.getElementById('f_cidade').value = "...";
                document.getElementById('f_uf').value = "...";

                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=cepCallback';
                document.body.appendChild(script);
            }
            else {
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        }
        else {
            limpa_formulário_cep();
        }
    };
    </script>
@endsection
