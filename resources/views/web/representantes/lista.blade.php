@extends('layouts.web.app')

@section('title', $pagina->nome)

@section('seo_keyword')
@if($pagina->seo_keyword)
<meta name="keywords" content="{{ $pagina->seo_keyword }}">
@else
@parent
@endif
@stop
@section('seo_description')
@if($pagina->seo_description)
<meta name="description" content="{{ $pagina->seo_description }}">
@else
@parent
@endif
@stop

@section('content')
<div class="bg-primary text-white page-banner py-5 @if($pagina) {{ $pagina->link }} @endif">
    <div class="container-fluid">
        <h1 class="h1 m-0">{{ $pagina->nome }}</h1>
    </div>
</div>
@if($pagina->texto_full == 1 && $pagina->texto)
<div class="container-fluid py-5 text-tertiaty">
    <div class="row d-flex">
        {!! $pagina->texto !!}
    </div>
</div>
@else
@if($pagina->texto)
<div class="container-fluid py-5 text-tertiaty">
    <div class="row d-flex">
        {!! $pagina->texto !!}
    </div>
</div>
@endif
@endif
<div class="bg-tertiary">
@include('web.representantes.mapa')
</div>
@endsection
