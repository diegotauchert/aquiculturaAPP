@extends('layouts.web.app')

@section('title', ($depoimento->nome ? $depoimento->nome . ' - ' : '') . $pagina->nome)

@section('seo_keyword')
@if($depoimento->seo_keyword)
<meta name="keywords" content="{{ $depoimento->seo_keyword }}">
@else
@parent
@endif
@stop
@section('seo_description')
@if($depoimento->seo_description)
<meta name="description" content="{{ $depoimento->seo_description }}">
@else
@parent
@endif
@stop

@section('content')
<div class="wrapper pt-5 depoimentos section-svg" id="depoimentos">
    <div class="row pt-5">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-5 pt-5 tits">
            <h2 class="sub-tit title-bg text-center">@lang('web.depoimento')</h2>
            <h3 class="">@lang('web_depoimento.leia')</h3>
            <p class="">@lang('web_depoimento.tit_desc')</p>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row justify-content-md-center">
            <div class="col-sm-8 col-xl-6 py-3 text-center">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="btn-group py-3 social-network">
                            <a target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&display=popup&src=share_button"
                                data-toggle="tooltip" title="@lang('web.compartilhar_facebook')" class="btn btn-primary btn-sm btn-facebook"><span
                                    class="fab fa-facebook"></span>
                                @lang('web.compartilhar')</a>
                            <a target="_blank" href="https://api.whatsapp.com/send?text={{ $depoimento->nome }} {{ url()->current() }}"
                                data-toggle="tooltip" title="@lang('web.compartilhar_whatsapp')" class="btn btn-primary btn-sm btn-whatsapp"><span
                                    class="fab fa-whatsapp"></span>
                                @lang('web.compartilhar')</a>
                        </div>
                        @if($depoimento->foto)
                        <div class="thumb">
                            <img src="{{ $depoimento->foto->url() }}" alt="{{ $depoimento->nome }}" />
                        </div>
                        @endif
                        <div class="p-3 mt-auto w-100 depoimento-description">
                            @if($depoimento->nota)
                            @for($i = 0; $i < $depoimento->nota; $i++)
                            <i class="fas fa-star text-yellow"></i>
                            @endfor
                            @endif

                            <a href="{{ route('web.depoimento.id', [$depoimento->id, Sanitize::string($depoimento->nome)]) }}" title="{{ $depoimento->nome }}" class="mt-3 d-block">
                                <span class="h6 d-block p-0 m-0 text-black">{{ $depoimento->nome }}</span>
                            </a>

                            @if($depoimento->descricao)
                            <div class="pt-2 mt-2 depo-desc">
                                <a href="{{ route('web.depoimento.id', [$depoimento->id, Sanitize::string($depoimento->nome)]) }}" title="{{ $depoimento->nome }}">
                                <i class="fas fa-quote-right"></i>
                                {!! $depoimento->descricao !!}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('web.home.newsletter')
@endsection
