<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Diego Tauchert">

        <title>@yield('title', '404') - {{ ModelConfig::find('titulo')->valor ?? config('app.name', '') }} - {{ config('app.dev', 'Gestor') }}</title>

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(mix('icons/apple-touch-icon.png')) }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(mix('icons/favicon-32x32.png')) }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(mix('icons/favicon-16x16.png')) }}">
        <link rel="manifest" href="{{ asset(mix('icons/site.webmanifest')) }}">
        <link rel="mask-icon" href="{{ asset(mix('icons/safari-pinned-tab.svg')) }}" color="#014978">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#0280D1">

        <link href="{{ asset(mix('css/login.css')) }}" rel="stylesheet">
        <script type="text/javascript">
            var CONFIG_URL = "{{ url('/') }}";
        </script>
        <script src="{{ asset(mix('js/gestor.js')) }}" defer type="text/javascript"></script>
    </head>

    <body class="account-body accountbg @if(isset($saudacao)){{ str_replace(" ","-",strtolower($saudacao)) }}@endif">
        <div class="row vh-100">
            <div class="auth-page">
                <div class="card auth-card shadow-lg">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="auth-logo-box mt-2">
                                <a title="{{ config('app.client', '') }}" href="#" target="_blank"><img src="{{ asset(mix('images/logo.png')) }}" alt="{{ config('app.client', '') }}" class="logo" style="height:60px;" /></a>
                            </div>
                            <div class="text-center auth-logo-text mt-3 mb-3">
                                @if(isset($saudacao))<span>{{ __('gestor_dashboard.saudacao', ['saudacao' => $saudacao]) }},</span>@endif
                                <h4 class="m-0 p-0">{{ config('app.client') }}</h4>
                            </div>

                            @yield('content')
                            <p class="text-muted text-center py-0 px-1">&copy; {{ config('app.year', '') }} {{ config('app.dev', 'Gestor') }} by <a href="{{ config('app.dev_url', '') }}" target="_blank">{{ config('app.dev_name') }}</a>{{ (app('config')->get('app')['version'] ? ' - v' : '') }}{{ config('app.version', '') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
