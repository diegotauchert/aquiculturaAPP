<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', '') }} - {{ config('app.dev', 'Gestor') }}</title>

        <style type="text/css">
            * { font-family:"Open Sans", Helvetica, Arial, sans-serif; }
            body, a, p, table, tr, td, h1, h2, h3, h4, h5, h6, ul, ol, li, div, img { margin:0px; padding:0px; }
            body { background:#FFF; color:#333; font-size:14px; padding:10px; }
            a { color:#333; text-decoration:none; }
            a:hover { text-decoration:underline; }
            p { padding:3px 5px; }
            h1 { font-size:20px; padding:3px 5px; }
            h2 { font-size:19px; padding:3px 5px; }
            h3 { font-size:18px; font-weight:bold; padding:3px 5px; }
            h4 { font-size:17px; font-weight:bold; padding:3px 5px; }
            h5 { font-size:16px; font-weight:bold; padding:3px 5px; }
            h6 { font-size:15px; font-weight:bold; padding:3px 5px; }
            hr { background:#efefef; color:#efefef; height:1px; border:none; }
            ul { padding:0px 0px 0px 25px; }
            ol { padding:0px 0px 0px 30px; }
            table { width:100%; }
            .text-center p { text-align:center; }
            .text-right p { text-align:right; }
            .container-fluid { padding:10px; width:90%; margin:0px auto; }
            .p-1 { padding:5px; }
            .p-2 { padding:10px; }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="p-2">
                @yield('content')
            </div>
            <hr>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="text-center">
                        <p>&nbsp;</p>
                        <p>
                            <a title="{{ (app('config')->get('app')['dev'] ? app('config')->get('app')['dev'] : '') }}" href="{{ url('/') }}"><img src="{{ asset(mix('images/logo.png')) }}" alt="{{ (app('config')->get('app')['dev'] ? app('config')->get('app')['dev'] : '') }}" width="200" border="0"></a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <p>&nbsp;</p>
                        <p>Este &eacute; um e-mail autom&aacute;tico.</p>
                        <p>Enviado em @datetime(new DateTime()).</p>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
