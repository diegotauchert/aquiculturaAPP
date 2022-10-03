@extends('layouts.gestor.app')

@if($estado->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_estado.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_estado.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_estado.titulo')
            @if($estado->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($estado->id ? route('gestor.estados.update', $estado->id) : route('gestor.estados.store')) }}">
    @if($estado->id)
    @method('PUT')
    @endif
    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_estado.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_estado.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ ($estado->nome ? $estado->nome : old('f_nome')) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_estado.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_sigla" class="form-control-label">* @lang('gestor_estado.sigla')</label>
                        <input name="f_sigla" id="f_sigla" type="text" value="{{ ($estado->sigla ? $estado->sigla : old('f_sigla')) }}" class="form-control @error('f_sigla') is-invalid @enderror" maxlength="2" placeholder="@lang('gestor_estado.sigla')">
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
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
