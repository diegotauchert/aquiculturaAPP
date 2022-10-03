@if($coberturas && $coberturas->count() > 0)
<div id="coberturas" class="my-4">
    <div class="container-fluid py-3">
        <h2 class="mb-4">Coberturas</h2>

        <div class="row">
            <div class="d-block d-md-flex">
                <div class="w-100 w-md-57 mr-2">
                    <div class="d-flex gap-2">
                        @foreach($coberturas->get() as $k => $post)
                        <div class="mr-md-2">
                            <div class="infobox">
                                @if($post->anexos)
                                @if($post->anexos->where('tipo', 1)->count() > 0)
                                @if($post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto)
                                <div class="thumbnail">
                                    <a href="{{ route('web.cobertura.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}" class="thumb-href">
                                        <img src="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url(['w' => 300]) }}" />
                                    </a>
                                </div>
                                @endif
                                @endif
                                @endif
                                <div class="text mt-3 w-100">
                                    <a href="{{ route('web.cobertura.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}" style="font-size:16px;">
                                        <strong>{{ $post->nome }}</strong>
                                    </a>
                                    <a href="{{ route('web.cobertura.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->local }}">
                                        {{ $post->local }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="px-4 px-md-0">
                        <div class="btn-cobertura flex itens-start w-100 mt-4 text-center">
                            <a href="{{ route('web.cobertura') }}" class="btn-main ml-0 mr-4 w-90 d-block">
                                <i class="fas fa-plus"></i> @lang('web.todos')
                            </a>
                        
                            <a href="/" class="btn-main ml-2 mr-5 w-90 d-block">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </div>
                    </div>
                </div>
                <div class="banners-cobertura flex w-43 ml-4 gap-2 mt-5 mt-md-0">
                    <div>
                        <img src="{{ asset(mix('images/banner-vest.jpg')) }}" class="w-100 img-border" />
                    </div>
                    <div>
                        <img src="{{ asset(mix('images/banner-vest.jpg')) }}" class="w-100 img-border" />
                    </div>
                    <div class="d-block d-md-none">
                        <img src="{{ asset(mix('images/banner-vest.jpg')) }}" class="w-100 img-border" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif