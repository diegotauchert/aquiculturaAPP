@extends('layouts.web.app')

@section('title', $pagina->nome)

@section('seo_keyword')
@if($pagina->seo_keyword)
<meta name="keywords" content="{{ $pagina->seo_keyword }}">
@else
@parent
@endif
@stop
@section('seo_description')
@if($pagina->seo_description)
<meta name="description" content="{{ $pagina->seo_description }}">
@else
@parent
@endif
@stop

@section('content')

<div class="wrapper" id="contato">
    <div class="row">
        <div class="container-fluid p-0">
            <div class="col-xs-12 col-sm-12 col-md-12 tits p-0 mx-3">
                <h2>{{ $pagina->nome }}</h2>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row">
            <div id="fale-conosco" class="col-md-12 py-3">
                @if (session('alert'))
                @web_alert(['type' => session('alert')['type']])
                {!! session('alert')['message'] !!}
                @endweb_alert
                @endif
                <h2 style="font-size:24px;">Informações Pessoais</h2>
                <p class="resume text-gray"><small>@lang('web_contato.titulo')</small></p>
                <hr />
                <form method="POST" action="{{ route('web.contato.send') }}">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_nome"><h2 style="font-size:14px;">* @lang('web_contato.nome')</h2></label>
                            <input name="f_nome" id="f_nome" class="form-control @error('f_nome') is-invalid @enderror" type="text" value="{{ old('f_nome') }}" placeholder="@lang('web_contato.nome')">
                            @error('f_nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_telefone"><h2 style="font-size:14px;">* @lang('web_contato.telefone')</h2></label>
                            <input name="f_telefone" id="f_telefone" class="form-control masktelefone @error('f_telefone') is-invalid @enderror" type="tel" value="{{ old('f_telefone') }}" placeholder="@lang('web_contato.telefone')">
                            @error('f_telefone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_email"><h2 style="font-size:14px;">* @lang('web_contato.email')</h2></label>
                            <input name="f_email" id="f_email" class="form-control @error('f_email') is-invalid @enderror" type="email" value="{{ old('f_email') }}" placeholder="@lang('web_contato.email')">
                            @error('f_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <br />
                    <br />
                    <h2 style="font-size:24px;">Informações do Evento</h2>
                    <hr />
                    <div class="form-row">
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_nome_evento"><h2 style="font-size:14px;">* Nome do Evento</h2></label>
                            <input name="f_nome_evento" id="f_nome_evento" class="form-control @error('f_nome_evento') is-invalid @enderror" type="text" value="{{ old('f_nome_evento') }}" placeholder="@lang('web_contato.nome')">
                            @error('f_nome_evento')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_endereco"><h2 style="font-size:14px;">* Endereço</h2></label>
                            <input name="f_endereco" id="f_endereco" class="form-control @error('f_endereco') is-invalid @enderror" type="text" value="{{ old('f_endereco') }}" placeholder="Informe o endereço do evento" />
                            @error('f_endereco')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_cidade"><h2 style="font-size:14px;">* Cidade</h2></label>
                            <input name="f_cidade" id="f_cidade" class="form-control @error('f_cidade') is-invalid @enderror" type="text" value="{{ old('f_cidade') }}" placeholder="Informe a cidade">
                            @error('f_cidade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_descricao"><h2 style="font-size:14px;">Descrição</h2></label>
                            <textarea name="f_descricao" id="f_descricao" class="form-control @error('f_descricao') is-invalid @enderror" rows="6" placeholder="Informe a descrição completa do evento"></textarea>
                            @error('f_descricao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_atracoes"><h2 style="font-size:14px;">Atrações</h2></label>
                            <textarea name="f_atracoes" id="f_atracoes" class="form-control @error('f_atracoes') is-invalid @enderror" rows="6" placeholder="Informe aqui as atrações"></textarea>
                            @error('f_atracoes')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="f_valores"><h2 style="font-size:14px;">Valores</h2></label>
                            <textarea name="f_valores" id="f_valores" class="form-control @error('f_valores') is-invalid @enderror" rows="6" placeholder="Informe os valores"></textarea>
                            @error('f_valores')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12 col-lg-6">
                            <label for="f_imagem"><h2 style="font-size:14px;">* Imagem do Evento / Cartaz</h2></label>
                            <input name="f_imagem" id="f_imagem" class="form-control @error('f_imagem') is-invalid @enderror" type="file" value="{{ old('f_imagem') }}" placeholder="Envie seu currículo" />
                            @error('f_imagem')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-row mb-4">
                        <div class="form-group col-md">
                            <label for="f_mensagem"><h2 style="font-size:14px;">Observação</h2></label>
                            <textarea name="f_mensagem" id="f_mensagem" class="form-control @error('f_mensagem') is-invalid @enderror" rows="6" placeholder="Informe alguma dúvida ou sugestão"></textarea>
                            @error('f_mensagem')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="container-fluid text-center">
                        <button class="btn-main btn-small w-auto px-5" type="submit"><i class="fas fa-envelope"></i> @lang('web.enviar')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('web.home.promocoes')
</div>

@include('web.home.newsletter')
@endsection