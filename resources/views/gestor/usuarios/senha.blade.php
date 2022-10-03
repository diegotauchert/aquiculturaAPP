@extends('layouts.gestor.app')

@section('title', __('gestor_perfil.subtitulo') . ' - ' . __('gestor_perfil.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_senha.titulo')
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor_senha.subtitulo')</small>
        </h1>
    </div>
</div>
<form method="POST" action="{{ route('gestor.mudar-senha-post') }}">
    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_usuario.informacoes_acesso')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="f_password_current" class="form-control-label">* @lang('gestor_senha.password_current')</label>
                        <div class="input-group">
                            <input name="f_password_current" id="f_password_current" type="password" value="" class="form-control @error('f_password_current') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_senha.password_current')">
                            <div class="input-group-append">
                                <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')" type="button"><span class="fas fa-eye"></span></button>
                            </div>
                        </div>
                        @error('f_password_current')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_password_new" class="form-control-label">* @lang('gestor_senha.password_new')</label>
                        <div class="input-group">
                            <input name="f_password_new" id="f_password_new" type="password" value="" class="form-control @error('f_password_new') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_senha.password_new')">

                            <div class="input-group-append">
                                <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')" type="button"><span class="fas fa-eye"></span></button>
                            </div>
                        </div>
                        @error('f_password_new')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_password_new_confirmation" class="form-control-label">* @lang('gestor_senha.password_new_confirmation')</label>
                        <div class="input-group">
                            <input name="f_password_new_confirmation" id="f_password_new_confirmation" type="password" value="" class="form-control @error('f_password_new') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_senha.password_new_confirmation')">
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
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
