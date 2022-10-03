@extends('errors.layout')

@section('title', __('Acesso Proibido!'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Desculpe, você está proibido de acessar esta página.'))
