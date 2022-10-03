@extends('layouts.web.email')

@section('content')
<p>Você recebeu um novo contato através do site <a href="{{ url('/') }}"><b>{{ config('app.name') }}</b></a>.</p>
<p>&nbsp;</p>
<h3>Informações do contato</h3>
<p><b>Nome:</b> {{ $field['nome'] }}</p>
<p><b>Telefone:</b> {{ $field['telefone'] }}</p>
<p><b>E-mail:</b> <a href="mailto:{{ $field['email'] }}">{{ $field['email'] }}</a></p>
@if($field['cidade'])
<p><b>Cidade:</b> {{ $field['cidade'] }}</p>
@endif
@if($field['estado'])
<p><b>Estado:</b> {{ $field['estado'] }}</p>
@endif
@if($field['evento'])
<p><b>Tipo do Evento:</b> {{ $field['evento'] }}</p>
@endif
@if($field['data'])
<p><b>Data Estimada:</b> {{ $field['data'] }}</p>
@endif
<p>&nbsp;</p>
<h3>Mensagem enviada</h3>
<p>{!! nl2br($field['mensagem']) !!}</p>
@endsection
