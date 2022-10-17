@extends('layouts.gestor.app')

@if($produto->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_produto.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_produto.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_produto.titulo')
            @if($produto->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>

<form method="POST" action="{{ ($produto->id ? route('gestor.produtos.update', $produto->id) : route('gestor.produtos.store')) }}">
    @if($produto->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <input name="cliente_id" id="cliente_id" type="hidden" value="{{ $cliente->id }}" />
            <div class="card-header h5">@lang('gestor_produto.informacoes') {{$produto->nome}}</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_produto.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $produto->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_produto.nome')" data-ref="f_link">
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
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_produto.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_produto.situacao')">
                            <option value="">@lang('gestor_produto.situacao')</option>
                            @foreach($produto->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $produto->situacao) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
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
                        <label for="f_vl_unitario" class="form-control-label">@lang('gestor_produto.vl_unitario')</label>
                        <input name="f_vl_unitario" id="f_vl_unitario" type="text"
                            value="{{ (old('f_vl_unitario') ? old('f_vl_unitario') : $produto->vl_unitario) }}"
                            class="form-control masknumv3" maxlength="250" placeholder="@lang('gestor_produto.vl_unitario')">

                        @error('f_vl_unitario')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_vl_total" class="form-control-label">@lang('gestor_produto.vl_total')</label>
                        <input name="f_vl_total" id="f_vl_total" type="text"
                            value="{{ (old('f_vl_total') ? old('f_vl_total') : $produto->vl_total) }}"
                            class="form-control masknumv3" maxlength="250" placeholder="@lang('gestor_produto.vl_total')" />

                        @error('f_vl_total')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_quantidade" class="form-control-label">* @lang('gestor_produto.quantidade')</label>
                        <input name="f_quantidade" id="f_quantidade" type="number"
                            value="{{ (old('f_quantidade') ? old('f_quantidade') : $produto->quantidade) }}"
                            class="form-control" maxlength="5" placeholder="@lang('gestor_produto.quantidade')" />

                        @error('f_quantidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_minimo" class="form-control-label">* @lang('gestor_produto.minimo')</label>
                        <input name="f_minimo" id="f_minimo" type="number"
                            value="{{ (old('f_minimo') ? old('f_minimo') : $produto->minimo) }}"
                            class="form-control" maxlength="5" placeholder="@lang('gestor_produto.minimo')" />

                        @error('f_minimo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_categoria" class="form-control-label">* @lang('gestor_produto.categoria')</label>
                        <select name="f_categoria" id="f_categoria" class="form-control selectpicker-custom" title="@lang('gestor_produto.categoria')" required>
                            <option value="" disabled>@lang('gestor_produto.situacao')</option>
                            @foreach($produto->present()->makeCategoriaAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_categoria') ? old('f_categoria') : $produto->categoria_id) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
                                {{ $sit_v[0] }}
                            </option>
                            @endforeach
                        </select>

                        @error('f_categoria')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group col-sm">
                        <label for="f_tipo" class="form-control-label">@lang('gestor_produto.tipo')</label>
                        <input name="f_tipo" id="f_tipo" type="text"
                            value="{{ (old('f_tipo') ? old('f_tipo') : $produto->tipo) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_produto.tipo')">

                        @error('f_tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-sm">
                        <label for="f_validade" class="form-control-label">@lang('gestor_produto.validade')</label>
                        <div class="input-group">
                            <input name="f_validade" id="f_validade" required type="text" value="{{ (old('f_validade') ? old('f_validade') : ($produto->validade ? $produto->validade->format('d/m/Y') : '')) }}" class="form-control maskdata @error('f_validade') is-invalid @enderror" placeholder="@lang('gestor_cliente.data')" />
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                            </div>
                        </div>
                        @error('f_validade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_detalhes" class="form-control-label">@lang('gestor_produto.detalhes')</label>
                        <textarea name="f_detalhes" id="f_detalhes" style="resize:vertical"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_produto.detalhes')">{{ (old('f_detalhes') ? old('f_detalhes') : $produto->detalhes) }}</textarea>

                        @error('f_detalhes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                @if(isset($lotes))
                @include('gestor.produtos.addlote')
                @endif
            </div>
        </div>
    </div>

    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span>
            @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>

        @if($produto && $produto->id)
        <a href="{{ route('gestor.lotes.create', ['id' => $produto->id]) }}" class="btn btn-secondary btn-lg ml-auto float-right" data-toggle="tooltip" title="Novo Lote"><span class="fas fa-plus"></span> Novo Lote</a>
        @endif
    </div>
</form>
@endsection
