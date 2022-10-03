@extends('layouts.gestor.app')

@if($vaga->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_vaga.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_vaga.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_vaga.titulo')
            @if($vaga->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($vaga->id ? route('gestor.vagas.update', $vaga->id) : route('gestor.vagas.store')) }}">
    @if($vaga->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_vaga.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_vaga.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $vaga->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_vaga.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_vaga.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_vaga.situacao')">
                            <option value="">@lang('gestor_vaga.situacao')</option>
                            @foreach($vaga->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $vaga->situacao) ? ' selected' : '' }}>{{ $sit_v[0] }}</option>
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
            <div class="card-header h5">@lang('gestor_vaga.informacoes_texto')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_texto" class="form-control-label">@lang('gestor_vaga.texto')</label>
                        <textarea name="f_texto" id="f_texto" class="form-control tinymce" rows="10" placeholder="@lang('gestor_vaga.texto')">{{ (old('f_texto') ? old('f_texto') : $vaga->texto) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
