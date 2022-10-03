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
                <h2 style="font-size:24px;">Nos envie seu currículo</h2>
                <p class="resume text-gray"><small>@lang('web_contato.titulo')</small></p>
                <hr />
                <form method="POST" action="{{ route('web.contato.send') }}">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="f_nome"><h2 style="font-size:14px;">* @lang('web_contato.nome')</h2></label>
                            <input name="f_nome" id="f_nome" class="form-control @error('f_nome') is-invalid @enderror" type="text" value="{{ old('f_nome') }}" placeholder="@lang('web_contato.nome')">
                            @error('f_nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md">
                            <label for="f_endereco"><h2 style="font-size:14px;">* Endereço</h2></label>
                            <input name="f_endereco" id="f_endereco" class="form-control @error('f_endereco') is-invalid @enderror" type="text" value="{{ old('f_endereco') }}" placeholder="Informe seu endereço">
                            @error('f_endereco')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 col-lg-6">
                            <label for="f_telefone"><h2 style="font-size:14px;">* @lang('web_contato.telefone')</h2></label>
                            <input name="f_telefone" id="f_telefone" class="form-control masktelefone @error('f_telefone') is-invalid @enderror" type="tel" value="{{ old('f_telefone') }}" placeholder="@lang('web_contato.telefone')">
                            @error('f_telefone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 col-lg-6">
                            <label for="f_email"><h2 style="font-size:14px;">* @lang('web_contato.email')</h2></label>
                            <input name="f_email" id="f_email" class="form-control @error('f_email') is-invalid @enderror" type="email" value="{{ old('f_email') }}" placeholder="@lang('web_contato.email')">
                            @error('f_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12 col-lg-6">
                            <label for="f_dt_nasc"><h2 style="font-size:14px;">* Data de Nascimento</h2></label>
                            <input name="f_dt_nasc" id="f_dt_nasc" class="form-control maskdata @error('f_dt_nasc') is-invalid @enderror" type="text" value="{{ old('f_dt_nasc') }}" placeholder="Informe sua data de nascimento">
                            @error('f_dt_nasc')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 col-lg-6">
                            <label for="f_curriculo"><h2 style="font-size:14px;">* Currículo</h2></label>
                            <input name="f_curriculo" id="f_curriculo" class="form-control @error('f_curriculo') is-invalid @enderror" type="file" value="{{ old('f_curriculo') }}" placeholder="Envie seu currículo" />
                            @error('f_curriculo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row radio-form">
                        <div class="form-group col-md-12 col-lg-6">
                            <label for="possui_camera"><h2 style="font-size:14px;">* Possui Câmera?</h2></label>
                            <div class="d-flex gap-2">
                                <div class="d-flex">
                                    <input name="possui_camera" id="possui_camera_sim" class="form-control" type="radio" value="Sim" checked />
                                    <label for="possui_camera_sim" class="text-white"><strong>Sim</strong></label>
                                </div>
                                <div class="d-flex">
                                    <input name="possui_camera" id="possui_camera_nao" class="form-control" type="radio" value="Não" />
                                    <label for="possui_camera_nao" class="text-white"><strong>Não</strong></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-lg-6">
                            <label for="atividade"><h2 style="font-size:14px;">* Atividades?</h2></label>
                            <div class="d-flex gap-2">
                                <div class="d-flex">
                                    <input name="atividade" id="atividade_1" class="form-control" type="radio" value="Fotógrafo" checked />
                                    <label for="atividade_1" class="text-white"><strong>Fotógrafo</strong></label>
                                </div>
                                <div class="d-flex">
                                    <input name="atividade" id="atividade_2" class="form-control" type="radio" value="Jornalista" />
                                    <label for="atividade_2" class="text-white"><strong>Jornalista</strong></label>
                                </div>
                                <div class="d-flex">
                                    <input name="atividade" id="atividade_3" class="form-control" type="radio" value="Vendedor" />
                                    <label for="atividade_3" class="text-white"><strong>Vendedor</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row mb-4">
                        <div class="form-group col-md">
                            <label for="f_mensagem"><h2 style="font-size:14px;">Observação</h2></label>
                            <textarea name="f_mensagem" id="f_mensagem" class="form-control @error('f_mensagem') is-invalid @enderror" rows="6" placeholder="@lang('web_contato.mensagem')">Informe alguma dúvida ou sugestão</textarea>
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
