<?php use App\Gestor\Util; ?>
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
<div class="wrapper pt-5 depoimentos bg_1" id="depoimento">
    <div class="row pt-5">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-5 pt-5 tits">
            <h2 class="sub-tit title-bg text-center">@lang('web.depoimento')</h2>
            <h3 class="">@lang('web_depoimento.leia')</h3>
            <p class="">@lang('web_depoimento.tit_desc')</p>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-lg">
                {!! $pagina->texto !!}
                @if($depoimentos->count() > 0)
                <div class="row">
                    @foreach($depoimentos as $depoimento)
                    <div class="col-sm-6 col-xl-4 my-auto py-3 text-center">
                        <div class="card">
                            <div class="card-body">
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
                    @endforeach
                </div>
                {{ $depoimentos->appends(['f_q' => $f_q])->onEachSide(2)->links('vendor.pagination.bootstrap-4-min') }}
                @else
                <p class="text-center py-5 h4">@lang('web.no_data')</p>
                @endif
            </div>
        </div>
    </div>
</div>
@include('web.home.newsletter')
@endsection
