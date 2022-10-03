@extends('errors.layout')

@section('title', __('Muitas solicitações!'))
@section('code', '429')
@section('message', __('Desculpe, detectamos que você está realizando muitas requisições aos nossos servidores.'))
