<div class="d-block d-md-flex container-fluid py-3 mb-5">
    @if($promocao && $promocao->count() > 0)
    <div class="promocao-box w-35 m-auto">
        <div id="promocoes">
            <div class="container-fluid py-3">
                <h2 class="mb-3">Promoções</h2>

                <div class="row mb-4">
                    @foreach($promocao->get() as $k => $post)
                    <div class="infobox">
                        @if($post->anexos)
                        @if($post->anexos->where('tipo', 1)->count() > 0)
                        @if($post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto)
                        <div class="thumbnail">
                            <a href="{{ route('web.blog.promocao.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}" class="thumb-href mr-3">
                                <img src="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url(['w' => 300]) }}" />
                            </a>
                        </div>
                        @endif
                        @endif
                        @endif
                        <div class="text mt-3 w-100">
                            <a href="{{ route('web.blog.promocao.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}">
                                <strong class="">{{ $post->nome }}</strong><br/>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row">
                    <a href="{{ route('web.blog.promocao') }}" class="btn-main ml-0 mb-4">
                        <i class="fas fa-plus"></i> @lang('web.todos')
                    </a>

                    <a href="/" class="btn-main ml-0 mb-4">
                        <i class="fas fa-home"></i> Home
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($video && $video->count() > 0)
    <div class="video-box w-65 m-auto">
        <div id="video">
            <div class="container-fluid py-3">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h2 class="mb-3">Tv AjuFest</h2>
                    </div>
                </div>

                <div class="row">
                    @foreach($video->get() as $k => $post)
                    <div class="w-100">
                        <div class="infobox">
                            @if($post->video)
                            @php
                            $video = str_replace("https://www.youtube.com/watch?v=","",$post->video);
                            @endphp
                            <iframe 
                                src="https://www.youtube.com/embed/{{$video}}?playlist={{$video}}&listType=playlist&controls=0&showinfo=0&autoplay=0&loop=1&fs=0&rel=0&iv_load_policy=3&start=5&end=40&version=3&modestbranding=1&enablejsapi=1&origin={{env('APP_URL')}}" 
                                frameborder="0" 
                                allowfullscreen
                                autoplay="false"
                                allow="accelerometer; encrypted-media;"
                                id="video-youtube"
                                style="width: 100%;height: 450px;"
                            ></iframe>

                            @else
                            <div class="img-banner">
                                @if($post->arquivo)
                                <img class="d-none d-md-block" src="{{ $post->arquivo->url() }}" alt="{{ $post->nome }}" />
                                @endif
                                @if($post->responsivo)
                                <img class="d-block d-md-none" src="{{ $post->responsivo->url() }}" alt="{{ $post->nome }}" />
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
       
        <div class="container-fluid py-3">
            <img src="{{ asset(mix('images/banner.jpg')) }}" class="w-100 img-border" />
        </div>
    </div>
    @endif
</div>