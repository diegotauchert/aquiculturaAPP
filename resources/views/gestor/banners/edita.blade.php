@extends('layouts.gestor.app')

@if($banner->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_banner.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_banner.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_banner.titulo')
            @if($banner->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST"
    action="{{ ($banner->id ? route('gestor.banners.update', $banner->id) : route('gestor.banners.store')) }}">
    @if($banner->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_banner.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_categoria_id" class="form-control-label">@lang('gestor_post.categoria')</label>
                        <select name="f_categoria_id" id="f_categoria_id" class="form-control selectpicker-custom" title="@lang('gestor_post.categoria')">
                            <option value="" disabled>@lang('gestor_post.categoria')</option>
                            @foreach($s_categorias as $s_categoria)
                            <option value="{{ $s_categoria->id }}" {{ $s_categoria->id == (old('f_categoria_id') ? old('f_categoria_id') : $banner->categoria_id) ? ' selected' : '' }}>
                                {{ $s_categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_banner.nome')</label>
                        <input name="f_nome" id="f_nome" type="text"
                            value="{{ (old('f_nome') ? old('f_nome') : $banner->nome) }}"
                            class="form-control @error('f_nome') is-invalid @enderror" maxlength="250"
                            placeholder="@lang('gestor_banner.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_categoria" class="form-control-label">@lang('gestor_banner.categoria')</label>
                        <input name="f_categoria" id="f_categoria" type="text" maxlength="50"
                            value="{{ (old('f_categoria') ? old('f_categoria') : $banner->categoria) }}"
                            class="form-control @error('f_categoria') is-invalid @enderror" 
                            placeholder="@lang('gestor_banner.categoria')">
                        @error('f_categoria')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_banner.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom"
                            title="@lang('gestor_banner.situacao')">
                            <option value="">@lang('gestor_banner.situacao')</option>
                            @foreach($banner->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}"
                                {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $banner->situacao) ? ' selected' : '' }}>
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
                        <label for="f_link" class="form-control-label">@lang('gestor_banner.link')</label>
                        <input name="f_link" id="f_link" type="text"
                            value="{{ (old('f_link') ? old('f_link') : $banner->link) }}"
                            class="form-control @error('f_link') is-invalid @enderror"
                            placeholder="@lang('gestor_banner.link')">
                        @error('f_link')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_video" class="form-control-label">@lang('gestor_banner.video')</label>
                        <input name="f_video" id="f_video" type="text"
                            value="{{ (old('f_video') ? old('f_video') : $banner->video) }}"
                            class="form-control @error('f_video') is-invalid @enderror"
                            placeholder="@lang('gestor_banner.video')">
                        @error('f_video')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_ordem" class="form-control-label">@lang('gestor_banner.ordem')</label>
                        <input name="f_ordem" id="f_ordem" type="number" min="0"
                            value="{{ (old('f_ordem') ? old('f_ordem') : $banner->ordem) }}"
                            class="form-control @error('f_ordem') is-invalid @enderror"
                            placeholder="@lang('gestor_banner.ordem')">
                        @error('f_ordem')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_tipo" class="form-control-label">* @lang('gestor_banner.tipo')</label>
                        <select name="f_tipo" id="f_tipo" class="form-control selectpicker-custom"
                            title="@lang('gestor_banner.tipo')">
                            <option value="">@lang('gestor_banner.tipo')</option>
                            @foreach($banner->present()->makeTipoAll as $tip_k => $tip_v)
                            <option value="{{ $tip_k }}" data-icon="fa-{{ $tip_v }}"
                                {{ $tip_k == (old('f_tipo') ? old('f_tipo') : $banner->tipo) ? ' selected' : '' }}>
                                {{ $tip_v }}</option>
                            @endforeach
                        </select>
                        @error('f_tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_dt_inicio" class="form-control-label">@lang('gestor_banner.dt_inicio')</label>
                        <div class="input-group">
                            <input name="f_dt_inicio" id="f_dt_inicio" type="text"
                                value="{{ (old('f_dt_inicio') ? old('f_dt_inicio') : ($banner->dt_inicio ? $banner->dt_inicio->format('d/m/Y') : '')) }}"
                                class="form-control maskdata @error('f_dt_inicio') is-invalid @enderror"
                                placeholder="@lang('gestor_banner.dt_inicio')">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                            </div>
                        </div>
                        @error('f_dt_inicio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_dt_fim" class="form-control-label">@lang('gestor_banner.dt_fim')</label>
                        <div class="input-group">
                            <input name="f_dt_fim" id="f_dt_fim" type="text"
                                value="{{ (old('f_dt_fim') ? old('f_dt_fim') : ($banner->dt_fim ? $banner->dt_fim->format('d/m/Y') : '')) }}"
                                class="form-control maskdata @error('f_dt_fim') is-invalid @enderror"
                                placeholder="@lang('gestor_banner.dt_fim')">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                            </div>
                        </div>
                        @error('f_dt_fim')
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
            <div class="card-header h5">@lang('gestor_banner.informacoes_texto')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_texto" class="form-control-label">@lang('gestor_banner.texto')</label>
                        <div class="view-responsive">
                            <div class="btn-group btn-block pb-1" role="group" aria-label="">
                                <button type="button" class="smart btn btn-outline-dark"><span
                                        class="fas fa-mobile-alt"></span> Smartphone</button>
                                <button type="button" class="tablet btn btn-outline-dark"><span
                                        class="fas fa-tablet-alt"></span> Tablet</button>
                                <button type="button" class="desk active btn btn-outline-dark"><span
                                        class="fas fa-desktop"></span> Desktop</button>
                            </div>
                            <textarea name="f_texto" id="f_texto" class="form-control tinymce" rows="10"
                                placeholder="@lang('gestor_banner.texto')">{{ (old('f_texto') ? old('f_texto') : $banner->texto) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($banner->id)
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_banner.arquivos_banner')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md py-2">
                        <p class="h5">@lang('gestor_banner.arquivo') <span
                                class="badge badge-secondary">@lang('gestor_banner.arquivo_prop')</span></p>
                        <div class="upload-anexos-unique" data-up-tipo="foto" data-up-link="banners"
                            data-up-id="{{ $banner->id }}" data-up-nome="arquivo" data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @include('gestor.banners.arquivo')
                            </div>
                        </div>
                    </div>
                    <div class="col-md py-2">
                        <p class="h5">@lang('gestor_banner.responsivo') <span
                                class="badge badge-secondary">@lang('gestor_banner.responsivo_prop')</span></p>
                        <div class="upload-anexos-unique" data-up-tipo="foto" data-up-link="banners"
                            data-up-id="{{ $banner->id }}" data-up-nome="responsivo"
                            data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @include('gestor.banners.responsivo')
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
