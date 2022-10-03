@extends('layouts.gestor.publica')

@section('content')
<div class="text-center">
    <h1 class="py-4 text-primary">@yield('code', __('#')) <small class="text-muted"> - @yield('title', __('Erro'))</small></h1>
    <p class="pt-2 pb-4">@yield('message')</p>
    <p>
        <a href="{{ url('/') }}" class="btn btn-outline-primary" title="@lang('gestor_dashboard.voltar')"><span class="fas fa-chevron-left"></span> @lang('gestor_dashboard.voltar')</a>
    </p>
</div>
@endsection
