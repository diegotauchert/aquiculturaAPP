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
        <div class="topbar-left">
            <span>
                <a class="navbar-brand o-tooltip text-hide" title="Home" href="{{ route('gestor.dashboard') }}" data-placement="bottom">
                    <img src="{{ asset(mix('images/logo.png')) }}" alt="{{ (app('config')->get('app')['dev'] ? app('config')->get('app')['dev'] : '') }}">
                </a>
            </span>
        </div>

        <nav class="navbar-custom">
            <ul class="list-unstyled topbar-nav float-right mb-0">
                @include('components.gestor.profile')
            </ul>

            <ul class="list-unstyled topbar-nav mb-0">
                <li>
                    <button class="button-menu-mobile nav-link waves-effect waves-light">
                        <i class="dripicons-menu nav-icon"></i>
                    </button>
                </li>
                <!-- <li class="hide-phone app-search">
                    <form role="search" class="" action="{{ url(route('gestor.busca')) }}" method="get" name="form_bus" id="form_bus">
                        <input type="text" placeholder="Pesquisar..." class="form-control">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </li> -->
            </ul>
        </nav>
    </div>
    
    <div class="page-wrapper">
        <div class="left-sidenav">
            <div class="main-icon-menu">
                <nav class="nav">
                    <a href="#linkApp" class="nav-link" data-toggle="tooltip" data-placement="top" title="{{env('CLIENTE_NOME')}}" data-original-title="{{env('CLIENTE_NOME')}}">
                        <svg class="nav-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve"><script xmlns="">(function(){const e=()=&gt;{};let t=null,o=null,n=[],i=e,r=e,a=e,s=e;try{i=window.fetch,r=window.XMLHttpRequest.prototype.open,a=window.XMLHttpRequest.prototype.send,s=window.XMLHttpRequest.prototype.setRequestHeader}catch(e){0}function c(e){return!(!window.XMLHttpRequest||!window.XMLHttpRequest.prototype||"function"!=typeof window.XMLHttpRequest.prototype[e])}function d(){let e=[];return{subscribe:t=&gt;{e.push(t)},next:t=&gt;{e.length&amp;&amp;e.forEach((e=&gt;e(t)))},clear:()=&gt;{e.length=0}}}const l=new d,p=new WeakMap,u=new WeakMap,E=new WeakMap;c("open")&amp;&amp;c("send")&amp;&amp;c("setRequestHeader")&amp;&amp;(window.XMLHttpRequest.prototype.open=function(...e){if(p.set(this,{method:e[0]&amp;&amp;e[0].toUpperCase()||"GET"}),!0===this.__amicabletbecoxhro||"OFF"===t){r.apply(this,e);const t=u.get(this);t&amp;&amp;t.next()}else{const t=u.get(this)||new d;u.set(this,t),this.__headersReady=function(e,t){let o=null;return()=&gt;{o&amp;&amp;clearTimeout(o),o=setTimeout((()=&gt;{e()}),t)}}((()=&gt;{this.__onPendingHeadersSet&amp;&amp;this.__onPendingHeadersSet()}),50),l.subscribe((()=&gt;{c("open")&amp;&amp;window.XMLHttpRequest.prototype.open.apply(this,e)}))}},window.XMLHttpRequest.prototype.setRequestHeader=function(...e){if(this.readyState===XMLHttpRequest.OPENED||"OFF"===t)s.apply(this,e);else{E.set(this,!0);const t=u.get(this);t&amp;&amp;t.subscribe((()=&gt;{s.apply(this,e),this.__headersReady()}))}},window.XMLHttpRequest.prototype.send=function(e){if(this.addEventListener("readystatechange",(()=&gt;{if("OFF"!==o&amp;&amp;this.readyState===XMLHttpRequest.DONE)try{const t=p.get(this),i=t&amp;&amp;"string"==typeof t.method&amp;&amp;t.method.toUpperCase()||"";let r,a=[];try{const e=this.getAllResponseHeaders();a=(e&amp;&amp;e.trim().split(/[\r\n]+/)).reduce(((e,t)=&gt;{try{const o=t.split(": "),n=o.shift(),i=o.join(": ");e.push({active:!0,header:n,value:i})}catch(e){}return e}),[])}catch(e){a=[]}try{r="string"==typeof this.response?this.response:JSON.stringify(this.response)}catch(e){r=this.response}const s={type:"STASH_REQUESTS",payload:[[{method:i,requestURL:this.responseURL,responsePayload:r,requestPayload:e,status:this.status,timestamp:Date.now(),responseHeaders:a}]]};"ON"===o?window.postMessage(s,"*"):n.push(s.payload[0][0])}catch(e){}})),"OFF"===t)a.call(this,e);else if(E.get(this))this.__onPendingHeadersSet=()=&gt;{E.delete(this),c("send")&amp;&amp;this.readyState===XMLHttpRequest.OPENED&amp;&amp;window.XMLHttpRequest.prototype.send.call(this,e),this.__onPendingHeadersSet=null};else if(this.readyState===XMLHttpRequest.OPENED&amp;&amp;!0===this.__amicabletbebypoxhrs){Object.defineProperty(this,"readyState",{writable:!0,configurable:!0,value:XMLHttpRequest.LOADING});const e=new Event("readystatechange");this.dispatchEvent(e)}else if(this.readyState===XMLHttpRequest.OPENED&amp;&amp;!0===this.__amicabletbecoxhrs)a.call(this,e);else{const t=u.get(this);t&amp;&amp;t.subscribe((()=&gt;{c("send")&amp;&amp;this.readyState===XMLHttpRequest.OPENED&amp;&amp;window.XMLHttpRequest.prototype.send.call(this,e)}))}}),window.fetch=(...e)=&gt;{const r=e[0];let a=e[1];const{url:s,method:c}=function(e,t){let o,n="GET";return"string"==typeof e?(o=e,n=t?.method?.toUpperCase()||"GET"):"string"==typeof e?.search?(o=e.toString(),n=t?.method?.toUpperCase()||"GET"):(o=e.url||"",n=e?.method?.toUpperCase()||"GET"),{method:n,url:o}}(r,a),d=function(e,t){return new Promise((o=&gt;{if("string"==typeof e||"string"==typeof e?.search){const e=t&amp;&amp;t.body||null;o(e)}else try{e.clone().text().then((e=&gt;{o(e)})).catch((e=&gt;{o(null)}))}catch(e){o(null)}}))}(r,a);let p=!1;try{if("string"==typeof a?.headers?.amicabletbecof)switch(p=!0,a?.headers?.amicabletbecof){case"no-init":a=void 0;break;case"no-headers":a.headers=void 0;break;default:delete a.headers.amicabletbecof}}catch(e){0}return p||"OFF"===t?i(r,a).then((async e=&gt;{if("OFF"===o)return e;try{const t=await d;let i;try{i=t.replace(/\s/gi,"")}catch(e){i=t}const r=e.clone(),a=await r.text();let l=[];try{for(const e of r?.headers?.entries()){const t=e[0],o=e[1];l.push({active:!0,header:t,value:o})}}catch(e){l=[]}const p={type:"STASH_REQUESTS",payload:[[{method:c&amp;&amp;c.toUpperCase()||"GET",requestURL:s,responsePayload:a,requestPayload:i,responseHeaders:l,status:e.status,timestamp:Date.now()}]]};"ON"===o?window.postMessage(p,"*"):n.push(p.payload[0][0])}catch(e){}return e})):((...e)=&gt;new Promise((t=&gt;{l.subscribe((()=&gt;{t(window.fetch(...e))}))})))(...e)},l.subscribe((()=&gt;{try{window.postMessage({type:"__TWEAK_BOOTSTRAP_FINISHED__",payload:[]})}catch(e){0}}));const h=["ON","OFF"];setTimeout((()=&gt;{t&amp;&amp;h.includes(t)||(t="OFF",l.next())}),5e3),window.__onttis=e=&gt;{e&amp;&amp;h.includes(e)&amp;&amp;(t&amp;&amp;h.includes(t)?t=e:(t=e,l.next()))},window.__onttss__=(e,t)=&gt;{if(e&amp;&amp;h.includes(e)){if("OFF"===e&amp;&amp;"user"===t&amp;&amp;n.length)n=[];else if("ON"===e&amp;&amp;"system"===t&amp;&amp;n.length)try{window.postMessage({type:"STASH_REQUESTS",payload:[n]})}catch(e){0}n=[],o=e}},window.__textm__="c2"})();</script><script xmlns="" id="__tweak_browser_extension_intercept_script__" async="false" defer="false" src="moz-extension://63b9cc1b-e53f-4eca-84a5-10dc40a430e1/intercept.bundle.js"/>
                            <g>
                                <g>
                                    <path d="M477.159,209.634c-22.373-19.971-52.396-37.151-84.553-48.389c-0.021-0.008-0.041-0.015-0.062-0.023    c-0.035-0.012-0.069-0.025-0.104-0.038c-14.841-5.176-30.09-9.081-45.385-11.658c-9.029-10.947-38.976-42.731-90.831-54.779    c-8.616-2.004-17.536,0.011-24.482,5.525c-6.989,5.55-10.997,13.847-10.997,22.765v41.181    c-48.704,21.435-87.315,56.393-108.074,77.857c-3.091-15.604-9.946-35.331-25.076-50.461    c-28.811-28.81-75.188-27.613-77.136-27.547c-5.686,0.189-10.251,4.754-10.438,10.44c-0.066,1.959-1.25,48.315,27.558,77.123    c7.147,7.147,15.338,12.389,23.679,16.243c-8.341,3.935-16.534,9.23-23.68,16.376c-28.807,28.819-27.622,75.174-27.557,77.133    c0.187,5.686,4.752,10.252,10.438,10.441c0.185,0.006,0.768,0.023,1.697,0.023c8.884,0,49.358-1.49,75.439-27.581    c15.257-15.257,22.098-35.435,25.148-51.334c15.226,15.715,40.028,38.66,71.384,58.28v37.75c0,9.261,4.259,17.745,11.685,23.275    c5.108,3.803,11.122,5.772,17.265,5.772c2.802,0,5.631-0.409,8.412-1.241c26.134-7.803,45.906-22.044,55.071-29.547    c8.83,1.294,17.628,1.958,26.221,1.958c29.499,0,59.016-4.962,87.729-14.746c0.019-0.006,0.038-0.013,0.057-0.019    c66.961-22.822,121.429-70.785,121.429-106.936C512.002,250.231,499.628,229.69,477.159,209.634z M42.858,236.355    c-14.78-14.78-19.297-36.961-20.664-50.15c13.164,1.337,35.267,5.824,50.128,20.685c14.767,14.766,19.287,36.531,20.66,49.454    C80.006,255.259,57.679,251.176,42.858,236.355z M72.321,328.99c-14.767,14.772-36.927,19.292-50.123,20.661    c1.373-13.201,5.896-35.357,20.66-50.128c14.828-14.828,37.109-19.32,50.151-20.668C91.673,292.015,87.187,314.124,72.321,328.99z     M242.35,123.036c0-2.289,1.03-4.42,2.828-5.847c1.03-0.819,3.202-2.088,6.155-1.401c27.276,6.338,47.721,19.118,61.262,30.172    c-3.279-0.124-6.551-0.187-9.81-0.187c-19.714,0-39.981,3.408-60.435,10.135V123.036z M215.308,396.067    c-2.28,0.682-4.684,0.26-6.589-1.159c-1.115-0.83-2.986-2.706-2.986-5.947v-25.423c14.267,7.367,28.51,13.167,42.625,17.377    C239.693,386.346,228.44,392.146,215.308,396.067z M302.786,367.573c-9,0-18.284-0.822-27.583-2.441    c-24.301-4.253-49.44-14.088-74.718-29.237c-39.823-23.869-69.808-54.927-81.877-68.423c15.37-17.194,59.812-62.867,116.99-86.085    c0.069-0.028,0.139-0.053,0.207-0.082c22.825-9.241,45.359-13.929,66.98-13.929c12.163,0,24.524,0.943,36.744,2.805    c9.328,1.418,18.652,3.392,27.879,5.878c-22.668,24.062-37.057,59.506-37.057,93.834c0,31.343,13.892,65.168,35.752,89.347    C345.207,364.767,323.982,367.573,302.786,367.573z M389.282,351.949c-22.513-20.292-37.328-52.514-37.328-82.054    c0-32.312,15.771-66.911,38.876-86.318c61.838,23.127,99.569,63.92,99.569,83.897C490.399,287.79,452.086,328.935,389.282,351.949    z"/>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M429.154,254.253c-5.965,0-10.802,4.837-10.802,10.802v4.839c0,5.965,4.837,10.802,10.802,10.802    c5.965,0,10.802-4.837,10.802-10.802v-4.839C439.955,259.09,435.118,254.253,429.154,254.253z"/>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M317.298,194.865c-4.326-4.109-11.162-3.931-15.27,0.394c-1.036,1.091-2.058,2.234-3.04,3.399    c-3.844,4.563-3.262,11.377,1.302,15.22c2.026,1.708,4.496,2.542,6.954,2.542c3.075,0,6.13-1.307,8.265-3.843    c0.707-0.839,1.442-1.661,2.183-2.442C321.801,205.809,321.624,198.973,317.298,194.865z"/>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M316.052,327.016c-12.007-13.824-18.893-34.793-18.893-57.531c0-12.73,2.228-25.254,6.446-36.22    c2.141-5.568-0.637-11.817-6.204-13.959c-5.569-2.142-11.818,0.636-13.96,6.204c-5.158,13.414-7.885,28.62-7.885,43.973    c0,27.868,8.815,54.001,24.186,71.698c2.137,2.46,5.139,3.719,8.159,3.719c2.511,0,5.034-0.871,7.079-2.646    C319.483,338.341,319.964,331.519,316.052,327.016z"/>
                                </g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                        </svg>
                    </a>

                    @if(auth('gestor')->user()->tipo == 1)
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
                    @endif
                </nav>
            </div>

            <div class="main-menu-inner">
                <div class="menu-body slimscroll">
                    <div id="linkApp" class="main-icon-menu-pane active">
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
                            
                            <!-- TIPO USUARIO QUE COMPROU O APP -->
                            @if(auth('gestor')->user()->tipo == 4)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gestor.fazendas.index') }}">
                                    <i class="dripicons-store"></i>@lang('gestor.nav_fazenda')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gestor.produtos.index') }}">
                                    <i class="dripicons-experiment"></i>@lang('gestor.nav_estoque')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gestor.viveiros.index') }}">
                                    <i class="dripicons-vibrate"></i>@lang('gestor.nav_viveiro')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="dripicons-clipboard"></i>@lang('gestor.nav_producao')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="dripicons-conversation"></i>@lang('gestor.nav_mensagem')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="dripicons-graph-line"></i>@lang('gestor.nav_financeiro')
                                </a>
                            </li>
                            @endif

                            <!-- TIPO USUARIO GESTOR -->
                            @if(auth('gestor')->user()->tipo == 5)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gestor.produtos.index') }}">
                                    <i class="dripicons-experiment"></i>@lang('gestor.nav_estoque')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gestor.viveiros.index') }}">
                                    <i class="dripicons-vibrate"></i>@lang('gestor.nav_viveiro')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="dripicons-clipboard"></i> Cultivo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gestor.mensagens.index') }}">
                                    <i class="dripicons-conversation"></i>@lang('gestor.nav_mensagem') Enviadas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gestor.mensagens.recebida') }}">
                                    <i class="dripicons-conversation"></i>@lang('gestor.nav_mensagem') Recebidas
                                </a>
                            </li>
                            @endif
                            <li style="height:100px;"></li>
                        </ul>
                    </div>

                    @if(auth('gestor')->user()->tipo == 1)
                    <div id="MetricaAuthentication" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">@lang('gestor.nav_config')</h6>
                        </div>

                        <ul class="nav metismenu">
                            @include('components.gestor.menu')
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
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
            <footer class="position-relative footer text-center text-sm-left">
                &copy; {{ config('app.year', '') }} {{ config('app.dev') }} <br /> {{ config('app.client') }} <span class="text-muted d-none d-sm-inline-block float-right">Desenvolvido pela <a href="{{ config('app.dev_url', '') }}" target="_blank" class="mr-3">{{ config('app.dev_name', 'FABTECH') }} com <i class="mdi mdi-heart text-danger pulse position-absolute"></i></a>{{ (app('config')->get('app')['version'] ? ' v' : '') }}{{ config('app.version', '') }}</span>
            </footer>
        </div>
    </div>
</body>
</html>