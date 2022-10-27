@extends('layouts.gestor.publica')

@section('title', __('gestor_dashboard.fazer_login'))

@section('content')
<div id="login">
    <form class="form-horizontal auth-form my-4" method="POST" action="{{ route('gestor.login', ['next' => $next]) }}">
        @csrf

        @if (session('alert'))
        @alert(['type' => session('alert')['type']])
        {!! session('alert')['message'] !!}
        @endalert
        @endif
        <div class="form-group">
            <label for="f_login">@lang('gestor_dashboard.login')</label>
            <div class="input-group mb-3">
                <span class="auth-form-icon">
                    <i class="dripicons-user"></i>
                </span>
                <input name="f_login" type="text" id="f_login" class="form-control @error('f_login') is-invalid @enderror" value="{{ old('f_login') }}" maxlength="250" placeholder="@lang('gestor_dashboard.title_login')">
            </div>
            @error('f_login')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="f_password">@lang('gestor_dashboard.password')</label>
            <div class="input-group mb-3">
                <span class="auth-form-icon">
                    <i class="dripicons-lock"></i>
                </span>
                <input name="f_password" type="password" id="f_password" class="form-control @error('f_password') is-invalid @enderror" value="{{ old('f_password') }}" maxlength="100" placeholder="@lang('gestor_dashboard.title_password')">
            </div>
            @error('f_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="dripicons-enter mr-1" style="vertical-align: sub;"></i> @lang('gestor_dashboard.entrar')</button>
        <a href="{{ route('gestor.register', ['next' => $next]) }}" class="btn btn-lg btn-info btn-block"><i class="dripicons-user mr-1" style="vertical-align: sub;"></i> Cadastre-se</a>
        <a href="{{ route('gestor.password', ['next' => $next]) }}" class="btn btn-sm btn-block"><i class="dripicons-lock-open mr-1" style="vertical-align: sub;"></i> @lang('gestor_dashboard.perdeu_password')</a>
    </form>
</div>
@endsection
