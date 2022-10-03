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
<div class="bg-primary text-white py-5">
    <div class="container-fluid">
        <h1 class="h1 m-0">{{ $pagina->nome }}</h1>
    </div>
</div>
<div class="container-fluid py-5 text-secondary">
    {!! $pagina->texto !!}
    @if($downloads->count() > 0)
    <p class="pb-3 text-secondary h4">@lang('web_download.arquivos')</p>
    <div class="row">
        <div class="col-md-6">
            <div class="list-group">
                @foreach($downloads->get() as $download)
                @if($download->arquivo)
                <a href="{{ $download->arquivo->url() }}" target="_blank"
                    class="list-group-item list-group-item-action">
                    <span class="fas fa-file-pdf"></span> {{ $download->nome }}
                </a>
                @endif
                @if($download->link)
                <a href="{{ $download->link }}" target="_blank"
                    class="list-group-item list-group-item-action">
                    <span class="fas fa-file"></span> {{ $download->nome }}
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    @else
    <p class="text-center py-5 h4">@lang('web.no_data')</p>
    @endif
</div>
@endsection
