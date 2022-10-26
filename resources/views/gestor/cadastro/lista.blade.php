@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_usuario.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_usuario.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.fazendas.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>

@if(!auth('gestor')->user()->fazenda_id)
<p class="alert alert-danger h6 text-center mb-4">
    <a href="{{route('gestor.editar-perfil')}}" class="text-white" style="font-size:14px;" title="Clique aqui para editar o usuário"><span><i class="fa-solid fa-triangle-exclamation"></i> Esse usuário não está vinculado a uma fazenda, você precisa editar seu usuário aqui antes de criar novos usuários.</span></a>
</p>
@endif

@if(count($usuarios) > 0)
<div class="table-responsive pt-2">
    <div class="card">
        <div class="d-flex pt-3 pr-3">
            <div class="mobile-scroll-auto text-muted ml-auto">
                <i class="fas fa-exchange-alt mr-2"></i> <small>Role para os lados</small>
            </div>
        </div>
        <div class="card-body overflow-auto">
            <table width="100%" class="table table-striped table-hover" id="datatable">
                <thead>
                    <th>@lang('gestor_usuario.nome')</th>
                    <th class="align-middle">@lang('gestor_usuario.login')</th>
                    <th class="align-middle">@lang('gestor_usuario.tipo')</th>
                    <th class="align-middle">Fazenda</th>
                    <th class="align-middle">Cliente</th>
                    <th class="align-middle">@lang('gestor_usuario.situacao')</</th>
                </thead>
                <tbody>
                    @foreach($usuarios as $post)
                    <tr>
                        <td class="align-middle">{{ $post->nome }}</td>
                        <td class="align-middle">
                            <strong>{{ $post->login }}</strong>
                            <!-- <br/>{{ $post->password_decoded }} -->
                        </td>
                        <td class="align-middle"><span class="fas fa-{{ $post->present()->makeTipo[1] }}"></span> {{ $post->present()->makeTipo[0] }}</td>
                        <td class="align-middle">
                            @if($post->fazenda)<small>{{ $post->fazenda->nome }}</small>@else <small class="text-danger">-- Nenhuma Fazenda Encontrada --</small> @endif
                        </td>
                        <td class="align-middle">
                            <small>{{ $post->cliente->nome }}</small> 
                        </td>
                        <td class="align-middle text-{{ $post->present()->makeSituacao[2] }}"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if(auth('gestor')->user()->fazenda_id)
<form method="POST" action="{{ ($usuario->id ? route('gestor.cadastro.update', $usuario->id) : route('gestor.cadastro.store')) }}">
    @if($usuario->id)
    @method('PUT')
    @endif

    @csrf
    <input name="cliente_id" id="cliente_id" type="hidden" value="{{ $cliente->id }}" />
    <input name="fazenda_id" id="fazenda_id" type="hidden" value="{{ auth('gestor')->user()->fazenda_id }}" />

    @error('cliente_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <div class="row">
        <div class="col-md">
            <div class="py-2">
                <div class="card">
                    <div class="card-header h5">@if($usuario->id) Editar @else Novo @endif Usuário {{$usuario->nome}}</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="f_nome" class="form-control-label">* @lang('gestor_usuario.nome')</label>
                                <input name="f_nome" id="f_nome" value="{{ (old('v') ? old('v') : $usuario->nome) }}" type="text" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_usuario.nome')">
                                @error('f_nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="f_usuario" class="form-control-label">* login</label>
                                <input name="f_usuario" value="{{ (old('f_usuario') ? old('f_usuario') : $usuario->login) }}" id="f_usuario" type="text" class="form-control @error('f_usuario') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_usuario.login')">
                                @error('f_usuario')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-sm">
                                <label for="f_tipo" class="form-control-label">* @lang('gestor_usuario.tipo')</label>
                                <select name="f_tipo" id="f_tipo" class="form-control selectpicker-custom" title="@lang('gestor_usuario.tipo')">
                                    <option value="" disabled @if(!$usuario->tipo) selected @endif>@lang('gestor_usuario.tipo')</option>
                                    <option value="5" @if($usuario->tipo == 5) selected @endif>Gestor</option>
                                    <option value="6" @if($usuario->tipo == 6) selected @endif>Engenheiro</option>
                                    <option value="7" @if($usuario->tipo == 7) selected @endif>Técnico</option>
                                    <option value="8" @if($usuario->tipo == 8) selected @endif>Produção</option>
                                    
                                </select>
                                @error('f_tipo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-sm">
                                <label for="f_situacao" class="form-control-label">* @lang('gestor_usuario.situacao')</label>
                                <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_usuario.situacao')">
                                    <option value="" disabled>@lang('gestor_usuario.situacao')</option>
                                    @foreach($usuario->present()->makeSituacaoAll as $sit_k => $sit_v)
                                    <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $usuario->situacao) ? 'selected' : '' }}>{{ $sit_v[0] }}</option>
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
                                <label for="f_password" class="form-control-label">* @if($usuario) 'Nova' @endif @lang('gestor_usuario.password')</label>
                                <div class="input-group">
                                    <input name="f_password" id="f_password" type="password" value="{{ (old('f_password') ? old('f_password') : $usuario->password_decoded) }}" class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password')">

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
                                    <input name="f_password_confirmation" id="f_password_confirmation" value="{{ (old('f_password') ? old('f_password') : $usuario->password_decoded) }}" type="password" class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password_confirmation')">
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
                        @if($usuario->id)
                        <div><small>Senha Atual: <strong>{{$usuario->password_decoded}}</strong></small></div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="py-2 pb-5 text-center">
                <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
                <a class="btn btn-lg btn-outline-primary" href="{{ route('gestor.fazendas.index') }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
            </div>
        </div>
    </div>
</form>
@endif
@endsection