@extends('layouts.gestor.app')

@if($cliente->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_cliente.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_cliente.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_cliente.titulo')
            @if($cliente->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($cliente->id ? route('gestor.clientes.update', $cliente->id) : route('gestor.clientes.store')) }}">
    @if($cliente->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_cliente.informacoes')</div>
            <div class="card-body">
                <!-- <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_categoria" class="form-control-label">@lang('gestor_cliente.categoria')</label>
                        <select name="f_categoria" id="f_categoria" class="form-control selectpicker-custom" title="@lang('gestor_cliente.categoria')">
                            <option value="">@lang('gestor_cliente.categoria')</option>
                            @foreach($s_categorias as $s_categoria)
                            <option value="{{ $s_categoria->id }}" {{ $s_categoria->id == (old('f_categoria') ? old('f_categoria') : $cliente->categoria_id) ? ' selected' : '' }}>
                                {{ $s_categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> -->
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_cliente.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $cliente->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_cliente.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_email" class="form-control-label">@lang('gestor_cliente.email')</label>
                        <input name="f_email" id="f_email" type="text"
                            value="{{ (old('f_email') ? old('f_email') : $cliente->email) }}"
                            class="form-control" maxlength="250" placeholder="@lang('gestor_cliente.email')">

                        @error('f_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_telefone" class="form-control-label">@lang('gestor_cliente.telefone')</label>
                        <input name="f_telefone" id="f_telefone" type="text"
                            value="{{ (old('f_telefone') ? old('f_telefone') : $cliente->telefone) }}"
                            class="form-control masktelefone" maxlength="250" placeholder="@lang('gestor_cliente.telefone')" />

                        @error('f_telefone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_data" class="form-control-label">@lang('gestor_cliente.data')</label>
                        <div class="input-group">
                            <input name="f_data" id="f_data" type="text" value="{{ (old('f_data') ? old('f_data') : ($cliente->dt_nasc ? $cliente->dt_nasc->format('d/m/Y') : '')) }}" class="form-control maskdata @error('f_data') is-invalid @enderror" placeholder="@lang('gestor_cliente.data')" />
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
                    <div class="form-group col-sm">
                        <label for="f_cpf" class="form-control-label">@lang('gestor_cliente.cpf')</label>
                        <input name="f_cpf" id="f_cpf" type="text"
                            value="{{ (old('f_cpf') ? old('f_cpf') : $cliente->cpf) }}"
                            class="form-control maskcpf" maxlength="15" placeholder="@lang('gestor_cliente.cpf')" />

                        @error('f_cpf')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_rg" class="form-control-label">@lang('gestor_cliente.rg')</label>
                        <input name="f_rg" id="f_rg" type="text"
                            value="{{ (old('f_rg') ? old('f_rg') : $cliente->rg) }}"
                            class="form-control" maxlength="15" placeholder="@lang('gestor_cliente.rg')" />

                        @error('f_rg')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_orgao" class="form-control-label">@lang('gestor_cliente.orgao')</label>
                        <input name="f_orgao" id="f_orgao" type="text"
                            value="{{ (old('f_orgao') ? old('f_orgao') : $cliente->orgao) }}"
                            class="form-control" maxlength="5" placeholder="@lang('gestor_cliente.orgao')" />
                    
                        @error('f_orgao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_uf" class="form-control-label">@lang('gestor_cliente.uf')</label>
                        <input name="f_uf" id="f_uf" type="text"
                            value="{{ (old('f_uf') ? old('f_uf') : $cliente->uf) }}"
                            class="form-control" maxlength="2" placeholder="@lang('gestor_cliente.uf')" />
                        
                        @error('f_uf')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_cliente.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_cliente.situacao')">
                            <option value="">@lang('gestor_cliente.situacao')</option>
                            @foreach($cliente->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $cliente->situacao) ? ' selected' : ($sit_k == '1' ? ' selected' : '') }}>
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
                        <label for="f_cep" class="form-control-label">@lang('gestor_cliente.cep')</label>
                        <div class="input-group">
                            <input name="f_cep" id="f_cep" type="text" value="{{ (old('f_cep') ? old('f_cep') : $cliente->cep) }}" class="form-control maskcep @error('f_cep') is-invalid @enderror" placeholder="@lang('gestor_cliente.cep')" />
                        </div>
                        @error('f_cep')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg">
                        <label for="f_endereco" class="form-control-label">@lang('gestor_cliente.endereco')</label>
                        <input name="f_endereco" id="f_endereco" type="text"
                            value="{{ (old('f_endereco') ? old('f_endereco') : $cliente->endereco) }}"
                            class="form-control" maxlength="255" placeholder="@lang('gestor_cliente.endereco')" />

                        @error('f_endereco')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_numero" class="form-control-label">@lang('gestor_cliente.numero')</label>
                        <input name="f_numero" id="f_numero" type="text"
                            value="{{ (old('f_numero') ? old('f_numero') : $cliente->numero) }}"
                            class="form-control" maxlength="15" placeholder="@lang('gestor_cliente.numero')" />

                        @error('f_numero')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_bairro" class="form-control-label">@lang('gestor_cliente.bairro')</label>
                        <input name="f_bairro" id="f_bairro" type="text"
                            value="{{ (old('f_bairro') ? old('f_bairro') : $cliente->bairro) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_cliente.bairro')" />
                    
                        @error('f_bairro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_cidade" class="form-control-label">@lang('gestor_cliente.cidade')</label>
                        <input name="f_cidade" id="f_cidade" type="text"
                            value="{{ (old('f_cidade') ? old('f_cidade') : $cliente->cidade) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_cliente.cidade')" />
                        
                        @error('f_cidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_estado" class="form-control-label">@lang('gestor_cliente.estado')</label>
                        <input name="f_estado" id="f_estado" type="text"
                            value="{{ (old('f_estado') ? old('f_estado') : $cliente->estado) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_cliente.estado')" />
                        
                        @error('f_estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_complemento" class="form-control-label">@lang('gestor_cliente.complemento')</label>
                        <input name="f_complemento" id="f_complemento" type="text"
                            value="{{ (old('f_complemento') ? old('f_complemento') : $cliente->complemento) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_cliente.complemento')" />
                        
                        @error('f_complemento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <hr />
                <h3 class="text-center mb-4">Plano</h3>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_plano" class="form-control-label">@lang('gestor_cliente.plano')</label>
                        <input name="f_plano" id="f_plano" type="text"
                            value="{{ (old('f_plano') ? old('f_plano') : $cliente->plano) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_cliente.plano')" />
                    
                        @error('f_plano')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_fazendas" class="form-control-label">* @lang('gestor_cliente.fazendas') <small>Apenas Número</small></label>
                        <input name="f_fazendas" id="f_fazendas" type="number"
                            value="{{ (old('f_fazendas') ? old('f_fazendas') : $cliente->fazendas) }}"
                            class="form-control" maxlength="3" placeholder="@lang('gestor_cliente.fazendas')" />
                        
                        @error('f_fazendas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_valor" class="form-control-label">@lang('gestor_cliente.valor')</label>
                        <input name="f_valor" id="f_valor" type="text"
                            value="{{ (old('f_valor') ? old('f_valor') : $cliente->valor) }}"
                            class="form-control masknumv3" maxlength="11" placeholder="@lang('gestor_cliente.valor')" />
                        
                        @error('f_valor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_validade" class="form-control-label">@lang('gestor_cliente.validade')</label>
                        <div class="input-group">
                            <input name="f_validade" id="f_validade" type="text" value="{{ (old('f_validade') ? old('f_validade') : ($cliente->validade ? $cliente->validade->format('d/m/Y') : '')) }}" class="form-control maskdata @error('f_validade') is-invalid @enderror" placeholder="@lang('gestor_cliente.validade')" />
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

                <hr />
                <h3 class="text-center mb-4">Usuário</h3>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_usuario" class="form-control-label">* @lang('gestor_usuario.login')</label>
                        <input name="f_usuario" id="f_usuario" type="text"
                            value="{{ (old('f_usuario') ? old('f_usuario') : ($usuario ? $usuario->login : '')) }}"
                            class="form-control" maxlength="100" placeholder="@lang('gestor_usuario.login')" @if($cliente->id) readonly @else required @endif />
                    
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
                            value="{{ (old('f_password') ? old('f_password') : ($usuario ? $usuario->password_decoded : '')) }}"
                            class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password')" @if($cliente->id) readonly @else required @endif />

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
                            value="{{ (old('f_password') ? old('f_password') : ($usuario ? $usuario->password_decoded : '')) }}" 
                            class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password_confirmation')" @if($cliente->id) readonly @else required @endif />
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
                @error('errorPassword')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_cliente.informacoes_texto')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <div class="view-responsive">
                            <div class="btn-group btn-block pb-1" role="group" aria-label="">
                                <button type="button" class="smart btn btn-outline-dark"><span class="fas fa-mobile-alt"></span> Smartphone</button>
                                <button type="button" class="tablet btn btn-outline-dark"><span class="fas fa-tablet-alt"></span> Tablet</button>
                                <button type="button" class="desk active btn btn-outline-dark"><span class="fas fa-desktop"></span> Desktop</button>
                            </div>

                            <textarea name="f_texto" id="f_texto" class="form-control tinymce" rows="10">
                                {{ old('f_texto') ? old('f_texto') : $cliente->obs }}
                            </textarea>
                            <br />
                            {!! $cliente->obs !!}

                            @error('f_texto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    @if($cliente->id)
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_cliente.fotos_post')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md py-2">
                        <div class="upload-anexos" data-up-tipo="foto" data-up-link="clientes-anexos" data-up-id="{{ $cliente->id }}" data-up-nome="foto" data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @if($cliente->anexos)
                                @foreach($cliente->anexos->where('tipo', 1)->sortBy('ordem') as $anexo)
                                @include('gestor.clientes.foto')
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_cliente.anexos_post')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md py-2">
                        <div class="upload-anexos" data-up-tipo="arquivo" data-up-link="clientes-anexos" data-up-id="{{ $cliente->id }}" data-up-nome="arquivo" data-up-class="col-md-6 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @if($cliente->anexos)
                                @foreach($cliente->anexos->where('tipo', 2)->sortBy('ordem') as $anexo)
                                @include('gestor.clientes.arquivo')
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span>
            @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
