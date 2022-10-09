@extends('layouts.gestor.app')

@if($viveiro->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_viveiro.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_viveiro.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_viveiro.titulo')
            @if($viveiro->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($viveiro->id ? route('gestor.viveiros.update', $viveiro->id) : route('gestor.viveiros.store')) }}">
    @if($viveiro->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <input name="cliente_id" id="cliente_id" type="hidden" value="{{ $cliente->id }}" />
            <div class="card-header h5">@lang('gestor_viveiro.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_viveiro.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $viveiro->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_viveiro.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @if($fazendas)
                    <div class="form-group col-md">
                        <label for="f_fazenda" class="form-control-label">* Escolha uma Fazenda</label>
                        <select name="f_fazenda" id="f_fazenda" required class="form-control selectpicker-custom" title="Escolha um Plano">
                            <option value="" disabled>- Escolha um Plano</option>
                            @foreach($fazendas as $fazenda)
                            <option value="{{ $fazenda->id }}" {{ $fazenda->id == (old('f_fazenda') ? old('f_fazenda') : $fazenda->id) ? ' selected' : '' }}>
                                {{ $fazenda->nome }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_viveiro.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_viveiro.situacao')">
                            <option value="">@lang('gestor_viveiro.situacao')</option>
                            @foreach($viveiro->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $viveiro->situacao) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
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
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_largura" class="form-control-label">@lang('gestor_viveiro.largura')</label>
                        <input name="f_largura" id="f_largura" type="text"
                            value="{{ (old('f_largura') ? old('f_largura') : $viveiro->largura) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_viveiro.largura')">

                        @error('f_largura')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_comprimento" class="form-control-label">@lang('gestor_viveiro.comprimento')</label>
                        <input name="f_comprimento" id="f_comprimento" type="text"
                            value="{{ (old('f_comprimento') ? old('f_comprimento') : $viveiro->comprimento) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_viveiro.comprimento')" />

                        @error('f_comprimento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_profundidade" class="form-control-label">@lang('gestor_viveiro.profundidade')</label>
                        <input name="f_profundidade" id="f_profundidade" type="text"
                            value="{{ (old('f_profundidade') ? old('f_profundidade') : $viveiro->profundidade) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_viveiro.profundidade')" />

                        @error('f_profundidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_volume" class="form-control-label">@lang('gestor_viveiro.volume')</label>
                        <input name="f_volume" id="f_volume" type="text"
                            value="{{ (old('f_volume') ? old('f_volume') : $viveiro->volume) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_viveiro.volume')" />

                        @error('f_volume')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_area" class="form-control-label">@lang('gestor_viveiro.area')</label>
                        <input name="f_area" id="f_area" type="text"
                            value="{{ (old('f_area') ? old('f_area') : $viveiro->area) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_viveiro.area')" />

                        @error('f_area')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_detalhes" class="form-control-label">@lang('gestor_viveiro.detalhes')</label>
                        <textarea name="f_detalhes" id="f_detalhes" style="resize:vertical"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_viveiro.detalhes')">{{ (old('f_detalhes') ? old('f_detalhes') : $viveiro->detalhes) }}</textarea>

                        @error('f_detalhes')
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
