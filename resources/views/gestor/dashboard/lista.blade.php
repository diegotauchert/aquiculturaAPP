@extends('layouts.gestor.app')

@section('title', __('gestor_dashboard.titulo'))

@section('content')

<script defer src="{{ asset(mix('js/dashboard.init.js')) }}" type="text/javascript"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title"><i class="fas fa-tachometer-alt"></i> Dashboard <small class="mr-2"> / Usuário Tipo: {{ Auth::guard('gestor')->user()->present()->makeTipo[0] }}</small>@if(Auth::guard('gestor')->user()->fazenda)<small>/ {{ Auth::guard('gestor')->user()->fazenda->nome }}</small>@endif</h4>
            @if(Auth::guard('gestor')->user()->cliente && Auth::guard('gestor')->user()->cliente->dt_expira && Auth::guard('gestor')->user()->cliente->externo && Auth::guard('gestor')->user()->cliente->dt_expira >= date("Y-m-d H:i:s"))
            <small class="mr-2 text-danger">
                <i class="fas fa-exclamation-triangle"></i> Seu acesso expira <strong>{{ Carbon\Carbon::parse(Auth::guard('gestor')->user()->cliente->dt_expira)->diffForHumans() }}</strong>
            </small>
            @endif
        </div>
    </div>
</div>

@if(auth('gestor')->user()->tipo == 5)
<div class="row main-menu">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body d-flex gap-2">
                <div class="item">
                    <a href="{{ route('gestor.produtos.index') }}" title="Clique para acessar">
                        <i class="fa-solid fa-box"></i>
                        <span>Produtos</span>
                    </a>
                </div>
                <div class="item">
                    <a href="{{ route('gestor.mensagens.index') }}" title="Clique para acessar">
                        <i class="fa-solid fa-message"></i>
                        <span>Mensagens</span>
                    </a>
                </div>
                @if(auth('gestor')->user()->fazenda_id)
                <div class="item">
                    <a href="{{ route('gestor.vendas.index') }}" title="Clique para acessar">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span>Vendas</span>
                    </a>
                </div>
                @endif
                <div class="item">
                    <a href="{{ route('gestor.viveiros.index') }}" title="Clique para acessar">
                        <i class="fa-solid fa-fish"></i>
                        <span>Viveiro</span>
                    </a>
                </div>
                <div class="item">
                    <a href="{{ route('gestor.cultivos.index') }}" title="Clique para acessar">
                        <i class="fa-sharp fa-solid fa-seedling"></i>
                        <span>Cultivo</span>
                    </a>
                </div>
                <div class="item">
                    <a href="{{route('gestor.cadastro.index')}}" title="Clique para acessar">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Cadastro</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(auth('gestor')->user()->tipo == 6 || auth('gestor')->user()->tipo == 7)
<div class="row main-menu">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body d-flex gap-2">
                <div class="item">
                    <a href="{{ route('gestor.mensagens.index') }}" title="Clique para acessar">
                        <i class="fa-solid fa-message"></i>
                        <span>Mensagens</span>
                    </a>
                </div>
                <div class="item">
                    <a href="{{ route('gestor.viveiros.index') }}" title="Clique para acessar">
                        <i class="fa-solid fa-fish"></i>
                        <span>Viveiro</span>
                    </a>
                </div>
                <div class="item">
                    <a href="{{ route('gestor.cultivos.index') }}" title="Clique para acessar">
                        <i class="fa-sharp fa-solid fa-seedling"></i>
                        <span>Cultivo</span>
                    </a>
                </div>
                <div class="item">
                    <a href="{{route('gestor.producao.index')}}" title="Clique para acessar">
                        <i class="fa-solid fa-industry"></i>
                        <span>Produção</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(auth('gestor')->user()->tipo == 8)
<div class="row main-menu">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body d-flex gap-2">
                <div class="item">
                    <a href="{{ route('gestor.mensagens.index') }}" title="Clique para acessar">
                        <i class="fa-solid fa-message"></i>
                        <span>Mensagens</span>
                    </a>
                </div>
                <div class="item">
                    <a href="{{ route('gestor.acompanhamento.index') }}" title="Clique para acessar">
                        <i class="fa-solid fa-pencil"></i>
                        <span>Acompanhamento</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(auth('gestor')->user()->tipo == 4)
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 mb-4">Ração em Estoque</h4>
                <div id="chartRacao" class="apex-charts"></div>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 mb-4">Viveiros - Status</h4>
                <div id="chartViveiros" class="apex-charts"></div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h4 class="header-title mt-0 mb-4"><i class="fas fa-balance-scale"></i> Biomassa estimada por gramatura <small id="current-week"><i class="fas fa-calendar-alt"></i> semana atual</small></h4>
        <div id="chartProducao" class="apex-charts"></div>
        <p id="no-data" class="text-danger"></p>
    </div>
</div>
@endif

@if($produtos && count($produtos) > 0)
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive pt-2">
            <div class="card">
                <div class="card-body overflow-auto">
                    <div class="d-flex">
                        <h4 class="header-title mt-0 mb-4"><i class="fas fa-exclamation-triangle"></i> Produtos com estoque abaixo do Mínimo <small>({{$produtos->count()}} registros)</small></h4>
                        <div class="mobile-scroll-auto text-muted ml-auto">
                            <i class="fas fa-exchange-alt mr-2"></i> <small>Role para os lados</small>
                        </div>
                    </div>
                    <table width="100%" class="table table-striped table-hover" id="datatable">
                        <thead>
                            <th class="align-middle">Nome</th>
                            <th class="align-middle">Detalhes</th>
                            <th class="align-middle"></th>
                        </thead>
                        <tbody>
                            @foreach($produtos as $post)
                            <tr>
                                <td class="align-middle text-danger"><strong><i class="fas fa-exclamation-triangle"></i> {{ $post->nome }}</strong></td>
                                <td class="align-middle text-danger"><strong> <small>Qtd Atual:</small> {{ $post->quantidade }}<br /><small>Mínimo:</small> {{ $post->minimo }}</strong></td>
                                <td class="align-middle text-right">
                                    <div class="btn-group">
                                        <a href="{{ route('gestor.lotes.create', ['id' => $post->id]) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Novo Lote"><span class="fas fa-plus"></span> Novo Lote</a>
                                        <a href="{{ route('gestor.produtos.edit', $post->id) }}" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> Visualizar</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(auth('gestor')->user()->tipo >= 4)
@if(count($producao) > 0)
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive pt-2">
            <div class="card">
                <div class="card-body overflow-auto">
                    <div class="d-flex">
                        <h4 class="header-title mt-0 mb-4"><i class="fa-solid fa-industry"></i> Produção <small>({{$producao->count()}} registros)</small></h4>
                        <div class="mobile-scroll-auto text-muted ml-auto">
                            <i class="fas fa-exchange-alt mr-2"></i> <small>Role para os lados</small>
                        </div>
                    </div>
                    <table width="100%" class="table table-striped table-hover" id="datatable">
                        <thead>
                            <th class="align-middle">Usuário</th>
                            <th class="align-middle">Categoria</th>
                            <th class="align-middle">Detalhes</th>
                            <th class="align-middle">Realizado dia</th>
                        </thead>
                        <tbody>
                            @foreach($producao as $post)
                            <tr>
                                <td class="align-middle"><strong><i class="fas fa-user"></i> {{ $post->usuario->nome }}</strong></td>
                                <td class="align-middle"><strong>{{ $post->present()->makeCategoria[0] }}</strong></td>
                                <td class="align-middle">
                                    <small>
                                        @if($post->qtd)<span class="nowrap">Quantidade: <strong>{{ $post->qtd }}</strong></span><br />@endif
                                        @if($post->ph)<span class="nowrap">PH: <strong>{{ $post->ph }}</strong></span><br />@endif
                                        @if($post->salinidade)<span class="nowrap">Salinidade: <strong>{{ $post->salinidade }}</strong></span><br />@endif
                                        @if($post->turbidez)<span class="nowrap">Turbidez: <strong>{{ $post->turbidez }}</strong></span><br />@endif
                                        @if($post->alcalinidade)<span class="nowrap">Alcalinidade: <strong>{{ $post->alcalinidade }}</strong></span><br />@endif
                                        @if($post->oxigenio)<span class="nowrap">Oxigênio Dissolvido: <strong>{{ $post->oxigenio }}</strong></span><br />@endif
                                        @if($post->temperatura)<span class="nowrap">Temperatura: <strong>{{ $post->temperatura }}</strong></span><br />@endif
                                        @if($post->tara)<span class="nowrap">Tara da Balança: <strong>{{ $post->tara }}</strong></span><br />@endif
                                        @if($post->gramatura)<span class="nowrap">Gramatura Total: <strong>{{ $post->gramatura }}</strong></span><br />@endif
                                        @if($post->despesca)<span class="nowrap">Previsão de despesca: <strong>{{ $post->despesca->format('d/m/Y') }}</strong></span><br />@endif
                                        @if($post->produto)<span class="nowrap">Produto: <strong>{{ $post->produto->nome }}</strong></span><br />@endif
                                        <!-- @if($post->categoria_id == 1)
                                            @php
                                                $acompanhamentos = \App\Models\Acompanhamento::where('cliente_id', auth('gestor')->user()->cliente_id)
                                                            ->where('fazenda_id', auth('gestor')->user()->fazenda_id)
                                                            ->where('producao_id', $post->id)
                                                            ->where('viveiro_id', $post->viveiro_id)
                                                            ->orderBy('data', 'DESC')
                                                            ->limit(20)
                                                            ->get();
                                            @endphp
                                            @if($acompanhamentos && count($acompanhamentos) > 0)
                                            <p>Acompanhamento - Últimos 20 registros</p>
                                            <div class="table-responsive pt-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table width="100%" class="table table-striped table-hover" id="datatable">
                                                            <thead>
                                                                <th class="align-middle">Dia</th>
                                                                <th class="align-middle">Horário</th>
                                                                <th class="align-middle">Arraçoamento</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($acompanhamentos as $post)
                                                                <tr>
                                                                    <td class="align-middle"><i class="fa-solid fa-check"></i> {{ $post->data->format("d/m/Y H:i") }}</td>
                                                                    <td class="align-middle"><strong>{{ $post->horario }}</strong></td>
                                                                    <td class="align-middle">{{ $post->arracoamento }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endif -->
                                    </small>
                                </td>
                                <td class="align-middle"><small><i class="fas fa-calendar-alt"></i> {{ $post->created_at->diffForHumans()}}<br />{{ $post->created_at->format("d/m/Y H:i") }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endif

@if(auth('gestor')->user()->tipo <= 3)
<div class="row">
    <div class="col-lg-12 table-responsive">
        <div class="cards">

                <div class="row mx-0 mb-4">
                    <div class="col-sm p-3 bg-white mr-3 bg-dash">
                        <h4 class="header-title my-2"><i class="fas fa-users"></i> Clientes Ativos</h4>
                        <h2>{{$clientesAtivos}}</h2>
                    </div>
                    <div class="col-sm p-3 bg-white mr-3 bg-dash">
                        <h4 class="header-title my-2"><i class="fas fa-user-slash"></i> Clientes Inativos</h4>
                        <h2>{{$clientesInativos}}</h2>
                    </div>
                    <div class="col-sm p-3 bg-white bg-dash">
                        <h4 class="header-title my-2"><i class="fas fa-user-clock"></i> Clientes em Teste Gratuito</h4>
                        <h2>{{$clientesTeste}}</h2>
                    </div>
                </div>

        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-lg-12 table-responsive">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 mb-4"><i class="fas fa-user-secret"></i> Atividades no Sistema <small>({{$logs->count()}} registros)</small></h4>
                <div class="slimscroll hospital-dash-activity">
                    <div class="activity">
                        <table width="100%" class="table table-striped table-hover" id="datatable">
                            <tbody>
                                @if(count($logs) > 0)
                                @php
                                $i = 0;
                                @endphp
                                @foreach($logs as $key => $log)
                                @php
                                $i++;
                                @endphp

                                @if($log->usuario)
                                <tr>
                                    <td class="align-middle">
                                        @if($i == 1)
                                        <i class="mdi mdi-checkbox-marked-circle-outline icon-success"></i>
                                        @elseif($i == 2)
                                        <i class="mdi mdi-timer-off icon-pink"></i>
                                        @elseif($i == 3)
                                        <i class="mdi mdi-alert-decagram icon-purple"></i>
                                        @elseif($i == 4)
                                        <i class="mdi mdi-clipboard-alert icon-warning"></i>
                                        @elseif($i == 5)
                                        <i class="mdi mdi-thumb-up icon-info"></i>
                                        @php
                                        $i = 0;
                                        @endphp
                                        @endif
                                    </td>
                                    <td class="align-middle col-lg">
                                        <div class="time-item">
                                            <div class="item-info m-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="m-0 mt-2">{{ $log->usuario->nome }} <small>({{ $log->usuario->login }})</small></h5>
                                                    <span class="text-muted"> {{ $log->data->format("d/m/Y H:i") }}<br />{{ $log->data->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-muted mt-2">{{ $log->present()->descricao }}
                                                    <a href="" class="text-info"><strong>{{ $log->ip }}</strong></a>
                                                </p>
                                                <div>
                                                    <a title="{{ ($log->present()->agent->device() ? $log->present()->agent->device() . ' ' : '') }}{{ $log->present()->agent->platform() }} {{ $log->present()->agent->version($log->present()->agent->platform()) }}"><em class="fab h5 fa-{{ $log->present()->iconeSistema }}"></em></a>
                                                    <a title="{{ $log->present()->agent->browser() }} {{ $log->present()->agent->version($log->present()->agent->browser()) }}"><em class="fab h5 fa-{{ $log->present()->iconeNavegador }}"></em></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
