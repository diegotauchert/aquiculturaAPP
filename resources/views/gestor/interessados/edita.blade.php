@extends('layouts.gestor.app')

@if($interessado->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_interessado.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_interessado.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_interessado.titulo')
            @if($interessado->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($interessado->id ? route('gestor.interessados.update', $interessado->id) : route('gestor.interessados.store')) }}">
    @if($interessado->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_interessado.informacoes')</div>
            <div class="card-body">

                <div class="form-row">
                <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">@lang('gestor_interessado.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $interessado->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_interessado.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_email" class="form-control-label">E-mail</label>
                        <input name="f_email" id="f_email" type="text" value="{{ (old('f_email') ? old('f_email') : $interessado->email) }}" class="form-control @error('f_email') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_interessado.email')">
                        @error('f_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_interessado.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_interessado.situacao')">
                            <option value="">@lang('gestor_interessado.situacao')</option>
                            @foreach($interessado->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $interessado->situacao) ? ' selected' : '' }}>{{ $sit_v[0] }}</option>
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
            <div class="card-header h5">@lang('gestor_interessado.mais_obs')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_obs" class="form-control-label">@lang('gestor_interessado.obs')</label>
                        <textarea name="f_obs" id="f_obs" rows="4" class="form-control" placeholder="@lang('gestor_interessado.obs')">{{ (old('f_obs') ? old('f_obs') : $interessado->obs) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($interessado->id)
    @permissao('gestor', 'gestor.relacionamentos.create')
    <a href="{{ route('gestor.relacionamentos.create', ['interessado' => $interessado->id]) }}" class="btn btn-primary"><span class="fas fa-asterisk"></span> @lang('gestor_relacionamento.create')</a>
    @endpermissao
    @endif

    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
