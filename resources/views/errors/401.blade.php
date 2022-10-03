@extends('errors.layout')

@section('title', __('Não autorizado!'))
@section('code', '401')
@section('message', __('Desculpe, você não possui altorização para acessar esta página.'))
