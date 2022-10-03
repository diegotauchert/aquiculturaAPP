<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', '404') - {{ ModelConfig::find('titulo')->valor ?? config('app.name', '') }} - {{ config('app.dev', 'Gestor') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(mix('icons/apple-touch-icon.png')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(mix('icons/favicon-32x32.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(mix('icons/favicon-16x16.png')) }}">
    <link rel="manifest" href="{{ asset(mix('icons/site.webmanifest')) }}">
    <link rel="mask-icon" href="{{ asset(mix('icons/safari-pinned-tab.svg')) }}" color="#0e635a">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#222222">

    <link href="{{ asset(mix('css/gestor.css')) }}" rel="stylesheet">
    <script type="text/javascript">
        var CONFIG_URL = "{{ url('/') }}";
    </script>

    <script defer src="{{ asset(mix('js/gestor.js')) }}" type="text/javascript"></script>
    <script defer src="{{ asset(mix('js/js/metisMenu.min.js')) }}" type="text/javascript"></script>
    <script defer src="{{ asset(mix('js/js/waves.min.js')) }}" type="text/javascript"></script>
    <script defer src="{{ asset(mix('js/js/jquery.slimscroll.min.js')) }}" type="text/javascript"></script>

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

    <script defer src="{{ asset(mix('js/js/jquery.dataTables.min.js')) }}" type="text/javascript"></script>
    <script defer src="{{ asset(mix('js/js/dataTables.bootstrap4.min.js')) }}" type="text/javascript"></script>

    <script defer src="{{ asset(mix('js/app.js')) }}" type="text/javascript"></script>
</head>

<body class="@lang('gestor_pagina.link')">
    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left">
            <span>
                <a class="navbar-brand o-tooltip text-hide" title="Home" href="{{ route('gestor.dashboard') }}" data-placement="bottom"><img src="{{ asset(mix('images/logo.png')) }}" alt="{{ (app('config')->get('app')['dev'] ? app('config')->get('app')['dev'] : '') }}"></a>
            </span>
        </div>

        <nav class="navbar-custom">
            <ul class="list-unstyled topbar-nav float-right mb-0">
                {{-- @include('components.gestor.language') --}}

                @isset($notification)
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="dripicons-bell noti-icon"></i>
                        <span class="badge badge-danger badge-pill noti-icon-badge">{{ $notification->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                        <!-- item-->
                        <h6 class="dropdown-item-text">
                            Notificações ({{ $notification->count() }}) <small>Pendências</small>
                        </h6>
                        <div class="slimscroll notification-list">
                            @if($notification)
                            @foreach($notification as $note)
                            <a href="@if($note->nome){{ route('gestor.solicitacoes.edit', $note->id) }}@else{{ route('gestor.agendamentos.edit', $note->id) }}@endif" class="dropdown-item notify-item">
                                @if($note->nome)
                                <div class="notify-icon bg-warning"><i class="mdi mdi-telegram"></i></div>
                                @else
                                <div class="notify-icon bg-success"><i class="mdi mdi-calendar"></i></div>
                                @endif
                                <p class="notify-details">
                                    @if($note->nome)
                                    Solicitação
                                    @else
                                    Agendamento
                                    @endif
                                    <small class="text-muted">
                                        {{ $note->created_at->format('H:i d/m/Y') }}<br />
                                        @if($note->pessoa){{ $note->pessoa->nome_razao }}<br />@endif
                                        @if($note->nome)
                                        {{ $note->present()->makeServicoContrato[0] }}
                                        @endif
                                    </small>
                                </p>
                            </a>
                            @endforeach
                            @endif
                        </div>

                        <span class="dropdown-item text-center text-primary"></span>
                    </div>
                </li>
                @endisset

                @include('components.gestor.profile')
            </ul>
            <!--end topbar-nav-->

            <ul class="list-unstyled topbar-nav mb-0">
                <li>
                    <button class="button-menu-mobile nav-link waves-effect waves-light">
                        <i class="dripicons-menu nav-icon"></i>
                    </button>
                </li>
                <li class="hide-phone app-search">
                    <form role="search" class="" action="{{ url(route('gestor.busca')) }}" method="get" name="form_bus" id="form_bus">
                        <input type="text" placeholder="Pesquisar..." class="form-control">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <div class="page-wrapper">
        <div class="left-sidenav">
            <div class="main-icon-menu">
                <nav class="nav">
                    <a href="#MetricaHospital" class="nav-link" data-toggle="tooltip" data-placement="top" title="{{env('CLIENTE_NOME')}}" data-original-title="{{env('CLIENTE_NOME')}}">
                        <svg class="nav-svg" viewBox="-31 0 512 512" xmlns="http://www.w3.org/2000/svg">
                            <path d="m448.65625 147.746094c-1.207031-4.511719-4.101562-8.285156-8.148438-10.621094l-14.714843-8.496094c-4.046875-2.335937-8.761719-2.957031-13.277344-1.746094-4.511719 1.207032-8.285156 4.101563-10.621094 8.148438l-8.78125 15.207031c-3.726562-1.75-7.910156-2.136719-11.9375-1.058593-4.511719 1.210937-8.285156 4.105468-10.621093 8.152343l-.554688.957031v-64.789062c0-20.679688-16.820312-37.5-37.5-37.5h-54.699219c-1.222656-8.464844-8.503906-15-17.300781-15h-25.5v-18.5c0-12.40625-10.09375-22.5-22.5-22.5h-55c-12.40625 0-22.5 10.09375-22.5 22.5v18.5h-25.5c-8.796875 0-16.082031 6.535156-17.300781 15h-54.699219c-20.679688 0-37.5 16.820312-37.5 37.5v381c0 20.679688 16.820312 37.5 37.5 37.5h234.046875c4.140625 0 7.5-3.355469 7.5-7.5s-3.359375-7.5-7.5-7.5h-234.046875c-12.40625 0-22.5-10.09375-22.5-22.5v-381c0-12.40625 10.09375-22.5 22.5-22.5h54.5v36.5c0 9.648438 7.851562 17.5 17.5 17.5h151c9.648438 0 17.5-7.851562 17.5-17.5v-7h47.5v134.867188l-76.316406 132.183593c-2.757813 4.773438-4.007813 10.203125-3.613282 15.703125l3.34375 46.851563c.292969 4.097656 2.582032 7.789062 6.121094 9.875 1.953125 1.148437 4.144532 1.730469 6.347656 1.730469 1.789063 0 3.582032-.386719 5.253907-1.160157l43.117187-19.996093c5.164063-2.394532 9.398438-6.265626 12.242188-11.191407l3.503906-6.066406v64.203125h-281v-367h20c4.140625 0 7.5-3.355469 7.5-7.5s-3.359375-7.5-7.5-7.5h-22.5c-6.894531 0-12.5 5.605469-12.5 12.5v372c0 6.894531 5.605469 12.5 12.5 12.5h286c6.890625 0 12.5-5.605469 12.5-12.5v-92.6875l14.5-25.113281v122.300781c0 12.40625-10.09375 22.5-22.5 22.5h-25.957031c-4.140625 0-7.5 3.355469-7.5 7.5 0 4.140625 3.359375 7.5 7.5 7.5h25.957031c20.675781 0 37.5-16.824219 37.5-37.5v-148.28125l63.273438-109.59375 9.996093-17.3125c2.335938-4.046875 2.957031-8.761719 1.746094-13.273438-1.078125-4.027343-3.503906-7.453124-6.886719-9.808593l8.78125-15.207031c2.335938-4.046876 2.957032-8.761719 1.746094-13.277344zm-33.773438-5.214844c.6875-1.191406 2.214844-1.601562 3.410157-.914062l14.714843 8.496093c.777344.449219 1.0625 1.144531 1.164063 1.515625.097656.375.199219 1.113282-.25 1.894532l-8.746094 15.144531-19.035156-10.988281zm-31.339843 22.300781c.449219-.777343 1.144531-1.0625 1.515625-1.160156.375-.105469 1.113281-.203125 1.890625.246094l42.414062 24.488281c.78125.449219 1.066407 1.140625 1.164063 1.515625.101562.371094.199218 1.113281-.25 1.890625l-6.246094 10.816406-46.730469-26.980468zm-233.542969-142.332031c0-4.136719 3.363281-7.5 7.5-7.5h55c4.136719 0 7.5 3.363281 7.5 7.5v18.5h-70zm113 85c0 1.378906-1.121094 2.5-2.5 2.5h-151c-1.378906 0-2.5-1.121094-2.5-2.5v-49c0-1.378906 1.121094-2.5 2.5-2.5h151c1.378906 0 2.5 1.121094 2.5 2.5zm65-22h-50v-14.5h54.5c12.40625 0 22.5 10.09375 22.5 22.5v90.773438l-14.5 25.113281v-111.386719c0-6.894531-5.605469-12.5-12.5-12.5zm41.800781 103.140625 46.730469 26.980469-91.945312 159.257812-46.734376-26.980468zm-60.792969 213.222656c-1.292968 2.238281-3.21875 3.996094-5.5625 5.082031v.003907l-39.828124 18.46875-3.085938-43.230469c-.179688-2.5.390625-4.964844 1.644531-7.132812l8.175781-14.167969 46.734376 26.980469zm0 0"/>
                            <path d="m77.46875 418.4375c1.425781 1.269531 3.207031 1.890625 4.976562 1.890625 2.070313 0 4.128907-.851563 5.609376-2.519531l14.871093-16.742188 11.511719 13.730469c2.308594 2.757813 5.695312 4.382813 9.289062 4.46875 3.597657.0625 7.050782-1.382813 9.484376-4.027344l13.84375-15.03125 15.34375 17.367188c2.746093 3.105469 7.484374 3.398437 10.585937.65625 3.105469-2.742188 3.398437-7.480469.65625-10.585938l-17.179687-19.445312c-2.339844-2.648438-5.707032-4.1875-9.238282-4.222657-.042968-.003906-.085937-.003906-.128906-.003906-3.488281 0-6.832031 1.464844-9.195312 4.03125l-13.792969 14.976563-11.546875-13.769531c-2.335938-2.785157-5.761719-4.414063-9.402344-4.46875-3.640625-.082032-7.105469 1.480468-9.519531 4.199218l-16.792969 18.90625c-2.753906 3.097656-2.472656 7.839844.625 10.589844zm0 0"/>
                            <path d="m298.75 165.5c0-4.144531-3.359375-7.5-7.5-7.5h-213c-4.140625 0-7.5 3.355469-7.5 7.5s3.359375 7.5 7.5 7.5h213c4.140625 0 7.5-3.355469 7.5-7.5zm0 0"/>
                            <path d="m79.25 213h89c4.140625 0 7.5-3.355469 7.5-7.5s-3.359375-7.5-7.5-7.5h-89c-4.140625 0-7.5 3.355469-7.5 7.5s3.359375 7.5 7.5 7.5zm0 0"/>
                            <path d="m245.75 205.5c0-4.144531-3.359375-7.5-7.5-7.5h-35c-4.140625 0-7.5 3.355469-7.5 7.5s3.359375 7.5 7.5 7.5h35c4.140625 0 7.5-3.355469 7.5-7.5zm0 0"/>
                            <path d="m79.25 253h72c4.140625 0 7.5-3.355469 7.5-7.5s-3.359375-7.5-7.5-7.5h-72c-4.140625 0-7.5 3.355469-7.5 7.5s3.359375 7.5 7.5 7.5zm0 0"/>
                            <path d="m217.25 238h-34c-4.140625 0-7.5 3.355469-7.5 7.5s3.359375 7.5 7.5 7.5h34c4.140625 0 7.5-3.355469 7.5-7.5s-3.359375-7.5-7.5-7.5zm0 0"/>
                            <path d="m79.25 293h52c4.140625 0 7.5-3.355469 7.5-7.5s-3.359375-7.5-7.5-7.5h-52c-4.140625 0-7.5 3.355469-7.5 7.5s3.359375 7.5 7.5 7.5zm0 0"/>
                            <path d="m224.75 285.5c0-4.144531-3.359375-7.5-7.5-7.5h-54c-4.140625 0-7.5 3.355469-7.5 7.5s3.359375 7.5 7.5 7.5h54c4.140625 0 7.5-3.355469 7.5-7.5zm0 0"/>
                            <path d="m79.25 333h52c4.140625 0 7.5-3.355469 7.5-7.5s-3.359375-7.5-7.5-7.5h-52c-4.140625 0-7.5 3.355469-7.5 7.5s3.359375 7.5 7.5 7.5zm0 0"/>
                        </svg>
                    </a>

                    <a href="#MetricaAuthentication" class="nav-link" data-toggle="tooltip" data-placement="top" title="@lang('gestor.nav_config')" data-original-title="@lang('gestor.nav_config')">
                        <svg class="nav-svg" version="1.1" id="Layer_5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <g>
                                <path d="M376,192h-24v-46.7c0-52.7-42-96.5-94.7-97.3c-53.4-0.7-97.3,42.8-97.3,96v48h-24c-22,0-40,18-40,40v192c0,22,18,40,40,40
                                        h240c22,0,40-18,40-40V232C416,210,398,192,376,192z M270,316.8v68.8c0,7.5-5.8,14-13.3,14.4c-8,0.4-14.7-6-14.7-14v-69.2
                                        c-11.5-5.6-19.1-17.8-17.9-31.7c1.4-15.5,14.1-27.9,29.6-29c18.7-1.3,34.3,13.5,34.3,31.9C288,300.7,280.7,311.6,270,316.8z
                                            M324,192H188v-48c0-18.1,7.1-35.1,20-48s29.9-20,48-20s35.1,7.1,48,20s20,29.9,20,48V192z" />
                            </g>
                        </svg>
                    </a>
                </nav>
            </div>

            <div class="main-menu-inner">
                <div class="menu-body slimscroll">
                    <div id="MetricaHospital" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">{{env('CLIENTE_NOME')}}</h6>
                        </div>

                        <ul class="nav metismenu">
                            <li class="nav-item"><a class="nav-link" href="{{ route('gestor.dashboard') }}"><i class="dripicons-meter"></i>@lang('gestor.nav_dashboard')</a></li>

                            @php
                            $menus = array(1 => 'Cadastros', 'folder-open');
                            @endphp
                            @foreach($menus as $k => $menu)
                            @if(\App\Models\Modulo::select('modulos.*')->leftJoin('permissoes', 'permissoes.modulo_id', '=', 'modulos.id')->where('permissoes.usuario_id', '=', Auth::guard('gestor')->user()->id)->where('modulos.situacao', '=', '1')->where('modulos.menu', '=', $k)->where('modulos.exibe', '=', '1')->whereNull('modulos.modulo_id')->whereNull('permissoes.deleted_at')->orderBy('modulos.nome', 'asc')->count() > 0)
                            @foreach(\App\Models\Modulo::select('modulos.*')->leftJoin('permissoes', 'permissoes.modulo_id', '=', 'modulos.id')->where('permissoes.usuario_id', '=', Auth::guard('gestor')->user()->id)->where('modulos.situacao', '=', '1')->where('modulos.menu', '=', $k)->where('modulos.exibe', '=', '1')->whereNull('modulos.modulo_id')->whereNull('permissoes.deleted_at')->orderBy('modulos.nome', 'asc')->get() as $submenu)
                            @include('components.gestor.submenu')
                            @endforeach
                            @endif
                            @endforeach
                            <li style="height:100px;"></li>
                        </ul>
                    </div>

                    <div id="MetricaAuthentication" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">@lang('gestor.nav_config')</h6>
                        </div>

                        <ul class="nav metismenu">
                            @include('components.gestor.menu')
                        </ul>
                        <!--end nav-->
                    </div>
                </div>
                <!--end menu-body-->
            </div><!-- end main-menu-inner-->
        </div>

        <div class="page-content">
            <div class="container-fluid">
                @if (session('alert'))
                @alert(['type' => session('alert')['type']])
                {!! session('alert')['message'] !!}
                @endalert
                @endif

                @yield('content')
            </div>
            <footer class="footer text-center text-sm-left">
                &copy; {{ config('app.year', '') }} {{ config('app.dev') }} <br /> {{ config('app.client') }} <span class="text-muted d-none d-sm-inline-block float-right">Crafted with <i class="mdi mdi-heart text-danger pulse"></i> by <a href="{{ config('app.dev_url', '') }}" target="_blank">{{ config('app.dev_name', 'FABTECH') }}</a>{{ (app('config')->get('app')['version'] ? ' - v' : '') }}{{ config('app.version', '') }}</span>
            </footer>
        </div>
    </div>
</body>
</html>