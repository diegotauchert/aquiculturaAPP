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
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.producao.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_producao.create')</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="mb-3 text-center">{{ $viveiro->nome }}</h4>

        @foreach($producao->present()->makeCategoriaAll as $sit_k => $sit_v)
        <a href="{{route('gestor.producao.save', ['id' => $viveiro->id, 'categoria' => $sit_k])}}" class="btn btn-primary d-block mb-3 mx-2">
            {{ $sit_v[0] }}
        </a>
        @endforeach
    </div>
</div>
@endsection
