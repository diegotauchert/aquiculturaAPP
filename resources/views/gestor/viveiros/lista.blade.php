@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_viveiro.titulo'))

@section('content')
<script defer src="{{ asset(mix('js/dashboard.init.js')) }}" type="text/javascript"></script>

<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_viveiro.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.viveiros.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_viveiro.create')</a>
    </div>
</div>
<div class="mx-2">
    @if($cultivos && count($cultivos) > 0)
    <div class="cultivos">
        @foreach($cultivos as $key => $cultivo)
        <span 
            class="btn-cultivo btn-cultivo-{{$cultivo->situacao}}" 
            onClick="mudaCultivoInfo({{$key}})" 
            id="cultivo-btn-{{$key}}"
        >
            {{$cultivo->viveiro->nome}}
        </span>
        @endforeach
    </div>
    <br />
    @foreach($cultivos as $key => $cultivo)
    <div class="cultivo-info container card mb-3 px-4 py-3" id="cultivo-info-{{$key}}" style="display:none;">
        <div class="row card-body">
            <div class="col-sm mb-3">
                <h3 class="text-center h2 m-0 text-cultivo-{{$cultivo->situacao}}">{{$cultivo->viveiro->nome}}</h3>
            </div>
            <div class="col-sm mb-3">
                <h4><i class="fas fa-ruler"></i> <span>Dimensões</span></h4>
                <p>
                    @if($cultivo->viveiro->comprimento)Comprimento: <strong>{{ $cultivo->viveiro->comprimento }} m</strong><br />@endif
                    @if($cultivo->viveiro->largura)Largura: <strong>{{ $cultivo->viveiro->largura }} m</strong><br />@endif
                    @if($cultivo->viveiro->profundidade)Profundidade: <strong>{{ $cultivo->viveiro->profundidade }} m</strong><br />@endif
                    @if($cultivo->viveiro->volume)Volume: <strong>{{ $cultivo->viveiro->volume }} m²</strong><br />@endif
                    @if($cultivo->viveiro->area)Area: <strong>{{ $cultivo->viveiro->area }}</strong> litros<br />@endif
                </p>
            </div>
            <div class="col-sm mb-3">
                <h4><i class="fas fa-tint"></i> <span>Ciclo Atual</span></h4>
                <p>
                    @if($cultivo->povoado)Data de Povoamento: <i class="fas fa-calendar-alt"></i> <strong>{{ $cultivo->povoado->format('d/m/Y') }}</strong><br />@endif
                    @if($cultivo->despesca)Previsão de Despesca: <i class="fas fa-calendar-alt"></i> <strong>{{ $cultivo->despesca->format('d/m/Y') }}</strong><br />@endif
                    @if($cultivo->adensamento)Adensamento: <strong>{{ $cultivo->adensamento }} pl</strong><br />@endif
                    @if($cultivo->biometria)Biometria: <strong>{{ $cultivo->biometria }}</strong><br />@endif
                    @if($cultivo->detalhes)<span>{{ $cultivo->detalhes }}</span><br />@endif
                </p>
            </div>
            <div class="col-sm mb-3">
                <h4><i class="fas fa-calendar-alt"></i> <span>Histórico</span></h4>
                <p>
                    Ciclo 01: <strong>{{ $cultivo->created_at->diffForHumans() }}</strong><br />
                </p>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.viveiros.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>

@if(count($viveiros) > 0)
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
                <th class="align-middle">@lang('gestor_viveiro.id')</th>
                <th class="align-middle">@lang('gestor_viveiro.title')</th>
                <th class="align-middle">Fazenda</th>
                <th class="align-middle">Dimensão</th>
                <th class="align-middle">@lang('gestor_viveiro.situacao')</th>
                <th class="align-middle">Cadastrado dia</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($viveiros as $post)
                    <tr>
                        <td class="align-middle">
                            {{$post->id}}
                        </td>
                        <td class="align-middle">
                            <span>
                                {{ $post->nome }}
                            </span>
                        </td>
                        <td class="align-middle">@if($post->fazenda){{ $post->fazenda->nome }}@else <small class="text-danger">-- Fazenda Deletada, favor excluir viveiro --</small> @endif</td>
                        <td class="align-middle">
                            <p>
                                @if($post->comprimento)<small>Comprimento: <strong>{{ $post->comprimento }} m</strong></small><br />@endif
                                @if($post->largura)<small>Largura: <strong>{{ $post->largura }} m</strong></small><br />@endif
                                @if($post->profundidade)<small>Profundidade: <strong>{{ $post->profundidade }} m</strong></small><br />@endif
                                @if($post->volume)<small>Volume: <strong>{{ $post->volume }} m²</strong></small><br />@endif
                                @if($post->area)<small>Area: <strong>{{ $post->area }}</strong> litros</small><br />@endif
                            </p>
                        </td>
                        <td class="align-middle"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                        <td class="align-middle"><small>{{ $post->created_at->format("d/m/Y") }}<br />{{ $post->created_at->diffForHumans() }}</small></td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.viveiros.destroy', $post->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    <a href="{{ route('gestor.viveiros.edit', $post->id) }}" class="btn btn-outline-primary btn-sm nowrap" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    <!-- <button type="submit" class="confirm btn btn-outline-danger btn-sm" data-toggle="tooltip" data-title="@lang('gestor.confirm_destroy')" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span> @lang('gestor.destroy')</button> -->
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{ $viveiros->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif

@if(auth('gestor')->user()->tipo == 4)
<div class="card mt-4">
    <div class="card-body">
        <h4 class="header-title mt-0 mb-4">Viveiros - Status</h4>
        <div id="chartViveiros" class="apex-charts"></div>
    </div>
</div>
@endif

<script>
    function mudaCultivoInfo(id){
        const btns = document.getElementsByClassName("cultivo-info");
        for (const btn of btns) {
            btn.style.display = 'none';
        }

        document.getElementById("cultivo-info-"+id).style.display = 'block';
    }
</script>
@endsection
