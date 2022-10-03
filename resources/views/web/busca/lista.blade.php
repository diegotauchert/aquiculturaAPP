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
<div class="wrapper" id="busca">
    <div class="row">
        <div class="container-fluid p-0">
            <div class="col-xs-12 col-sm-12 col-md-12 mb-5 mt-5 tits">
                <h2>
                    {{ $pagina->nome }}
                    @if($palavra) / {{ $palavra }}
                    @endif
                </h2>
            </div>
        </div>
    </div>
    
    <div class="container-fluid py-5">
        {!! $pagina->texto !!}
        @if($buscas->count() > 0)
        <div class="row">
            @foreach($buscas->sortBy('nome') as $k => $busca)
            <div class="col-md-4 my-auto py-2">
                <div class="card">
                    <!-- @if($busca instanceof \App\Models\Depoimento)
                    <div class="card-body">
                        <p class="h4">{{ $busca->nome }}</p>

                        <div class="pt-2 f-80">{!! $busca->descricao !!}</div>

                        @if($busca->seo_description)
                        <div class="pt-2 f-80">{!! $busca->seo_description !!}</div>
                        @endif

                        @if($busca->nota)
                        @for($i = 0; $i < $busca->nota; $i++)
                            <i class="fas fa-star text-yellow"></i>
                        @endfor
                        @endif
                        <p class="pt-2">
                            <a href="{{ route('web.depoimento.id', [$busca->id, Sanitize::string($busca->nome)]) }}" class="w-auto btn-small btn-main stretched-link text-uppercase f-80" target="_blank"><i class="fa fa-eye" style="font-size:13px;"></i> @lang('web_depoimento.titulo')</a>
                        </p>
                    </div>
                    @endif -->
                    
                    @if($busca)
                    <div class="card-body">
                        @if($busca->anexos)
                        @if($busca->anexos->where('tipo', 1)->count() > 0)
                        @if($busca->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto)
                        <div class="thumbnail">
                            <a href="{{ route('web.blog.id', [$busca->id, Sanitize::string($busca->nome)]) }}" title="{{ $busca->nome }}" class="thumb-href">
                                <img src="{{ $busca->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url(['w' => 300]) }}" />
                            </a>
                        </div>
                        @endif
                        @endif
                        @endif

                        @if($busca->data)
                        <small class="mt-3 d-block">{{ $busca->data->format('d/m/Y') }}</small>
                        @endif

                        <h5 class="mt-1">{{ $busca->nome }}</h5>
                        <h5 class="mt-1">{{ $busca->seo_description }}</h5>

                        <p class="pt-2 text-center">
                            <a href="{{ route('web.blog.id', [$busca->id, Sanitize::string($busca->nome)]) }}" class="w-auto btn-small btn-main stretched-link text-center f-80" target="_blank"><i class="fa fa-eye" style="font-size:13px;"></i> Ver Mais</a>
                        </p>
                    </div>
                    @endif
<!-- 
                    @if($busca instanceof \App\Models\Pagina)
                    <div class="card-body">
                        <p class="h4">{{ $busca->nome }}</p>
                        @if($busca->seo_description)
                        <div class="pt-2 f-80">{!! $busca->seo_description !!}</div>
                        @endif

                        <p class="pt-2">
                            <a href="{{ route('web.pagina', [$busca->link]) }}" class="w-auto btn-small btn-main stretched-link text-uppercase f-80" target="_blank"><i class="fa fa-eye" style="font-size:13px;"></i> @lang('web.pagina')</a>
                        </p>
                    </div>
                    @endif -->
                </div>
            </div>
            @endforeach
        </div>
        <div class="pt-3">
            {{ $buscas->appends(['p' => $palavra])->onEachSide(2)->links('vendor.pagination.bootstrap-4-min') }}
        </div>
        @else
        <p class="text-center py-5 h4">@lang('web.no_data')</p>
        @endif
    </div>
</div>
@include('web.home.newsletter')
@endsection
