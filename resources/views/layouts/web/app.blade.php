<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>
        @if(isset($busca) && $busca->nome) {{$busca->nome.' - '}} @endif 
        @if(isset($pagina) && $pagina->seo_description) {{$pagina->seo_description.' - '}} @endif 
        @if(isset($post) && $post->nome) {{$post->nome.' - '}} @endif 
        {{ ModelConfig::find('titulo')->valor ?? config('app.name', '') }}
    </title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(mix('icons/apple-touch-icon.png')) }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset(mix('icons/apple-touch-icon.png')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(mix('icons/favicon-32x32.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(mix('icons/favicon-16x16.png')) }}">
    <link rel="manifest" href="{{ asset(mix('icons/site.webmanifest')) }}">
    <link rel="mask-icon" href="{{ asset(mix('icons/safari-pinned-tab.svg')) }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css2?family=KoHo:wght@600&display=swap" rel="stylesheet">

    @section('seo_keyword')
    <meta name="keywords" content="{{ ModelConfig::find('seo_keyword')->valor ?? '' }}">
    @show
    @section('seo_description')
    <meta name="description" content="{{ ModelConfig::find('seo_description')->valor ?? '' }}">
    @show

    <meta property="og:locale" content="pt_BR">
    
    <meta property="og:url" content="{{env('APP_URL')}}">

    <meta property="og:title" content="{{env('CLIENTE_NOME')}}">
    <meta property="og:site_name" content="{{env('CLIENTE_NOME')}}">

    <meta property="og:description" content="{{env('CLIENTE_DESCRICAO')}}">

    <meta property="og:image" content="{{env('APP_URL')}}/images/logo-social.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">

    <meta property="og:type" content="website">

    <link href="{{ asset(mix('css/web.css')) }}" rel="stylesheet">
    <link href="assets/stmicons/stmicons.css" rel="stylesheet">

    <script type="text/javascript">
        var CONFIG_URL = "{{ url('/') }}";
    </script>

    <script src="{{ asset(mix('js/web.js')) }}" type="text/javascript"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    
</head>

<body class="{{ (Request::segment(1)) ? Request::segment(1) : 'home' }}">
    <header>
        <div class="topo w-100 mt-4">
            <div id="header-bottom">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-auto col-md-auto my-auto mr-auto logo py-1">
                            <div id="logo" class="mr-auto text-hide"><a href="{{ route('web.home') }}" title="{{ config('app.client', '') }}">{{ config('app.client', '') }}</a></div>
                        </div>
                        <div class="col-auto col-md py-2 my-auto">
                            <div class="menu">
                                <nav class="navbar navbar-expand-lg p-0 h-100">
                                    <div class="navbar-toggler border-0 ml-auto p-0">
                                        <button class="btn btn-lg btn-outline-secondary border-0 px-3 text-white bars-menu" type="button" data-toggle="offcanvas">
                                            <i class="fas fa-bars"></i><span class="d-none d-sm-inline-block text-uppercase">&nbsp;@lang('web.menu')</span>
                                        </button>
                                    </div>
                                    <div class="navbar-collapse offcanvas-collapse h-100" id="menu">
                                        <div class="navbar-toggler border-0 py-2 pr-0 text-right">
                                            <button class="btn btn-lg btn-outline-secondary border-0 px-3 text-white" type="button" data-toggle="offcanvas">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="form-busca d-block d-md-none pt-2 pb-4">
                                            <div class="logo-site p-3 w-100 mb-4">
                                                <a href="{{ route('web.home') }}" title="{{config('app.client', '')}}" class="text-center d-block">{{config('app.client', '')}}</a>
                                            </div>
                                        </div>

                                        @include('components.web.menu')
                                    </div>
                                </nav>
                            </div>
                        </div>

                        <div class="col-md-auto ml-auto mt-3" id="form_search">
                            <div class="dropdown open">
                                <div aria-labelledby="dropdown_busca">
                                    <form action="{{ url(route('web.busca')) }}" method="get" name="form_bus">
                                        <div class="input-group input-group-lg">
                                            <input name="p" id="p" type="search" class="form-control input-search" value="{{ $palavra ?? '' }}" placeholder="Pesquisar" aria-label="@lang('web.busca')" value="" />
                                            <div class="input-group-append">
                                                <button class="border-0 shadow" type="submit"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section id="conteudo">
        @yield('content')
    </section>
    <footer>
        <div class="copyright text-white text-center uppercase">
            <div class="container-fluid py-2">
                <p class="text-center m-0">&COPY; Copyright {{ config('app.year', '') }} - Todos os direitos reservados</p>
            </div>
        </div>
    </footer>
    <div class="clearfix"></div>

    @if(ModelConfig::find('id_whatsapp')->valor)
    <a target="_blank" style="height: 46px;" class="btn-whatsapp-fixed" href="https://api.whatsapp.com/send?l=pt&phone=@telefone(ModelConfig::find('id_whatsapp')->valor)">
        <i class="fab fa-whatsapp" style="font-size:27px;"></i>
    </a>
    @endif

    <noscript>
        <p>@lang('web.no_script')</p>
    </noscript>
    {!! ModelConfig::find('cod_atendimento')->valor ?? '' !!}
    {!! ModelConfig::find('cod_facebook')->valor ?? '' !!}
    {!! ModelConfig::find('cod_twitter')->valor ?? '' !!}
    {!! ModelConfig::find('cod_comp_ga')->valor ?? '' !!}
    {!! ModelConfig::find('cod_comp_pixel')->valor ?? '' !!}
</body>

</html>
