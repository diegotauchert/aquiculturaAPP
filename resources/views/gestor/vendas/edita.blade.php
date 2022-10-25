@extends('layouts.gestor.app')

@if($venda->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_venda.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_venda.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_venda.titulo')
            @if($venda->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($venda->id ? route('gestor.vendas.update', $venda->id) : route('gestor.vendas.store')) }}">
    @if($venda->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_venda.informacoes')</div>
            <div class="card-body">
                @if(auth('gestor')->user()->fazenda_id)
                    <input type="hidden" value="{{auth('gestor')->user()->fazenda_id}}" name="f_fazenda" />
                @elseif(isset($fazendas) && count($fazendas) > 0)
                    <div class="form-group col-md">
                        <label for="f_fazenda" class="form-control-label">* Escolha uma Fazenda</label>
                        <select name="f_fazenda" id="f_fazenda" required class="form-control selectpicker-custom" title="Escolha uma Fazenda">
                            <option value="" disabled>- Escolha uma Fazenda</option>
                            @foreach($fazendas as $fazenda)
                            <option value="{{ $fazenda->id }}" {{ $fazenda->id == (old('f_fazenda') ? old('f_fazenda') : $venda->fazenda_id) ? ' selected' : '' }}>
                                {{ $fazenda->nome }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                
                @if($viveiros && count($viveiros) > 0)
                <div class="viveiros mb-4 border p-3 rounded border-light text-center">
                    <h5>* Escolha um Viveiro</h5>
                    @foreach($viveiros as $viveiro)
                    <div class="viveiro">
                        <input @if($viveiro->id == $venda->viveiro_id) checked @endif type="radio" value="{{$viveiro->id}}" id="viveiro-{{$viveiro->id}}" name="f_viveiro" class="mt-0 mr-2" style="transform: scale(1.5);vertical-align: text-top;" />
                        <label for="viveiro-{{$viveiro->id}}"><h4 class="m-0 mt-2">{{$viveiro->nome}}</h4></label>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="alert alert-danger h6 text-center mb-4"><i class="fa-solid fa-triangle-exclamation"></i> Essa venda não poderá ser realizada porque você não possui viveiro cadastrado.</p>
                @endif
                @error('f_viveiro')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <h5 class="text-center mb-2">Cliente</h5>
                <div class="form-row border border-light p-4 mb-5 rounded">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_venda.nome')</label>
                        <input name="f_nome" id="f_nome" required type="text" value="{{ (old('f_nome') ? old('f_nome') : $venda->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_venda.nome')" />
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_cpf" class="form-control-label">* @lang('gestor_venda.cpf')</label>
                        <input name="f_cpf" id="f_cpf" type="text" required value="{{ (old('f_cpf') ? old('f_cpf') : $venda->cpf) }}" class="form-control maskcpf normatize @error('f_cpf') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_venda.cpf')" />
                        @error('f_cpf')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_telefone" class="form-control-label">* @lang('gestor_venda.telefone')</label>
                        <input name="f_telefone" required id="f_telefone" type="text" value="{{ (old('f_telefone') ? old('f_telefone') : $venda->telefone) }}" class="form-control masktelefone normatize @error('f_telefone') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_venda.telefone')" />
                        @error('f_telefone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="nota">
                    <h5 class="text-center mb-2">Detalhes da Venda</h5>
                    <div class="form-row border border-light p-4 mb-4 rounded">
                        <div class="form-group col-sm">
                            <label for="f_tipo" class="form-control-label">@lang('gestor_venda.tipo')</label>
                            <input name="f_tipo" id="f_tipo" type="text"
                                value="{{ (old('f_tipo') ? old('f_tipo') : $venda->tipo) }}"
                                class="form-control" maxlength="250" placeholder="@lang('gestor_venda.tipo')">

                            @error('f_tipo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm">
                            <label for="f_vl_total" class="form-control-label">@lang('gestor_venda.vl_total')</label>
                            <input name="f_vl_total" id="f_vl_total" type="text"
                                value="{{ (old('f_vl_total') ? old('f_vl_total') : $venda->vl_total) }}"
                                class="form-control masknumv3" maxlength="250" placeholder="@lang('gestor_venda.vl_total')" />

                            @error('f_vl_total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm">
                            <label for="f_data" class="form-control-label">@lang('gestor_venda.data')</label>
                            <div class="input-group">
                                <input name="f_data" id="f_data" required type="text" value="{{ (old('f_data') ? old('f_data') : ($venda->data ? Carbon\Carbon::parse($venda->data)->format('d/m/Y') : date('d/m/Y'))) }}" class="form-control maskdata @error('f_data') is-invalid @enderror" placeholder="@lang('gestor_cliente.data')" />
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

                        <div class="form-row border border-light p-3 rounded w-100 mx-2 mb-3">
                            <h4 class="text-center mt-4 pt-1 mr-3">Peixe <i class="fa-solid fa-arrow-right"></i></h4>
                            <div class="form-group col-sm">
                                <label for="f_qtd_peixe" class="form-control-label">@lang('gestor_venda.qtd')</label>
                                <input name="f_qtd_peixe" id="f_qtd_peixe" type="text"
                                    value="{{ (old('f_qtd_peixe') ? old('f_qtd_peixe') : $venda->qtd_peixe) }}"
                                    class="form-control maskfive" maxlength="5" placeholder="@lang('gestor_venda.qtd')">

                                @error('f_qtd_peixe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm">
                                <label for="f_vl_peixe" class="form-control-label">@lang('gestor_venda.valor')</label>
                                <input name="f_vl_peixe" id="f_vl_peixe" type="text"
                                    value="{{ (old('f_vl_peixe') ? old('f_vl_peixe') : $venda->vl_peixe) }}"
                                    class="form-control masknumv3" maxlength="250" placeholder="@lang('gestor_venda.valor')" />

                                @error('f_vl_peixe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm">
                                <label for="f_gramatura_peixe" class="form-control-label">@lang('gestor_venda.gramatura')</label>
                                <input name="f_gramatura_peixe" id="f_gramatura_peixe" type="text"
                                    value="{{ (old('f_gramatura_peixe') ? old('f_gramatura_peixe') : $venda->gramatura_peixe) }}"
                                    class="form-control" maxlength="250" placeholder="@lang('gestor_venda.gramatura')">

                                @error('f_gramatura_peixe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row border border-light p-3 rounded w-100 mx-2">
                            <h4 class="text-center mt-4 pt-1 mr-3">Camarão <i class="fa-solid fa-arrow-right"></i></h4>
                            <div class="form-group col-sm">
                                <label for="f_qtd_camarao" class="form-control-label">@lang('gestor_venda.qtd')</label>
                                <input name="f_qtd_camarao" id="f_qtd_camarao" type="text"
                                    value="{{ (old('f_qtd_camarao') ? old('f_qtd_camarao') : $venda->qtd_camarao) }}"
                                    class="form-control maskfive" maxlength="5" placeholder="@lang('gestor_venda.qtd')">

                                @error('f_qtd_camarao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm">
                                <label for="f_vl_camarao" class="form-control-label">@lang('gestor_venda.valor')</label>
                                <input name="f_vl_camarao" id="f_vl_camarao" type="text"
                                    value="{{ (old('f_vl_camarao') ? old('f_vl_camarao') : $venda->vl_camarao) }}"
                                    class="form-control masknumv3" maxlength="250" placeholder="@lang('gestor_venda.valor')" />

                                @error('f_vl_camarao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm">
                                <label for="f_gramatura_camarao" class="form-control-label">@lang('gestor_venda.gramatura')</label>
                                <input name="f_gramatura_camarao" id="f_gramatura_camarao" type="text"
                                    value="{{ (old('f_gramatura_camarao') ? old('f_gramatura_camarao') : $venda->gramatura_camarao) }}"
                                    class="form-control" maxlength="250" placeholder="@lang('gestor_venda.gramatura')">

                                @error('f_gramatura_camarao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_detalhes" class="form-control-label">@lang('gestor_venda.detalhes')</label>
                        <textarea name="f_detalhes" id="f_detalhes" style="resize:vertical"
                            class="form-control" rows="12" placeholder="@lang('gestor_venda.detalhes')">{{ (old('f_detalhes') ? old('f_detalhes') : $venda->detalhes) }}</textarea>

                        @error('f_detalhes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                @if($venda->id)
                <div class="py-2">
                    <div class="card">
                        <div class="card-body" id="anexo">
                            <label for="f_anexo" class="form-control-label">Anexo</label>
                            <div class="row">
                                <div class="col-md py-2">
                                    <div class="upload-anexos-unique" data-up-tipo="arquivo" data-up-link="vendas-anexos" data-up-id="{{ $venda->id }}" data-up-nome="arquivo" data-up-class="col-md-6 my-auto py-3">
                                        <div class="list-group uploads pb-2"></div>
                                        <div class="files-itens files-ordem row pt-2">
                                            @include('gestor.vendas.arquivo')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="form-row">
                    <div class="form-group col-sm">
                        <input @if($venda->situacao == 2) checked @endif name="f_finalizado" id="f_finalizado" type="checkbox" value="1" class="mr-2" />
                        <label for="f_finalizado" class="form-control-label">@lang('gestor_venda.finalizado')</label>
                        @error('f_finalizado')
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
        @if($viveiros && count($viveiros) > 0)
            <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span>
                @lang('gestor.save')
            </button>
        @endif
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
