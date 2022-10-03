@extends('layouts.gestor.app')

@if($lang->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_lang.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_lang.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_lang.titulo')
            @if($lang->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($lang->id ? route('gestor.langs.update', $lang->id) : route('gestor.langs.store')) }}">
    @if($lang->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_lang.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_lang.nome')</label>
                        <input name="f_nome" id="f_nome" type="text"
                            value="{{ (old('f_nome') ? old('f_nome') : $lang->nome) }}"
                            class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250"
                            placeholder="@lang('gestor_lang.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_lang.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom"
                            title="@lang('gestor_lang.situacao')">
                            <option value="">@lang('gestor_lang.situacao')</option>
                            @foreach($lang->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}"
                                {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $lang->situacao) ? ' selected' : '' }}>
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
                        <label for="f_sigla" class="form-control-label">* @lang('gestor_lang.sigla')</label>
                        <input name="f_sigla" id="f_sigla" type="text"
                            value="{{ (old('f_sigla') ? old('f_sigla') : $lang->sigla) }}"
                            class="form-control normatize @error('f_sigla') is-invalid @enderror" maxlength="250"
                            placeholder="@lang('gestor_lang.sigla')" data-ref="f_link">
                        @error('f_sigla')
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
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span>
            @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
