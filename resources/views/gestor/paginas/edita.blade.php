@extends('layouts.gestor.app')

@if($pagina->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_pagina.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_pagina.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_pagina.titulo')
            @if($pagina->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST"
    action="{{ ($pagina->id ? route('gestor.paginas.update', $pagina->id) : route('gestor.paginas.store')) }}">
    @if($pagina->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_pagina.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_pagina.nome')</label>
                        <input name="f_nome" id="f_nome" type="text"
                            value="{{ (old('f_nome') ? old('f_nome') : $pagina->nome) }}"
                            class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250"
                            placeholder="@lang('gestor_pagina.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_pagina.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom"
                            title="@lang('gestor_pagina.situacao')">
                            <option value="">@lang('gestor_pagina.situacao')</option>
                            @foreach($pagina->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}"
                                {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $pagina->situacao) ? ' selected' : '' }}>
                                {{ $sit_v[0] }}</option>
                            @endforeach
                        </select>
                        @error('f_situacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_link" class="form-control-label">* @lang('gestor_pagina.link')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ url('') . '/' }}</div>
                            </div>
                            <input name="f_link" id="f_link" type="text"
                                value="{{ (old('f_link') ? old('f_link') : $pagina->link) }}"
                                class="form-control bg-light text-dark normatize @error('f_link') is-invalid @enderror"
                                maxlength="250" placeholder="@lang('gestor_pagina.link')" data-ref="f_link">
                        </div>
                        @error('f_link')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_video" class="form-control-label">@lang('gestor.url_video') <small>(@lang('gestor.video_small'))</small></label>
                        <input name="f_video" id="f_video" type="text"
                            value="{{ (old('f_video') ? old('f_video') : $pagina->video) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor.url_video')">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_descricao" class="form-control-label">@lang('gestor_pagina.descricao')</label>
                        <input name="f_descricao" id="f_descricao" type="text"
                            value="{{ (old('f_descricao') ? old('f_descricao') : $pagina->descricao) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_pagina.descricao')">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label class="form-control-label">@lang('gestor_pagina.emails')</label>
                        <div id="emails" class="clones list-group">
                            @if(old('f_email'))
                            @foreach(old('f_email') as $email_k => $email)
                            @include('gestor.paginas.email')
                            @endforeach
                            @else
                            @foreach($pagina->present()->emails as $email_k => $email)
                            @include('gestor.paginas.email')
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_pagina.informacoes_texto')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-auto">
                        <label for="f_texto_full" class="form-control-label">* @lang('gestor_pagina.texto_full')</label>
                        <select name="f_texto_full" id="f_texto_full" class="form-control selectpicker-custom"
                            title="@lang('gestor_pagina.texto_full')">
                            <option value="">@lang('gestor_pagina.texto_full')</option>
                            @foreach($pagina->present()->makeTextoFullAll as $tex_f_k => $tex_f_v)
                            <option value="{{ $tex_f_k }}" data-icon="fa-{{ $tex_f_v[1] }}"
                                {{ $tex_f_k == (old('f_texto_full') ? old('f_texto_full') : $pagina->texto_full) ? ' selected' : '' }}>
                                {{ $tex_f_v[0] }}</option>
                            @endforeach
                        </select>
                        @error('f_texto_full')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_texto" class="form-control-label">@lang('gestor_pagina.texto')</label>
                        <div class="view-responsive">
                            <div class="btn-group btn-block pb-1" role="group" aria-label="">
                                <button type="button" class="smart btn btn-outline-dark"><span class="fas fa-mobile-alt"></span> Smartphone</button>
                                <button type="button" class="tablet btn btn-outline-dark"><span class="fas fa-tablet-alt"></span> Tablet</button>
                                <button type="button" class="desk active btn btn-outline-dark"><span class="fas fa-desktop"></span> Desktop</button>
                            </div>
                            <textarea name="f_texto" id="f_texto" class="mx-auto form-control tinymce" rows="10"
                                placeholder="@lang('gestor_pagina.texto')">{{ (old('f_texto') ? old('f_texto') : $pagina->texto) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_pagina.informacoes_seo')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label class="form-control-label">@lang('gestor_pagina.seo_keywords')</label>
                        <div id="seo_keywords" class="clones list-group">
                            @if(old('f_seo_keyword'))
                            @foreach(old('f_seo_keyword') as $seo_keyword_k => $seo_keyword)
                            @include('gestor.paginas.seo_keyword')
                            @endforeach
                            @else
                            @foreach($pagina->present()->seoKeywords as $seo_keyword_k => $seo_keyword)
                            @include('gestor.paginas.seo_keyword')
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_seo_description"
                            class="form-control-label">@lang('gestor_pagina.seo_description')</label>
                        <div class="input-group">
                            <textarea name="f_seo_description" id="f_seo_description" class="form-control maxlength"
                                maxlength="150"
                                placeholder="@lang('gestor_pagina.seo_description')">{{ (old('f_seo_description') ? old('f_seo_description') : $pagina->seo_description) }}</textarea>
                            <div class="input-group-append">
                                <div class="input-group-text content-countdown"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($pagina->id)
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_pagina.fotos_pagina')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md py-2">
                        <div class="upload-anexos" data-up-tipo="foto" data-up-link="paginas-anexos"
                            data-up-id="{{ $pagina->id }}" data-up-nome="foto" data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @if($pagina->anexos)
                                @foreach($pagina->anexos->where('tipo', 1)->sortBy('ordem') as $anexo)
                                @include('gestor.paginas.foto')
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_pagina.anexos_pagina')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md py-2">
                        <div class="upload-anexos" data-up-tipo="arquivo" data-up-link="paginas-anexos"
                            data-up-id="{{ $pagina->id }}" data-up-nome="arquivo" data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @if($pagina->anexos)
                                @foreach($pagina->anexos->where('tipo', 2)->sortBy('ordem') as $anexo)
                                @include('gestor.paginas.arquivo')
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span>
            @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
