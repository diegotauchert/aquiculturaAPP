@extends('layouts.gestor.app')

@if($plano->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_plano.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_plano.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_plano.titulo')
            @if($plano->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($plano->id ? route('gestor.planos.update', $plano->id) : route('gestor.planos.store')) }}">
    @if($plano->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_plano.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_plano.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $plano->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_plano.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_qtd_viveiros" class="form-control-label">* @lang('gestor_plano.qtd_viveiros') <small>(Apenas Números)</small></label>
                        <input name="f_qtd_viveiros" id="f_qtd_viveiros" type="number" required 
                            value="{{ (old('f_qtd_viveiros') ? old('f_qtd_viveiros') : $plano->qtd_viveiros) }}"
                            class="form-control" maxlength="3" placeholder="@lang('gestor_plano.qtd_viveiros')">

                        @error('f_qtd_viveiros')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_valor" class="form-control-label">* @lang('gestor_plano.valor')</label>
                        <input name="f_valor" id="f_valor" type="text" required
                            @if($plano->id) readonly @endif
                            value="{{ (old('f_valor') ? old('f_valor') : $plano->valor) }}"
                            class="form-control masknumv3" maxlength="11" placeholder="@lang('gestor_plano.valor')" />
                        
                        @error('f_valor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_plano.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_plano.situacao')">
                            <option value="">@lang('gestor_plano.situacao')</option>
                            @foreach($plano->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $plano->situacao) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
                                {{ $sit_v[0] }}
                            </option>
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

    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span>
            @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
