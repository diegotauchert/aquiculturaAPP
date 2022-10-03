@extends('layouts.gestor.publica')

@section('title', __('gestor_dashboard.recuperar_password'))

@section('content')
<div id="login">
    <form class="form-horizontal auth-form my-4" method="POST" action="{{ route('gestor.password', ['next' => $next]) }}">
        @csrf

        @if (session('alert'))
        @alert(['type' => session('alert')['type']])
        {!! session('alert')['message'] !!}
        @endalert
        @endif

        <div class="form-group">
            <label for="f_login">@lang('gestor_dashboard.email')</label>
            <div class="input-group mb-3">
                <span class="auth-form-icon">
                    <i class="dripicons-card"></i>
                </span>
                <input name="f_email" type="email" id="f_email" class="form-control @error('f_email') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_dashboard.title_email')">
            </div>
            @error('f_email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('gestor_dashboard.recuperar_password')</button>
        <a href="{{ route('gestor.login', ['next' => $next]) }}" class="btn btn-sm btn-block"><span class="fas fa-chevron-left"></span> @lang('gestor_dashboard.voltar')</a>
    </form>
</div>
@endsection
