@extends('layouts.gestor.app')

@section('title', __('gestor.novo') . ' - ' . __('gestor_usuario.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            {{$cliente->nome}} <small>/</small> {{$fazenda->nome}} <h4>@lang('gestor_usuario.titulo')</h4>
        </h1>
    </div>
</div>

@if(count($usuarios) > 0)
<div class="table-responsive pt-2">
    <div class="card">
        <div class="card-body">
            <table width="100%" class="table table-striped table-hover" id="datatable">
                <thead>
                    <th>@lang('gestor_usuario.nome')</th>
                    <th class="align-middle">@lang('gestor_usuario.login')</th>
                    <th class="align-middle">@lang('gestor_usuario.tipo')</th>
                    <th class="align-middle">@lang('gestor_usuario.situacao')</</th>
                    <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($usuarios as $post)
                    <tr>
                        <td class="align-middle">{{ $post->nome }}</td>
                        <td class="align-middle"><strong>{{ $post->login }}<br/>{{ $post->password_decoded }}</strong></td>
                        <td class="align-middle"><span class="fas fa-{{ $post->present()->makeTipo[1] }}"></span> {{ $post->present()->makeTipo[0] }}</td>
                        <td class="align-middle text-{{ $post->present()->makeSituacao[2] }}"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.fazendas.usuario.destroy', ['fazenda_id' => $fazenda->id, 'id' => $post->id]) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    <a href="{{ route('gestor.fazendas.usuario', ['fazenda_id' => $fazenda->id, 'id' => $post->id]) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    @if($post->tipo > 5)
                                    <button type="submit" class="confirm btn btn-outline-danger btn-sm" data-toggle="tooltip" data-title="@lang('gestor.confirm_destroy')" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span> @lang('gestor.destroy')</button>
                                    @endif
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<form method="POST" action="{{ ($usuario->id ? route('gestor.fazendas.usuario.update', $usuario->id) : route('gestor.fazendas.usuario.save')) }}">
    @if($usuario->id)
    @method('PUT')
    @endif

    @csrf
    <input name="cliente_id" id="cliente_id" type="hidden" value="{{ $cliente->id }}" />
    <input name="fazenda_id" id="fazenda_id" type="hidden" value="{{ $fazenda->id }}" />

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
                                    <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $usuario->situacao) ? ' selected' : '' }}>{{ $sit_v[0] }}</option>
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
                <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
            </div>
        </div>
    </div>
</form>
@endsection
