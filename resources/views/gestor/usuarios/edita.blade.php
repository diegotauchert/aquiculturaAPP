@extends('layouts.gestor.app')

@if($usuario->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_usuario.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_usuario.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_usuario.titulo')
            @if($usuario->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($usuario->id ? route('gestor.usuarios.update', $usuario->id) : route('gestor.usuarios.store')) }}">
    @if($usuario->id)
    @method('PUT')
    @endif

    @csrf

    <div class="row">
        <div class="col-md">
            <div class="py-2">
                <div class="card">
                    <div class="card-header h5">@lang('gestor_usuario.informacoes_acesso')</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="f_login" class="form-control-label">* @lang('gestor_usuario.login')</label>
                                <input name="f_login" id="f_login" type="text" value="{{ (old('f_login') ? old('f_login') : $usuario->login) }}" class="form-control @error('f_login') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_usuario.login')">
                                @error('f_login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md">
                                <label for="f_email" class="form-control-label">* @lang('gestor_usuario.email')</label>
                                <input name="f_email" id="f_email" type="text" value="{{ (old('f_email') ? old('f_email') : $usuario->email) }}" class="form-control @error('f_email') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_usuario.email')">
                                @error('f_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            @if($usuario->id)
                            <div class="form-group col-sm">
                                <label for="f_password_new" class="form-control-label">* @lang('gestor_usuario.password_new')</label>
                                <div class="input-group">
                                    <input name="f_password_new" id="f_password_new" type="password" value="" class="form-control @error('f_password_new') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password_new')">

                                    <div class="input-group-append">
                                        <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')/@lang('gestor.hide')" type="button"><span class="fas fa-eye"></span></button>
                                    </div>
                                </div>
                                @error('f_password_new')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm">
                                <label for="f_password_new_confirmation" class="form-control-label">* @lang('gestor_usuario.password_new_confirmation')</label>
                                <div class="input-group">
                                    <input name="f_password_new_confirmation" id="f_password_new_confirmation" type="password" value="" class="form-control @error('f_password_new') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password_new_confirmation')">
                                    <div class="input-group-append">
                                        <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')/@lang('gestor.hide')" type="button"><span class="fas fa-eye"></span></button>
                                    </div>
                                </div>
                                @error('f_password_new')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @else
                            <div class="form-group col-sm">
                                <label for="f_password" class="form-control-label">* @lang('gestor_usuario.password')</label>
                                <div class="input-group">
                                    <input name="f_password" id="f_password" type="password" value="" class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password')">

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
                                    <input name="f_password_confirmation" id="f_password_confirmation" type="password" value="" class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_usuario.password_confirmation')">
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
                            @endif
                        </div>
                        <div class="form-row">
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
                            <div class="form-group col-sm">
                                <label for="f_tipo" class="form-control-label">* @lang('gestor_usuario.tipo')</label>
                                <select name="f_tipo" id="f_tipo" class="form-control selectpicker-custom" title="@lang('gestor_usuario.tipo')">
                                    <option value="">@lang('gestor_usuario.tipo')</option>
                                    @foreach($usuario->present()->makeTipoAll as $tip_k => $tip_v)
                                    @if($tip_k >= auth('gestor')->user()->tipo)
                                    <option value="{{ $tip_k }}" data-icon="fa-{{ $tip_v[1] }}" {{ $tip_k == (old('f_tipo') ? old('f_tipo') : $usuario->tipo) ? ' selected' : '' }}>{{ $tip_v[0] }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('f_tipo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-2">
                <div class="card">
                    <div class="card-header h5">@lang('gestor_usuario.informacoes')</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="f_nome" class="form-control-label">* @lang('gestor_usuario.nome')</label>
                                <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') :$usuario->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_usuario.nome')">
                                @error('f_nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('gestor.usuarios.permissoes')
            <div class="py-2 pb-5 text-center">
                <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
                <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
            </div>
        </div>
        @include('gestor.usuarios.logs')
    </div>
</form>
@endsection
