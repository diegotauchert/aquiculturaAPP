@extends('errors.layout')

@section('title', __('Serviço indisponível!'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Desculpe, estamos em manutenção. Tente novamente em alguns instantes.'))
