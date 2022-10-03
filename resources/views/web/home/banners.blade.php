<div class="w-100">
    <div class="flex">
        <h2>Destaques</h2>
        <ol class="carousel-indicators">
            @foreach($banners->get() as $k => $banner)
            <li data-target="#banners" data-slide-to="{{ $k }}" @if($k==0) class="active" @endif></li>
            @endforeach
        </ol>
    </div>
    @if($banners->count() > 0)
    <div class="infobox">
        <div id="banners" class="carousel slide" data-interval="5000" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @foreach($banners->get()->where('situacao','=','1') as $k => $banner)
                <div class="carousel-item @if($k == 0) active @endif">
                    @if($banner->video)
                    @php
                    $video = str_replace("https://www.youtube.com/watch?v=","",$banner->video);
                    @endphp
                    <iframe 
                        src="https://www.youtube.com/embed/{{$video}}?playlist={{$video}}&listType=playlist&controls=0&showinfo=0&autoplay=1&loop=1&fs=0&rel=0&iv_load_policy=3&start=5&end=40&version=3&modestbranding=1&enablejsapi=1&origin={{env('APP_URL')}}" 
                        frameborder="0" 
                        allowfullscreen
                        allow="accelerometer; autoplay; encrypted-media;"
                        id="video-youtube"
                    ></iframe>

                    @else
                    <div class="img-banner-shadow">
                        <div class="img-banner">
                            @if($banner->arquivo)
                            <img class="@if($banner->responsivo) d-none d-md-block @endif" src="{{ $banner->arquivo->url() }}" alt="{{ $banner->nome }}" />
                            @endif
                            @if($banner->responsivo)
                            <img class="@if($banner->arquivo) d-block d-md-none @endif" src="{{ $banner->responsivo->url() }}" alt="{{ $banner->nome }}" />
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="text-white text-left mt-3 mb-2">
                        <p class="bold h5 pl-2 mb-0 pb-0">{{ $banner->nome }}</p>
                        @if($banner->categoria)
                            <span class="pl-2">{{ $banner->categoria }}</span>
                        @endif
                        @if($banner->texto)
                            <span class="pl-2" style="display: block;line-height: 1.1rem;font-size: 15px;">{!! implode(' ', array_slice(explode(' ', strip_tags($banner->texto)), 0, 40)) !!}</span>
                        @endif

                        @if($banner->link)
                        <p class="d-sm-block float-right">
                            <a href="{{ $banner->link }}" {{ $banner->present()->alvo }} title="@lang('web.concorra')" {{ $banner->present()->alvo }} class="f-80 mt-3 w-auto ml-0 px-2">
                                <i class="fa fa-plus"></i> Saiba Mais
                            </a>
                        </p>
                        @endif
                        @if($banner->video)
                        <p class="d-sm-block float-right">
                            <a href="{{ $banner->video }}" target="_blank" title="Ver Video" class="f-80 mt-3 w-auto ml-0 px-2">
                                <i class="fab fa-youtube"></i> Ver Video
                            </a>
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <a class="control-arrow carousel-control-prev p-4" href="#banners" role="button" data-slide="prev">
                <i class="fas fa-chevron-left d-block d-md-none"></i>
                <i class="fas fa-chevron-left fa-2x d-none d-md-block"></i>
            </a>
            <a class="control-arrow carousel-control-next p-4" href="#banners" role="button" data-slide="next">
                <i class="fas fa-chevron-right d-block d-md-none"></i>
                <i class="fas fa-chevron-right fa-2x d-none d-md-block"></i>
            </a>
        </div>
    </div>
    @endif

    <div class="banner-ad mt-4">
        <img src="{{ asset(mix('images/banner.jpg')) }}" class="w-100" />
    </div>
</div>