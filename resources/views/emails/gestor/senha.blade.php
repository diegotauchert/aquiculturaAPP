@extends('layouts.gestor.email')

@section('content')
<h3>Olá {{ $usuario->present()->apelido }},</h3>
<p>&nbsp;</p>
<p>Você solicitou uma nova senha no <a href="{{ url('/gestor') }}"><b>Gestor</b></a>.</p>
<p>Para te ajudar no acesso, geramos esta senha provisória.</p>
<p>&nbsp;</p>
<p><b>Usuário:</b> {{ $usuario->login }}</p>
<p><b>Senha:</b> {{ $senha }}</p>
<p>&nbsp;</p>
<p><b>Lembre-se letras maiusculas e minusculas são diferentes!</b></p>
<p>Para continuar seguro, peço que altere ela assim que acessar o Gestor.</p>
<p>&nbsp;</p>
<p>Até mais.</p>
@endsection
