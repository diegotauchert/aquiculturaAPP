@extends('layouts.gestor.app')

@if($cidade->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_cidade.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_cidade.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_cidade.titulo')
            @if($cidade->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($cidade->id ? route('gestor.cidades.update', $cidade->id) : route('gestor.cidades.store')) }}">
    @if($cidade->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_cidade.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_estado" class="form-control-label">* @lang('gestor_cidade.estado')</label>
                        <select name="f_estado" id="f_estado" class="form-control selectpicker-custom @error('f_estado') is-invalid @enderror" title="@lang('gestor_cidade.estado')">
                            <option value="">@lang('gestor_cidade.estado')</option>
                            @foreach($s_estados as $estado)
                            <option value="{{ $estado->id }}" data-subtext="{{ $estado->sigla }}"{{ $estado->id == (old('f_estado') ? old('f_estado') : $cidade->estado_id) ? ' selected' : '' }}>{{ $estado->nome }}</option>
                            @endforeach
                        </select>
                        @error('f_estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_cidade.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $cidade->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_cidade.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_ibge_code" class="form-control-label">* @lang('gestor_cidade.ibge_code')</label>
                        <input name="f_ibge_code" id="f_ibge_code" type="text" value="{{ (old('f_ibge_code') ? old('f_ibge_code') : $cidade->ibge_code) }}" class="form-control @error('f_ibge_code') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_cidade.ibge_code')">
                        @error('f_ibge_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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
