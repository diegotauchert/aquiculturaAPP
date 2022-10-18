@extends('layouts.gestor.app')

@if($producao->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_producao.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_producao.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_producao.titulo')
            @if($producao->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($producao->id ? route('gestor.producao.update', $producao->id) : route('gestor.producao.store')) }}">
    @if($producao->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <input type="hidden" name="f_categoria" value="{{ $producao->categoria_id }}" />
            <input type="hidden" name="f_viveiro" value="{{ $viveiro->id }}" />

            <div class="card-header h5 text-center">{{$producao->present()->makeCategoria[0]}}</div>
            @if($producao->categoria_id == 1)
                @include('gestor.producao.categorias.racao')
            @elseif($producao->categoria_id == 2)
                @include('gestor.producao.categorias.parametro')
            @else
                @include('gestor.producao.categorias.acompanhamento')
            @endif
        </div>
    </div>

    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span>
            @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
