@extends('layouts.gestor.app')

@if($depoimento->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_depoimento.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_depoimento.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_depoimento.titulo')
            @if($depoimento->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST"
    action="{{ ($depoimento->id ? route('gestor.depoimentos.update', $depoimento->id) : route('gestor.depoimentos.store')) }}">
    @if($depoimento->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_depoimento.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_depoimento.nome')</label>
                        <input name="f_nome" id="f_nome" type="text"
                            value="{{ (old('f_nome') ? old('f_nome') : $depoimento->nome) }}"
                            class="form-control @error('f_nome') is-invalid @enderror" maxlength="250"
                            placeholder="@lang('gestor_depoimento.p_nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_depoimento.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom"
                            title="@lang('gestor_depoimento.situacao')">
                            <option value="">@lang('gestor_depoimento.situacao')</option>
                            @foreach($depoimento->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}"
                                {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $depoimento->situacao) ? ' selected' : '' }}>
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
                        <label for="f_nota" class="form-control-label">@lang('gestor_depoimento.nota')</label>
                        <input name="f_nota" id="f_nota" type="text" maxlength="1"
                            value="{{ (old('f_nota') || $depoimento->nota) ? ((old('f_nota') ? old('f_nota') : $depoimento->nota)) : '5' }}"
                            class="form-control nota @error('f_nota') is-invalid @enderror" min="1" max="5" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                            placeholder="@lang('gestor_depoimento.nota')">
                        <small>@lang('gestor_depoimento.p_nota')</small>
                        @error('f_nota')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_ordem" class="form-control-label">@lang('gestor_depoimento.ordem')</label>
                        <input name="f_ordem" id="f_ordem" type="number" min="0"
                            value="{{ (old('f_ordem') ? old('f_ordem') : $depoimento->ordem) }}"
                            class="form-control @error('f_ordem') is-invalid @enderror"
                            placeholder="@lang('gestor_depoimento.ordem')">
                        @error('f_ordem')
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
            <div class="card-header h5">@lang('gestor_depoimento.informacoes_texto')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_descricao" class="form-control-label">@lang('gestor_depoimento.descricao')</label>
                        <div class="view-responsive">
                            <div class="btn-group btn-block pb-1" role="group" aria-label="">
                                <button type="button" class="smart btn btn-outline-dark"><span
                                        class="fas fa-mobile-alt"></span> Smartphone</button>
                                <button type="button" class="tablet btn btn-outline-dark"><span
                                        class="fas fa-tablet-alt"></span> Tablet</button>
                                <button type="button" class="desk active btn btn-outline-dark"><span
                                        class="fas fa-desktop"></span> Desktop</button>
                            </div>
                            <textarea name="f_descricao" id="f_descricao" class="form-control tinymce" rows="10"
                                placeholder="@lang('gestor_depoimento.descricao')">{{ (old('f_descricao') ? old('f_descricao') : $depoimento->descricao) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($depoimento->id)
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_depoimento.foto_depoimento')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md py-2">
                        <p class="h5">@lang('gestor_depoimento.foto') <span
                                class="badge badge-secondary">@lang('gestor_depoimento.foto_prop')</span></p>
                        <div class="upload-anexos-unique" data-up-tipo="foto" data-up-link="depoimentos"
                            data-up-id="{{ $depoimento->id }}" data-up-nome="foto" data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @include('gestor.depoimentos.foto')
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
