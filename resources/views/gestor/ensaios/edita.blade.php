@extends('layouts.gestor.app')

@if($post->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_post.ensaio'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_post.ensaio'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_post.ensaio')
            @if($post->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($post->id ? route('gestor.ensaios.update', $post->id) : route('gestor.ensaios.store')) }}">
    @if($post->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_post.informacoes_ensaio')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_categoria" class="form-control-label">@lang('gestor_post.categoria')</label>
                        <select name="f_categoria" id="f_categoria" class="form-control selectpicker-custom" title="@lang('gestor_post.categoria')">
                            <option value="" disabled>@lang('gestor_post.categoria')</option>
                            @foreach($s_categorias as $s_categoria)
                            <option value="{{ $s_categoria->id }}" {{ $s_categoria->id == (old('f_categoria') ? old('f_categoria') : $post->categoria_id) ? ' selected' : '' }}>
                                {{ $s_categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_post.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" required value="{{ (old('f_nome') ? old('f_nome') : $post->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_post.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_local" class="form-control-label">@lang('gestor_post.local')</label>
                        <input name="f_local" id="f_local" type="text" value="{{ (old('f_local') ? old('f_local') : $post->local) }}" class="form-control normatize @error('f_local') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_post.local')">
                        @error('f_local')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_autor" class="form-control-label">@lang('gestor_post.autor')</small></label>
                        <input name="f_autor" id="f_autor" type="text"
                            value="{{ (old('f_autor') ? old('f_autor') : $post->autor) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_post.autor')">
                        @error('f_autor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_video" class="form-control-label">@lang('gestor.url_video') <small>(@lang('gestor.video_small'))</small></label>
                        <input name="f_video" id="f_video" type="text"
                            value="{{ (old('f_video') ? old('f_video') : $post->video) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor.url_video')">
                    </div>
                    <div class="form-group col-md">
                        <label for="f_instagram" class="form-control-label">@lang('gestor_post.instagram')</label>
                        <input name="f_instagram" id="f_instagram" type="text" value="{{ (old('f_instagram') ? old('f_instagram') : $post->instagram) }}" class="form-control normatize @error('f_instagram') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_post.instagram')">
                        @error('f_instagram')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-a">
                        <label for="f_data" class="form-control-label">* @lang('gestor_post.data')</label>
                        <div class="input-group">
                            <input name="f_data" id="f_data" type="text" required value="{{ (old('f_data') ? old('f_data') : ($post->data ? $post->data->format('d/m/Y') : '')) }}" class="form-control maskdata @error('f_data') is-invalid @enderror" placeholder="@lang('gestor_post.data')" />
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                            </div>
                            <input name="f_hora" id="f_hora" type="text" required value="{{ (old('f_hora') ? old('f_hora') : ($post->data ? $post->data->format('H:i:s') : '')) }}" class="form-control maskhora @error('f_hora') is-invalid @enderror" placeholder="@lang('gestor_post.hora')">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-clock"></span></div>
                            </div>
                        </div>
                        @error('f_data')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @error('f_hora')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_post.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_post.situacao')">
                            <option value="">@lang('gestor_post.situacao')</option>
                            @foreach($post->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $post->situacao) ? ' selected' : '' }}>
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
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_post.informacoes_texto_ensaio')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <div class="view-responsive">
                            <div class="btn-group btn-block pb-1" role="group" aria-label="">
                                <button type="button" class="smart btn btn-outline-dark"><span class="fas fa-mobile-alt"></span> Smartphone</button>
                                <button type="button" class="tablet btn btn-outline-dark"><span class="fas fa-tablet-alt"></span> Tablet</button>
                                <button type="button" class="desk active btn btn-outline-dark"><span class="fas fa-desktop"></span> Desktop</button>
                            </div>
                            <label for="f_texto" class="form-control-label">@lang('gestor_post.texto')</label>
                            <textarea name="f_texto" id="f_texto" class="form-control tinymce" rows="10" placeholder="@lang('gestor_post.texto')">{{ (old('f_texto') ? old('f_texto') : $post->texto) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_post.informacoes_seo_ensaio')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label class="form-control-label">@lang('gestor_post.seo_keywords')</label>
                        <div id="seo_keywords" class="clones list-group">
                            @if(old('f_seo_keyword'))
                            @foreach(old('f_seo_keyword') as $seo_keyword_k => $seo_keyword)
                            @include('gestor.ensaios.seo_keyword')
                            @endforeach
                            @else
                            @if($post->present()->seoKeywords)
                            @foreach($post->present()->seoKeywords as $seo_keyword_k => $seo_keyword)
                            @include('gestor.ensaios.seo_keyword')
                            @endforeach
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_seo_description" class="form-control-label">@lang('gestor_post.seo_description')</label>
                        <div class="input-group">
                            <textarea name="f_seo_description" id="f_seo_description" class="form-control maxlength" maxlength="150" placeholder="@lang('gestor_post.seo_description')">{{ (old('f_seo_description') ? old('f_seo_description') : $post->seo_description) }}</textarea>
                            <div class="input-group-append">
                                <div class="input-group-text content-countdown"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($post->id)
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_post.fotos_ensaio')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md py-2">
                        <div class="upload-anexos" data-up-tipo="foto" data-up-link="ensaios-anexos" data-up-id="{{ $post->id }}" data-up-nome="foto" data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @if($post->anexos)
                                @foreach($post->anexos->where('tipo', 1)->sortBy('ordem') as $anexo)
                                @include('gestor.ensaios.foto')
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
            <div class="card-header h5">@lang('gestor_post.anexos_ensaio')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md py-2">
                        <div class="upload-anexos" data-up-tipo="arquivo" data-up-link="ensaios-anexos" data-up-id="{{ $post->id }}" data-up-nome="arquivo" data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @if($post->anexos)
                                @foreach($post->anexos->where('tipo', 2)->sortBy('ordem') as $anexo)
                                @include('gestor.ensaios.arquivo')
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
