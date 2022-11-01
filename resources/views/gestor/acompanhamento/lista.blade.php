@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_acompanhamento.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_acompanhamento.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    <!-- <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.acompanhamento.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_acompanhamento.create')</a>
    </div> -->
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal form-row" method="GET" action="{{ route('gestor.acompanhamento.index') }}">
        <div class="form-group col-sm">
            <div class="input-group">
                <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
                <span class="input-group-append">
                    <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                </span>
            </div>
        </div>
    </form>
</div>

@if($viveiros)
<div class="card">
    <div class="card-body">
        <h4 class="mb-3 text-center">Escolha um Viveiro <small>({{date('d/m/Y')}})</small></h4>
        
        @php
        $hasViveiro = false;
        @endphp
        @foreach($viveiros as $viveiro)
        @if($viveiro->situacaoCultivo)
        @php
        $hasViveiro = true;
        @endphp
        <a href="{{ route('gestor.acompanhamento.save', ['id' => $viveiro->producao_id, 'vId' => $viveiro->viveiro_id]) }}" class="btn btn-primary d-block mb-3 mx-2">
            <strong>{{$viveiro->nome}} @if($viveiro->categoriaCultivo)| {{$cultivo->present()->getCategoria($viveiro->categoriaCultivo)}}@endif</strong>
        </a>
        @endif
        @endforeach

        @if(!$hasViveiro)
        <p class="alert alert-danger h6 text-center mb-4"><i class="fa-solid fa-triangle-exclamation"></i> Não possui viveiros em produção.</p>
        @endif
    </div>
</div>
@endif
@endsection
