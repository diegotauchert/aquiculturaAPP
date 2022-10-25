@extends('layouts.gestor.app')

@if($mensagem->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_mensagem.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_mensagem.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_mensagem.titulo')
            @if($mensagem->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>

<form method="POST" action="{{ ($mensagem->id ? route('gestor.mensagens.update', $mensagem->id) : route('gestor.mensagens.store')) }}">
    @if($mensagem->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <input name="cliente_id" id="cliente_id" type="hidden" value="{{ $cliente->id }}" />
            <div class="card-header h5">@lang('gestor_mensagem.informacoes') {{$mensagem->nome}}</div>
            <div class="card-body">
                <div class="form-row">
                    @if($usuarios)
                    <div class="form-group col-md">
                        <label for="f_usuario_destino" class="form-control-label">* Enviar para</label>
                        <select name="f_usuario_destino" id="f_usuario_destino" required class="form-control selectpicker-custom" title="Escolha um Usuario">
                            <option value="" disabled {{ !$mensagem->usuario_id_destino ? ' selected' : '' }}>- Escolha um Usuário</option>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ $usuario->id == (old('f_usuario_destino') ? old('f_usuario_destino') : $mensagem->usuario_id_destino) ? ' selected' : '' }}>
                                {{ $usuario->nome }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    @if(auth('gestor')->user()->fazenda_id)
                        <input type="hidden" value="{{auth('gestor')->user()->fazenda_id}}" name="f_fazenda" />
                    @elseif($fazendas)
                        <div class="form-group col-md">
                            <label for="f_fazenda" class="form-control-label">* Escolha uma Fazenda</label>
                            <select name="f_fazenda" id="f_fazenda" required class="form-control selectpicker-custom" title="Escolha uma Fazenda">
                                <option value="" disabled {{ !$mensagem->fazenda_id ? ' selected' : '' }}>- Escolha uma Fazenda</option>
                                @foreach($fazendas as $fazenda)
                                <option value="{{ $fazenda->id }}" {{ $fazenda->id == (old('f_fazenda') ? old('f_fazenda') : $mensagem->fazenda_id) ? ' selected' : '' }}>
                                    {{ $fazenda->nome }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_categoria" class="form-control-label">@lang('gestor_mensagem.categoria')</label>
                        <select name="f_categoria" id="f_categoria" class="form-control selectpicker-custom" title="@lang('gestor_mensagem.categoria')">
                            <option value="" disabled>@lang('gestor_mensagem.situacao')</option>
                            @foreach($mensagem->present()->makeCategoriaAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_categoria') ? old('f_categoria') : $mensagem->categoria_id) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
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
                        <label for="f_data" class="form-control-label">@lang('gestor_mensagem.data')</label>
                        <div class="input-group">
                            <input name="f_data" id="f_data" @if($ver) readonly @endif required type="text" value="{{ (old('f_data') ? old('f_data') : ($mensagem->data ? Carbon\Carbon::parse($mensagem->data)->format('d/m/Y') : date('d/m/Y'))) }}" class="form-control maskdata @error('f_data') is-invalid @enderror" placeholder="@lang('gestor_mensagem.data')" />
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                            </div>
                        </div>
                        @error('f_data')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_detalhes" class="form-control-label">* @lang('gestor_mensagem.detalhes')</label>
                        <textarea name="f_detalhes" required id="f_detalhes" style="resize:vertical"
                            class="form-control" maxlength="250" rows="10" placeholder="@lang('gestor_mensagem.detalhes')" @if($ver) readonly @endif>{{ (old('f_detalhes') ? old('f_detalhes') : $mensagem->mensagem) }}</textarea>

                        @error('f_detalhes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @if($mensagem->id)
                <div class="py-2">
                    <div class="card">
                        <div class="card-body" id="anexo">
                            <label for="f_anexo" class="form-control-label">Anexo</label>
                            <div class="row">
                                <div class="col-md py-2">
                                    <div class="upload-anexos-unique" data-up-tipo="arquivo" data-up-link="mensagens-anexos" data-up-id="{{ $mensagem->id }}" data-up-nome="arquivo" data-up-class="col-md-6 my-auto py-3">
                                        @if(!$ver)
                                        <div class="list-group uploads pb-2"></div>
                                        @endif
                                        <div class="files-itens files-ordem row pt-2">
                                            @include('gestor.mensagens.arquivo')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if(!$ver)
    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span>
            @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>

        @if($mensagem && $mensagem->id)
        <a href="{{ route('gestor.lotes.create', ['id' => $mensagem->id]) }}" class="btn btn-secondary btn-lg ml-auto float-right" data-toggle="tooltip" title="Novo Lote"><span class="fas fa-plus"></span> Novo Lote</a>
        @endif
    </div>
    @endif
</form>
@endsection
