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
            <div id="fale-conosco" class="col-md-6 py-3">
                @if (session('alert'))
                @web_alert(['type' => session('alert')['type']])
                {!! session('alert')['message'] !!}
                @endweb_alert
                @endif
                <h2 style="font-size:24px;">@lang('web_contato.preencha')</h2>
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
                    
                    <div class="form-row mb-4">
                        <div class="form-group col-md">
                            <label for="f_mensagem"><h2 style="font-size:14px;">@lang('web_contato.mensagem')</h2></label>
                            <textarea name="f_mensagem" id="f_mensagem" class="form-control @error('f_mensagem') is-invalid @enderror" rows="6" placeholder="@lang('web_contato.mensagem')">{{ old('f_mensagem') }}</textarea>
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
            <div class="col col-md-4 ml-auto py-3" id="informacoes-contato">
                <h2 style="font-size:24px;">@lang('web_contato.titulo2')</h2>
                {!! $pagina->texto !!}

                @if(ModelConfig::find('html_telefone')->valor)
                <div class="col-md-12 col-lg pt-3">
                    <i class="text-white fas fa-phone"></i>
                    <strong>{!! ModelConfig::find('html_telefone')->valor ?? '' !!}</strong>
                </div>
                @endif

                @if(ModelConfig::find('html_email')->valor)
                <div class="col-md-12 col-lg pt-3">
                    <i class="text-white fas fa-envelope"></i>
                    <strong>{!! ModelConfig::find('html_email')->valor ?? '' !!}</strong>
                </div>
                @endif

                @if(ModelConfig::find('html_endereco')->valor)
                <div class="col-md-12 col-lg pt-3">
                    <i class="text-white fas fa-map-marker-alt"></i>
                    <strong>{!! ModelConfig::find('html_endereco')->valor ?? '' !!}</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
    @include('web.home.promocoes')
</div>

@include('web.home.newsletter')
@endsection
