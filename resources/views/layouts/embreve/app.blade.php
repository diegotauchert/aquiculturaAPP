<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Em breve novo site &middot; {{ ModelConfig::find('titulo')->valor ?? config('app.name', '') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(mix('icons/apple-touch-icon.png')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(mix('icons/favicon-32x32.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(mix('icons/favicon-16x16.png')) }}">
    <link rel="manifest" href="{{ asset(mix('icons/site.webmanifest')) }}">
    <link rel="mask-icon" href="{{ asset(mix('icons/safari-pinned-tab.svg')) }}" color="#0e635a">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#0e635a">

    <link href="{{ asset(mix('css/embreve.css')) }}" rel="stylesheet">
    <script src="{{ asset(mix('js/embreve.js')) }}" type="text/javascript"></script>
</head>

<body class="h-100">
    <div id="main" class="bg-main h-100">
        <div class="d-flex bg-main h-100">
            <div class="w-100 mt-auto mb-0">
                <div class="container pb-5">
                    <div class="row">
                        <div class="col-md-7 col-lg-6 pb-2 pb-md-5">
                            <div class="pt-5 pb-5">
                                <a href="./" id="logo" class="text-hide"><img src="{{ asset(mix('images/logo.png')) }}" alt="{{ config('app.name', '') }}" class="d-none">{{ config('app.name', '') }}</a>
                            </div>
                            <div class="row pt-2 pt-md-5">
                                <div class="col col-md-auto bg-primary tag d-flex">
                                    <div class="my-auto w-100 py-5 pl-md-4">
                                        <p class="h3 m-0 font-weight-bold text-secondary text-center text-md-right"><small class="h6 d-block font-weight-normal">EM BREVE</small> NOVO SITE</p>
                                    </div>
                                </div>
                                <div class="col-md my-auto tag-msg text-center text-md-left pt-4 pt-md-0">
                                    <p class="pt-4 m-0">{{ config('app.name', '') }} irá lançar o seu novo site.</p>
                                    <p class="pb-4 m-0">Aguarde, vai valer a pena.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="bg-primary text-secondary">
                    <div class="container">
                        <div class="row">
                            @if($telefones)
                            <div class="col-sm col-md-auto my-auto py-4">
                                <div class="d-block d-sm-flex text-center text-sm-left">
                                    <div class="my-auto pl-2 pl-sm-4 pr-2 pr-sm-2">
                                        <span class="fas fa-2x fa-phone-alt"></span>
                                    </div>
                                    <div class="my-auto pl-2 pl-sm-2 pr-2 pr-sm-4">
                                        @foreach($telefones as $telefone)
                                        <p class="p-0 m-0">{{ $telefone }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($endereco)
                            <div class="col-sm col-md-auto my-auto py-4">
                                <div class="d-block d-sm-flex text-center text-sm-left">
                                    <div class="my-auto pl-2 pl-sm-4 pr-2 pr-sm-2">
                                        <span class="fas fa-2x fa-map-marker-alt"></span>
                                    </div>
                                    <div class="my-auto pl-2 pl-sm-2 pr-2 pr-sm-4">
                                        <p class="p-0 m-0">{{ ($endereco['rua'] ? $endereco['rua'] : '') . ($endereco['numero'] ? ', ' . $endereco['numero'] : '') . ($endereco['complemento'] ? ' - ' . $endereco['complemento'] : '') }}</p>
                                        <p class="p-0 m-0">{{ ($endereco['bairro'] ? $endereco['bairro'] : '') . ($endereco['bairro'] && $endereco['cep'] ? ' - ' : '') . ($endereco['cep'] ? 'CEP: ' . $endereco['cep'] : '') }}</p>
                                        <p class="p-0 m-0">{{ ($endereco['cidade'] ? $endereco['cidade'] : '') . ($endereco['cidade'] && $endereco['estado'] ? '/' : '') . ($endereco['estado'] ? $endereco['estado'] : '') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($emails)
                            <div class="col-sm col-md-auto my-auto py-4">
                                <div class="d-block d-sm-flex text-center text-sm-left">
                                    <div class="my-auto pl-2 pl-sm-4 pr-2 pr-sm-2">
                                        <span class="fas fa-2x fa-envelope"></span>
                                    </div>
                                    <div class="my-auto pl-2 pl-sm-2 pr-2 pr-sm-4">
                                        @foreach($emails as $email)
                                        <p class="p-0 m-0 text-truncate"><a href="mailto:{{ $email }}" class="text-secondary">{{ $email }}</a></p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </footer>
                <div id="direitos" class="container py-2">
                    <div class="row">
                        <div class="col-md my-auto py-2">
                            <p class="text-center text-md-left text-dark p-0 m-0">&copy; {{ date("Y") }} <a href="./" target="_blank">{{ config('app.name', '') }}</a></p>
                        </div>
                        <div class="col col-md-auto my-auto py-2">
                            <p class="text-center text-md-right p-0 m-0"><a href="http://fabtechinfo.com.br" class="btn btn-outline-dark border-0" target="_blank" title="FABTECH">FABTECH</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
