@extends('errors.layout')

@section('title', ('Serviço indisponível!'))
@section('code', ($exception->getCode() ? $exception->getCode() : '500'))
@section('message', ('Desculpe, estamos em manutenção. Tente novamente em alguns instantes.'))
