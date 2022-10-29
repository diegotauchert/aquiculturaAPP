@extends('layouts.gestor.app')

@if($cultivo->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_cultivo.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_cultivo.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_cultivo.titulo')
            @if($cultivo->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>

<form method="POST" action="{{ ($cultivo->id ? route('gestor.cultivos.update', $cultivo->id) : route('gestor.cultivos.store')) }}">
    @if($cultivo->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_cultivo.informacoes') {{$cultivo->nome}}</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_cultivo.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $cultivo->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_cultivo.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-sm">
                        <label for="f_categoria" class="form-control-label">* @lang('gestor_cultivo.categoria')</label>
                        <select name="f_categoria" id="f_categoria" class="form-control selectpicker-custom" title="@lang('gestor_cultivo.categoria')" required>
                            <option value="" disabled> - Escolha a Categoria</option>

                            @foreach($cultivo->present()->makeCategoriaAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" {{ $sit_k == (old('f_categoria') ? old('f_categoria') : $cultivo->categoria_id) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
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
                        <label for="f_tipo" class="form-control-label">@lang('gestor_cultivo.tipo')</label>
                        <input name="f_tipo" id="f_tipo" type="text"
                            value="{{ (old('f_tipo') ? old('f_tipo') : $cultivo->tipo) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_cultivo.tipo')">

                        @error('f_tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_cultivo.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_cultivo.situacao')">
                            <option value="">@lang('gestor_cultivo.situacao')</option>
                            @foreach($cultivo->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $cultivo->situacao) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
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
                        <label for="f_biometria" class="form-control-label">@lang('gestor_cultivo.biometria')</label>
                        <input name="f_biometria" id="f_biometria" type="text"
                            value="{{ (old('f_biometria') ? old('f_biometria') : $cultivo->biometria) }}"
                            class="form-control" maxlength="50" placeholder="@lang('gestor_cultivo.biometria')" />

                        @error('f_biometria')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_adensamento" class="form-control-label">@lang('gestor_cultivo.adensamento')</label>
                        <input name="f_adensamento" id="f_adensamento" type="text"
                            value="{{ (old('f_adensamento') ? old('f_adensamento') : $cultivo->adensamento) }}"
                            class="form-control" maxlength="50" placeholder="@lang('gestor_cultivo.adensamento')" />

                        @error('f_adensamento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-sm">
                        <label for="f_povoado" class="form-control-label">@lang('gestor_cultivo.povoado')</label>
                        <div class="input-group">
                            <input name="f_povoado" id="f_povoado" type="text" value="{{ (old('f_povoado') ? old('f_povoado') : ($cultivo->povoado ? $cultivo->povoado->format('d/m/Y') : '')) }}" class="form-control maskdata @error('f_povoado') is-invalid @enderror" placeholder="@lang('gestor_cliente.povoado')" />
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                            </div>
                        </div>
                        @error('f_povoado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_peso" class="form-control-label">@lang('gestor_cultivo.peso')</label>
                        <input name="f_peso" id="f_peso" type="text"
                            value="{{ (old('f_peso') ? old('f_peso') : $cultivo->peso) }}"
                            class="form-control" maxlength="50" placeholder="@lang('gestor_cultivo.peso')" />

                        @error('f_peso')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_peso_2" class="form-control-label">@lang('gestor_cultivo.peso_2')</label>
                        <input name="f_peso_2" id="f_peso_2" type="text"
                            value="{{ (old('f_peso_2') ? old('f_peso_2') : $cultivo->peso_2) }}"
                            class="form-control" maxlength="50" placeholder="@lang('gestor_cultivo.peso_2')" />

                        @error('f_peso_2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-sm">
                        <label for="f_despesca" class="form-control-label">@lang('gestor_cultivo.despesca')</label>
                        <div class="input-group">
                            <input name="f_despesca" id="f_despesca" type="text" value="{{ (old('f_despesca') ? old('f_despesca') : ($cultivo->despesca ? $cultivo->despesca->format('d/m/Y') : '')) }}" class="form-control maskdata @error('f_despesca') is-invalid @enderror" placeholder="@lang('gestor_cliente.despesca')" />
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                            </div>
                        </div>
                        @error('f_despesca')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_detalhes" class="form-control-label">@lang('gestor_cultivo.detalhes')</label>
                        <textarea name="f_detalhes" id="f_detalhes" style="resize:vertical"
                            class="form-control" rows="8" placeholder="@lang('gestor_cultivo.detalhes')">{{ (old('f_detalhes') ? old('f_detalhes') : $cultivo->detalhes) }}</textarea>

                        @error('f_detalhes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-sm">
                        <input name="f_inativar" id="f_inativar" type="checkbox" value="1" class="mr-2" />
                        <label for="f_inativar" class="form-control-label">@lang('gestor_cultivo.inativar')</label>
                        @error('f_inativar')
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
