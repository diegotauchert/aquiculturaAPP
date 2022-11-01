@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_producao.titulo'))

@section('content')

<script defer src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>
<script defer src="https://apexcharts.com/samples/assets/ohlc.js"></script>

<script defer src="{{ asset(mix('js/dashboard.init.js')) }}" type="text/javascript"></script>

<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_producao.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3>Biomassa estimada por gramatura <small id="current-week"><i class="fas fa-calendar-alt"></i> semana atual</small></h3>
        <div id="chartProducao" class="apex-charts"></div>
        <p id="no-data" class="text-danger"></p>
    </div>
</div>

@endsection
