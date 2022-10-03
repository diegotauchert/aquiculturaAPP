@extends('layouts.web.app')

@section('title', ($post->nome ? $post->nome . ' - ' : '') . $pagina->nome)

@section('seo_keyword')
@if($post->seo_keyword)
<meta name="keywords" content="{{ $post->seo_keyword }}">
@else
@parent
@endif
@stop
@section('seo_description')
@if($post->seo_description)
<meta name="description" content="{{ $post->seo_description }}">
@else
@parent
@endif
@stop

@section('content')
<div class="wrapper pt-5 blogs section-svg blog-internal" id="blog">
    <div class="row">
        <div class="container-fluid px-3">
            <h2>{{$view}}</h2>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-lg">
                <div class="btn-group py-3">
                    <a target="_blank"
                        href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&display=popup&src=share_button"
                        data-toggle="tooltip" title="@lang('web.compartilhar_facebook')"
                        class="btn btn-facebook" style="font-size: 12px"><i class="fab fa-facebook"></i>
                        @lang('web.compartilhar')</a>
                    
                    <a target="_blank" href="https://api.whatsapp.com/send?text={{ $post->nome }} {{ url()->current() }}"
                        data-toggle="tooltip" title="@lang('web.compartilhar_whatsapp')"
                        class="btn btn-whatsapp" style="font-size: 12px"><i class="fab fa-whatsapp"></i>
                        @lang('web.compartilhar')</a>
                </div>
                <div class="row pb-3">
                    <div class="col-md">
                        <h2 class="h2 m-0 pt-3">{{ $post->nome }}</h2>
                    </div>

                    <div class="col-md-auto text-right">
                        @if($post->data)
                        <div class="row">
                            <div class="col-auto my-auto py-2">
                                <p class="text-primary m-0" title="@lang('web_blog.data')">
                                    <small>
                                        <i class="fas fa-calendar-alt"></i>
                                        @date($post->data)
                                    </small>
                                </p>
                            </div>
                            <div class="col-auto my-auto py-2">
                                <p class="text-primary m-0" title="@lang('web_blog.data')">
                                    <small>
                                        <i class="fas fa-clock"></i>
                                        @time($post->data)
                                    </small>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="blog-description internal-description" id="blog-internal">
                    {!! $post->texto !!}
                </div>

                @if($post->anexos)
                @if($post->anexos->where('tipo', 2)->count() > 0)
                <p class="pt-5 pb-2 text-secondary h3">@lang('web_blog.anexos')</p>
                <div class="list-group">
                    @php
                    $k = 0;
                    @endphp
                    @foreach($post->anexos->where('tipo', 2)->sortBy('ordem') as $arquivo)
                    @if($arquivo->arquivo)
                    @php
                    $k++;
                    @endphp
                    <a href="{{ $arquivo->arquivo->url() }}" target="_blank" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-pdf"></i> {{ $arquivo->descricao ?? 'Anexo ' . $k }}
                    </a>
                    @endif
                    @endforeach
                </div>
                @endif
                @endif
                @if($post->anexos)
                @if($post->anexos->where('tipo', 1)->count() > 0)
                <h2 class="tit-h2">
                    <i class="fas fa-camera"></i>
                    @lang('web_blog.fotos')
                </h2>
                <div class="row lightgallery-photo">
                    @foreach($post->anexos->where('tipo', 1)->sortBy('ordem') as $foto)
                    @if($foto->foto)
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 my-auto py-2">
                        <div class="card border-0">
                            <img src="{{ $foto->foto->url(['w'=>400]) }}" alt="{{ $foto->descricao }}" class="card-img">
                            @if($foto->descricao)
                            <div class="card-body p-2 text-center">
                                <p class="m-0">{{ $foto->descricao }}</p>
                            </div>
                            @endif
                            <a href="{{ $foto->foto->url() }}" title="{{ $foto->descricao }}" class="stretched-link"><img
                                    src="{{ $foto->foto->url(['w'=>400]) }}" alt="{{ $foto->descricao }}"
                                    class="d-none"></a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
                @endif

                @if($post->video)
                <div class="row py-1 w-100">
                    <div class="container-fluid py-5">
                        <div class="row d-flex">
                            <iframe width="100%" height="600" src="https://www.youtube.com/embed/{{ str_replace("https://www.youtube.com/watch?v=","",$post->video) }}?modestbranding=1&cc_load_policy=1&controls=0&showinfo=0&rel=0" frameborder="0" allow="accelerometer; autoplay; gyroscope;" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @include('web.blog.lateral')
        </div>
    </div>
</div>
@include('web.home.newsletter')
@endsection
