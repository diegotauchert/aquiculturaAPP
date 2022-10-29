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
<form method="POST" action="{{ ($racao && $racao->id ? route('gestor.producao.update', $racao->id) : route('gestor.producao.store')) }}">
    @if($racao && $racao->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <input type="hidden" name="f_categoria" value="{{ $producao->categoria_id }}" />
            <input type="hidden" name="f_viveiro" value="{{ $viveiro->id }}" />

            <div class="card-header h5 text-center">@if($racao && $racao->id) <small>#{{$racao->id}}</small> @endif {{$producao->present()->makeCategoria[0]}} <small>{{date('d/m/Y')}}</small></div>
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

    @if($acompanhamentos && count($acompanhamentos) > 0)
    <p>Últimos 20 registros</p>
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
                        <th class="align-middle">Usuário</th>
                        <th class="align-middle">Realizado dia</th>
                        <th class="align-middle">Detalhes</th>
                    </thead>
                    <tbody>
                        @foreach($acompanhamentos as $post)
                        <tr>
                            <td class="align-middle"><strong>{{ $post->usuario->nome }}</strong></td>
                            <td class="align-middle"><i class="fa-solid fa-check"></i> {{ $post->created_at->format("d/m/Y H:i") }}<br /><small>{{ $post->created_at->diffForHumans() }}</small></td>
                            <td class="align-middle">
                                <small>
                                    @if($post->qtd)<span>Quantidade: <strong>{{ $post->qtd }}</strong></span><br />@endif
                                    @if($post->ph)<span>PH: <strong>{{ $post->ph }}</strong></span><br />@endif
                                    @if($post->salinidade)<span>Salinidade: <strong>{{ $post->salinidade }}</strong></span><br />@endif
                                    @if($post->turbidez)<span>Turbidez: <strong>{{ $post->turbidez }}</strong></span><br />@endif
                                    @if($post->alcalinidade)<span>Alcalinidade: <strong>{{ $post->alcalinidade }}</strong></span><br />@endif
                                    @if($post->oxigenio)<span>Oxigênio Dissolvido: <strong>{{ $post->oxigenio }}</strong></span><br />@endif
                                    @if($post->temperatura)<span>Temperatura: <strong>{{ $post->temperatura }}</strong></span><br />@endif
                                    @if($post->tara)<span>Tara da Balança: <strong>{{ $post->tara }}</strong></span><br />@endif
                                    @if($post->gramatura)<span>Gramatura Total: <strong>{{ $post->gramatura }}</strong></span><br />@endif
                                    @if($post->despesca)<span>Previsão de despesca: <strong>{{ $post->despesca->format('d/m/Y') }}</strong></span><br />@endif
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</form>
@endsection
