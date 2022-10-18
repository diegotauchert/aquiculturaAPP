@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_producao.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_producao.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
</div>

@if($viveiros)
<div class="card">
    <div class="card-body">
        <h4 class="mb-3 text-center">Escolha um Viveiro</h4>
        @foreach($viveiros as $viveiro)
        <a href="{{ route('gestor.producao.categoria', $viveiro->id) }}" class="btn btn-primary d-block mb-3 mx-2">
            <strong>{{$viveiro->nome}}</strong>
        </a>
        @endforeach
    </div>
</div>
@endif
@endsection
