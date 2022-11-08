@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_plano.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_plano.titulo') - Assinaturas
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
</div>
@if(count($substriptions) > 0)
<div class="table-responsive pt-2">
    <div class="card">
        <div class="d-flex pt-3 pr-3">
            <div class="mobile-scroll-auto text-muted ml-auto">
                <i class="fas fa-exchange-alt mr-2"></i> <small>Role para os lados</small>
            </div>
        </div>
        <div class="card-body overflow-auto">
            <table width="100%" class="table table-striped table-hover" id="datatable">
                <thead>
                <th class="align-middle">Realizado dia</th>
                <th class="align-middle">Plano</th>
                <th class="align-middle">Cliente</th>
                <th class="align-middle">Cartão</th>
                <th class="align-middle">Período</th>
                <!-- <th class="align-middle text-right">@lang('gestor.action')</th> -->
                </thead>
                <tbody>
                    @foreach($substriptions as $post)
                    <tr>
                        <td class="align-middle"><i class="fas fa-calendar-alt"></i> <small>{{ Carbon\Carbon::parse($post->date_created)->format('d/m/Y H:i') }}</small><br /><small>{{ Carbon\Carbon::parse($post->date_created)->diffForHumans() }}</small></td>
                        <td class="align-middle">{{ $post->plan->name }}</td>
                        <td class="align-middle">{{ $post->customer->name }}<br />{{ $post->customer->email }}<br />({{ $post->phone->ddd }}) {{ $post->phone->number }}</td>
                        <td class="align-middle">{{ $post->card_brand }}<br />{{ $post->card_last_digits }}</td>
                        <td class="align-middle"><small class="nowrap"><i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($post->current_period_start)->format('d/m/Y H:i') }} até <strong>{{ Carbon\Carbon::parse($post->current_period_end)->format('d/m/Y H:i') }}</strong></small></td>
                        <!-- <td class="align-middle text-right">
                            
                        </td> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
