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
                    <div class="col-sm-6 col-xl-6 mb-auto mt-1 pb-3">
                        <div class="infobox">
                            @if($post->video)
                            <iframe width="100%" height="250" src="https://www.youtube.com/embed/{{ str_replace("https://www.youtube.com/watch?v=","",$post->video) }}?modestbranding=1&cc_load_policy=1&controls=0&showinfo=0&rel=0" frameborder="0" allow="accelerometer; autoplay; gyroscope;" allowfullscreen></iframe>
                            @endif
                            <div class="card-body">
                                <div class="d-flex gap-2">
                                    @if($post->data)
                                    <small class="p-0 m-0 d-flex"><i class="fas fa-calendar-alt mr-2"></i> @date($post->data)</small>
                                    @endif

                                    @if($post->categoria)
                                    <small class="d-block ml-auto truncate" style="font-size:11px;"><strong>{{ $post->categoria->nome }}</strong></small>
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
                                        <small class="">{{ $post->seo_description }}</small>
                                    </a>
                                </p>
                                @endif
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
