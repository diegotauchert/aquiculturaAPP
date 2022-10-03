@extends('layouts.gestor.app')

@section('title', __('gestor_perfil.subtitulo') . ' - ' . __('gestor_perfil.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_perfil.titulo')
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor_perfil.subtitulo')</small>
        </h1>
    </div>
</div>
<form method="POST" action="{{ route('gestor.editar-perfil-post') }}" enctype="multipart/form-data">
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
                                <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $usuario->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_usuario.nome')">
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
            <div class="py-2">
                <div class="card">
                    <div class="card-header h5">@lang('gestor_usuario.foto_perfil')</div>
                    <div class="card-body">
                        <div class="upload-anexos-unique" data-up-tipo="foto" data-up-link="editar-perfil" data-up-id="{{ $usuario->id }}" data-up-nome="foto" data-up-class="col-md-4 my-auto py-3">
                            <div class="list-group uploads pb-2"></div>
                            <div class="files-itens files-ordem row pt-2">
                                @include('gestor.usuarios.perfil-foto')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-2 pb-5 text-center">
                <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
                <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
            </div>
        </div>
        @include('gestor.usuarios.logs')
    </div>
</form>
@endsection
