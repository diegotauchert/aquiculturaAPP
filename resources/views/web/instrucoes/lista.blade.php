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
<div class="bg-primary text-white py-5 page-banner">
    <div class="container-fluid">
        <h1 class="h1 m-0">{{ $pagina->nome }}</h1>
    </div>
</div>
<div class="container-fluid py-5 text-secondary">
    <div class="row">
        <div class="col-md">
                {!! $pagina->texto !!}
        </div>
        @if($pagina->anexos)
        @include('web.instrucoes.fotos', ['anexos' => $pagina->anexos->where('tipo', 1)->sortBy('ordem')])
        @endif
    </div>
</div>
@endsection
