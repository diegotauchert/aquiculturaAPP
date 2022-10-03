@extends('layouts.web.email')

@section('content')
<h3>Olá {{ $usuario->present()->makeApelido ?? $usuario->present()->apelido }},</h3>
<p>&nbsp;</p>
<p>Você solicitou uma nova senha no <a href="{{ url('/') }}"><b>{{ config('app.name') }}</b></a>.</p>
<p>Para te ajudar no acesso, geramos esta senha provisória.</p>
<p>&nbsp;</p>
<p><b>E-mail:</b> {{ $usuario->email }}</p>
<p><b>Senha:</b> {{ $senha }}</p>
<p>&nbsp;</p>
<p><b>Lembre-se letras maiusculas e minusculas são diferentes!</b></p>
<p>Para continuar seguro, peço que altere ela assim que acessar.</p>
<p>&nbsp;</p>
<p>Até mais.</p>
@endsection
