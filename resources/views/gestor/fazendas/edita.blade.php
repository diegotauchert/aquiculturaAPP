@extends('layouts.gestor.app')

@if($fazenda->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_fazenda.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_fazenda.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_fazenda.titulo')
            @if($fazenda->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($fazenda->id ? route('gestor.fazendas.update', $fazenda->id) : route('gestor.fazendas.store')) }}">
    @if($fazenda->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <input name="cliente_id" id="cliente_id" type="hidden" value="{{ $cliente->id }}" />
            <div class="card-header h5">@lang('gestor_fazenda.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_fazenda.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $fazenda->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_fazenda.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_email" class="form-control-label">@lang('gestor_fazenda.email')</label>
                        <input name="f_email" id="f_email" type="text"
                            value="{{ (old('f_email') ? old('f_email') : $fazenda->email) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_fazenda.email')">

                        @error('f_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_telefone" class="form-control-label">@lang('gestor_fazenda.telefone')</label>
                        <input name="f_telefone" id="f_telefone" type="text"
                            value="{{ (old('f_telefone') ? old('f_telefone') : $fazenda->telefone) }}"
                            class="form-control masktelefone" maxlength="250" placeholder="@lang('gestor_fazenda.telefone')" />

                        @error('f_telefone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_fazenda.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_fazenda.situacao')">
                            <option value="">@lang('gestor_fazenda.situacao')</option>
                            @foreach($fazenda->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $fazenda->situacao) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
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
                        <label for="f_cep" class="form-control-label">@lang('gestor_fazenda.cep')</label>
                        <div class="input-group">
                            <input name="f_cep" id="f_cep" type="text" value="{{ (old('f_cep') ? old('f_cep') : $fazenda->cep) }}" class="form-control maskcep @error('f_cep') is-invalid @enderror" placeholder="@lang('gestor_fazenda.cep')" />
                        </div>
                        @error('f_cep')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg">
                        <label for="f_endereco" class="form-control-label">@lang('gestor_fazenda.endereco')</label>
                        <input name="f_endereco" id="f_endereco" type="text"
                            value="{{ (old('f_endereco') ? old('f_endereco') : $fazenda->endereco) }}"
                            class="form-control" maxlength="255" placeholder="@lang('gestor_fazenda.endereco')" />

                        @error('f_endereco')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_numero" class="form-control-label">@lang('gestor_fazenda.numero')</label>
                        <input name="f_numero" id="f_numero" type="text"
                            value="{{ (old('f_numero') ? old('f_numero') : $fazenda->numero) }}"
                            class="form-control" maxlength="15" placeholder="@lang('gestor_fazenda.numero')" />

                        @error('f_numero')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_bairro" class="form-control-label">@lang('gestor_fazenda.bairro')</label>
                        <input name="f_bairro" id="f_bairro" type="text"
                            value="{{ (old('f_bairro') ? old('f_bairro') : $fazenda->bairro) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_fazenda.bairro')" />
                    
                        @error('f_bairro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_cidade" class="form-control-label">@lang('gestor_fazenda.cidade')</label>
                        <input name="f_cidade" id="f_cidade" type="text"
                            value="{{ (old('f_cidade') ? old('f_cidade') : $fazenda->cidade) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_fazenda.cidade')" />
                        
                        @error('f_cidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_estado" class="form-control-label">@lang('gestor_fazenda.estado')</label>
                        <input name="f_estado" id="f_estado" type="text"
                            value="{{ (old('f_estado') ? old('f_estado') : $fazenda->estado) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_fazenda.estado')" />
                        
                        @error('f_estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_complemento" class="form-control-label">@lang('gestor_fazenda.complemento')</label>
                        <input name="f_complemento" id="f_complemento" type="text"
                            value="{{ (old('f_complemento') ? old('f_complemento') : $fazenda->complemento) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_fazenda.complemento')" />
                        
                        @error('f_complemento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @if(!$fazenda->id)
                <hr />
                <h4 class="text-center mb-4">Usuário Gestor da Fazenda</h4>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_usuario" class="form-control-label">* @lang('gestor_usuario.login')</label>
                        <input name="f_usuario" id="f_usuario" type="text"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_usuario.login')" @if($fazenda->id) readonly @else required @endif />
                    
                        @error('f_usuario')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_password" class="form-control-label">* @lang('gestor_usuario.password')</label>
                        <div class="input-group">
                            <input name="f_password" id="f_password" type="password" 
                            class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password')" @if($fazenda->id) readonly @else required @endif />

                            <div class="input-group-append">
                                <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')/@lang('gestor.hide')" type="button"><span class="fas fa-eye"></span></button>
                            </div>
                        </div>
                        @error('f_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_password_confirmation" class="form-control-label">* @lang('gestor_usuario.password_confirmation')</label>
                        <div class="input-group">
                            <input name="f_password_confirmation" id="f_password_confirmation" type="password"
                            class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password_confirmation')" @if($fazenda->id) readonly @else required @endif />
                            <div class="input-group-append">
                                <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')/@lang('gestor.hide')" type="button"><span class="fas fa-eye"></span></button>
                            </div>
                        </div>
                        @error('f_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endif

                <div class="form-row">
                    @if($planos && count($planos) > 0)
                    <div class="form-group col-md">
                        <label for="f_plano" class="form-control-label">* Escolha um Plano</label>
                        <select name="f_plano" id="f_plano" required class="form-control selectpicker-custom" title="Escolha um Plano">
                            <option value="" disabled>- Escolha um Plano</option>
                            @foreach($planos as $plano)
                            <option value="{{ $plano->id }}" {{ $plano->id == (old('f_plano') ? old('f_plano') : $fazenda->plano_id) ? ' selected' : '' }}>
                            {{ $plano->nome }} / até {{ $plano->qtd_viveiros }} viveiro(s) / R$ {{ $plano->valor }} mensal</option>
                            @endforeach
                        </select>

                        @error('f_plano')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @endif
                    <div class="form-group col-md"></div>
                    <div class="form-group col-md"></div>
                </div>
                @if(!$fazenda->id)
                <div class="form-row p-2 d-flex">
                    <input type="checkbox" class="input checkbox mr-2 p-2 my-0" required name="termos" id="termos" value="1" />
                    <label for="termos" class="m-0">Concordo com os termos de cadastro em que cada fazenda gera uma liçença sendo assim cobrado um valor mensal por cada cadastrado.</label>

                    @error('termos')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endif
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
