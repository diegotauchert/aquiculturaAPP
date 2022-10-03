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

<div class="wrapper" id="pagina">
    <div class="row">
        <div class="container-fluid p-0">
            <div class="col-xs-12 col-sm-12 col-md-12 tits p-0 mx-3">
                <h2>{{ $pagina->nome }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container-fluid py-5">
            <div class="@if($pagina->anexos->first()) d-flex @endif">
                @if($pagina->anexos->first())
                <div class="mb-3 col-sm-12 col-md-5 col-lg-5">
                    @include('web.pagina.fotos', ['anexos' => $pagina->anexos->where('tipo', 1)->sortBy('ordem')])
                </div>
                <div class="mb-3 col-sm-12 col-md-7 col-lg-7">
                @endif
                    {!! $pagina->texto !!}
                @if($pagina->anexos)
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($pagina->video)
    <div class="row px-5 w-100">
        <div class="container-fluid px-5">
            <div class="row d-flex">
                <iframe width="100%" height="600" src="https://www.youtube.com/embed/{{ str_replace("https://www.youtube.com/watch?v=","",$pagina->video) }}?modestbranding=1&cc_load_policy=1&controls=0&showinfo=0&rel=0" frameborder="0" allow="accelerometer; autoplay; gyroscope;" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    @endif
    @include('web.home.promocoes')
    <div class="pb-5 px-2 container-fluid text-center" id="btn-quote">
        <a href="{{ route('web.contato') }}" class="btn-main btn-small w-auto" title="Fale Conosco" data-toggle="tooltip"><i class="fas fa-envelope"></i> Fale Conosco</a>
    </div>
</div>
@include('web.home.newsletter')
@endsection
