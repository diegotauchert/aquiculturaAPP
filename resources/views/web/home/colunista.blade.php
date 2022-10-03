@if($colunistas && $colunistas->count() > 0)
<div id="colunistas">
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h2>Colunistas</h2>
            </div>
        </div>

        <div class="row">
            @foreach($colunistas->get() as $k => $post)
            <div class="col-sm-6 col-lg-4 col-xl-4 col-md-6 px-2 px-md-4 pt-3 m-auto @if($k > 1) d-none d-md-block @endif">
                <div class="infobox">
                    @if($post->anexos)
                    @if($post->anexos->where('tipo', 1)->count() > 0)
                    @if($post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto)
                    <div class="thumbnail d-block d-md-flex">
                        <a href="{{ route('web.colunista.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}" class="thumb-href mr-3">
                            <img src="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url(['w' => 300]) }}" class="img-colunista" style="min-height: 250px;" />
                        </a>
                        <span class="d-block mt-2">
                            <strong>Por</strong><br /><em>{{ $post->autor }}</em>
                        </span>
                    </div>
                    @endif
                    @endif
                    @endif
                    <div class="text mt-3 w-100">
                        <a href="{{ route('web.colunista.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}">
                            <strong class="h4" style="font-weight:800;">{{ $post->nome }}</strong><br/>
                            <small><em>{{ $post->categoria->nome }}</em></small>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="flex container-fluid py-3 ml-auto colunista-banner">
    <a href="{{ route('web.colunista') }}" class="btn-main">
        <i class="fas fa-plus"></i> @lang('web.todos')
    </a>

    <a href="/" class="btn-main">
        <i class="fas fa-home"></i> Home
    </a>
</div>

<div class="flex items-center container-fluid p-3 gap-1 gap-md-4 w-100">
    <div>
        <img src="{{ asset(mix('images/banner.jpg')) }}" class="w-100 img-border" />
    </div>
    <div>
        <img src="{{ asset(mix('images/banner.jpg')) }}" class="w-100 img-border" />
    </div>
</div>