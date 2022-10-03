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
<div class="wrapper">
    <div class="row">
        <div class="container-fluid px-3">
            <h2>{{$tit[0]}}</h2>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-lg">
                {!! $pagina->texto !!}
                @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                    <div class="col-sm-6 col-xl-4 mb-auto mt-1 pb-3">
                        <div class="infobox">
                            <div class="card border-0">
                                @if($post->anexos)
                                @if($post->anexos->where('tipo', 1)->count() > 0)
                                @if($post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto)
                                <div style="max-height:220px;overflow:hidden;" class="card shadow">
                                    <a href="{{ route($view.'.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}" style="height:300px;object-fit:cover;">
                                        <img class="img-fluid card-body p-2" style="height: 100%;object-fit:cover;"
                                            src="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url(['w' => 400]) }}" alt="{{ $post->nome }}" />
                                    </a>
                                </div>
                                @endif
                                @endif
                                @endif
                                <div class="card-body">
                                    <div class="d-flex gap-2">
                                        @if($post->data)
                                        <small class="p-0 m-0 d-flex"><i class="fas fa-calendar-alt mr-2"></i> @date($post->data)</small>
                                        @endif

                                        @if($post->categoria)
                                        <small class="d-block ml-auto truncate" style="font-size:11px;" title="{{ $post->categoria->nome }}"><strong>{{ $post->categoria->nome }}</strong></small>
                                        @endif 
                                    </div>

                                    <hr class="divisor" />
                                   
                                    <a href="{{ route($view.'.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}">
                                        <strong class="h5 bold d-block p-0 m-0">{{ $post->nome }}</strong>
                                    </a>

                                    @if($post->seo_description)
                                    <hr class="divisor" />
                                    <p class="p-0 m-0">
                                        <a href="{{ route($view.'.id', [$post->id, Sanitize::string($post->nome)]) }}" title="{{ $post->nome }}">
                                            <small>{{ $post->seo_description }}</small>
                                        </a>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $posts->appends(['f_q' => $f_q])->onEachSide(2)->links('vendor.pagination.bootstrap-4-min') }}
                @else
                <p class="text-center py-5 h4">@lang('web.no_data')</p>
                @endif
            </div>
            @include('web.blog.lateral')
        </div>
    </div>
</div>
@include('web.home.newsletter')
@endsection
