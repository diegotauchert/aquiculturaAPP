@if($agendas && $agendas->count() > 0)
<div id="agenda">
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h2>Agenda</h2>
            </div>
        </div>

        <div class="row">
            @foreach($agendas->get() as $k => $post)
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 px-md-4 pt-3 m-auto @if($k > 1) d-none d-md-block @endif">
                <div class="infobox">
                    @if($post->anexos)
                    @if($post->anexos->where('tipo', 1)->count() > 0)
                    @if($post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto)
                    <div class="thumbnail">
                        <a href="{{ route('web.agenda.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}" class="thumb-href">
                            <img src="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url(['w' => 300]) }}" />
                        </a>
                    </div>
                    @endif
                    @endif
                    @endif
                    <div class="text mt-3 w-100">
                        <a class="nome" href="{{ route('web.agenda.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}">
                            <strong>{{ $post->nome }}</strong>
                        </a>
                        <a class="local" href="{{ route('web.agenda.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}">
                            {{ $post->local }}
                        </a>
                        <a  class="data" href="{{ route('web.agenda.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}">
                            <strong>{{ $post->data->format('d/m') }}</strong>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="d-block d-md-flex items-center container-fluid py-3">
    <div class="banner-ad col-sm-12 col-lg-6 col-xl-6 col-md-6 mb-4 mb-md-0">
        <img src="{{ asset(mix('images/banner.jpg')) }}" class="w-100" />
    </div>
    <div class="flex itens-start col-sm-12 col-lg-6 col-xl-6 col-md-6">
        <a href="{{ route('web.agenda') }}" class="btn-main">
            <i class="fas fa-plus"></i> @lang('web.todos')
        </a>
    
        <a href="/" class="btn-main">
            <i class="fas fa-home"></i> Home
        </a>
    </div>
</div>
@else
<p class="p-5 text-center h4"><i class="fas fa-exclamation-triangle mr-2"></i>Sem agenda no momento</p>
@endif