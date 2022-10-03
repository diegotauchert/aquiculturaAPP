@extends('layouts.gestor.app')

@if($download->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_download.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_download.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_download.titulo')
            @if($download->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($download->id ? route('gestor.downloads.update', $download->id) : route('gestor.downloads.store')) }}">
    @if($download->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_download.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_download.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $download->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_download.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_download.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_download.situacao')">
                            <option value="">@lang('gestor_download.situacao')</option>
                            @foreach($download->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $download->situacao) ? ' selected' : '' }}>{{ $sit_v[0] }}</option>
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
                    <div class="form-group col-sm">
                        <label for="f_link" class="form-control-label">@lang('gestor_download.link')</label>
                        <input name="f_link" id="f_link" type="url" value="{{ (old('f_link') ? old('f_link') : $download->link) }}" class="form-control" maxlength="250" placeholder="@lang('gestor_download.link')">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header h5">@lang('gestor_download.descricao')</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md">
                                <div class="view-responsive">
                                    <div class="btn-group btn-block pb-1" role="group" aria-label="">
                                        <button type="button" class="smart btn btn-outline-dark"><span class="fas fa-mobile-alt"></span> Smartphone</button>
                                        <button type="button" class="tablet btn btn-outline-dark"><span class="fas fa-tablet-alt"></span> Tablet</button>
                                        <button type="button" class="desk active btn btn-outline-dark"><span class="fas fa-desktop"></span> Desktop</button>
                                    </div>
                                    <textarea name="f_descricao" id="f_descricao" class="form-control tinymce" rows="10" placeholder="@lang('gestor_download.p_descricao')">{{ (old('f_descricao') ? old('f_descricao') : $download->descricao) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($download->id)
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_download.arquivo_download')</div>
            <div class="card-body">
                <div class="upload-anexos-unique" data-up-tipo="arquivo" data-up-link="downloads" data-up-id="{{ $download->id }}" data-up-nome="arquivo" data-up-class="col-md-4 my-auto py-3">
                    <div class="list-group uploads pb-2"></div>
                    <div class="files-itens files-ordem row pt-2">
                        @include('gestor.downloads.arquivo')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
