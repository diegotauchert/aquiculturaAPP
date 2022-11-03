@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_venda.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_venda.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.vendas.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_venda.create')</a>
    </div>
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.vendas.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>
@if(count($vendas) > 0)
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
                <th class="align-middle">Código</th>
                <th class="align-middle">Cliente</th>
                <th class="align-middle">Viveiro</th>
                <th class="align-middle">Detalhes</th>
                <th class="align-middle">Quantidades</th>
                <th class="align-middle">Vendedor</th>
                <th class="align-middle">Registrado dia</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($vendas as $post)
                    <tr>
                        <td class="align-middle">
                            {{$post->id}}
                        </td>
                        <td class="align-middle">
                            <span>
                                {{ $post->nome }}<br />
                                <small>Tel.: {{ $post->telefone }}</small>
                            </span>
                            @if($post->arquivo)
                                <a href="{{ $post->arquivo->url() }}" target="_blank" title="Ver Anexo" style="font-size:16px;"><i class="fa-solid fa-paperclip"></i></a>
                            @endif
                        </td>
                        <td class="align-middle">
                            {{ $post->viveiro->nome }}<br />
                            <small>{{ $post->fazenda->nome }}</small>
                        </td>
                        <td class="align-middle">
                            <p>
                                @if($post->vl_total)<small class="nowrap">Total: <strong>R$ {{ $post->vl_total }}</strong></small><br />@endif
                                @if($post->tipo)<small>Tipo: <strong>{{ $post->tipo }}</strong></small><br />@endif
                                @if($post->data)<small>Data: <strong>{{ Carbon\Carbon::parse($post->data)->format('d/m/Y') }}</strong></small><br />@endif
                            </p>
                        </td>
                        <td class="align-middle">
                            @if($post->qtd_peixe)
                            <p style="line-height: 14px;border: 1px solid #DDD;border-radius: 4px;padding: 7px 9px; margin-bottom:.5rem;">
                                @if($post->vl_peixe)<small class="nowrap"><strong>Peixe: R$ {{ $post->vl_peixe }}</strong></small><br />@endif
                                @if($post->qtd_peixe)<small>Qtd: <strong>{{ $post->qtd_peixe }}</strong></small><br />@endif
                                @if($post->gramatura_peixe)<small>Gramatura: <strong>{{ $post->gramatura_peixe }}</strong></small><br />@endif
                            </p>
                            @endif
                            @if($post->qtd_camarao)
                            <p style="line-height: 14px;border: 1px solid #DDD;border-radius: 4px;padding: 7px 9px;">
                                @if($post->vl_camarao)<small class="nowrap"><strong>Camarão: R$ {{ $post->vl_camarao }}</strong></small><br />@endif
                                @if($post->qtd_camarao)<small>Qtd: <strong>{{ $post->qtd_camarao }}</strong></small><br />@endif
                                @if($post->gramatura_camarao)<small>Gramatura: <strong>{{ $post->gramatura_camarao }}</strong></small><br />@endif
                            </p>
                            @endif
                        </td>
                        <td class="align-middle">{{ $post->usuario->nome }}</td>
                        <td class="align-middle"><small>{{ $post->created_at->format("d/m/Y") }}<br />{{ $post->created_at->diffForHumans() }}</small></td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.vendas.destroy', $post->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    <a href="{{ route('gestor.vendas.edit', $post->id) }}" class="btn btn-outline-primary btn-sm nowrap" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    <a href="{{ route('gestor.vendas.edit', $post->id) }}#anexo" class="btn btn-outline-success btn-sm nowrap" data-toggle="tooltip" title="Anexar Arquivo"><span class="fas fa-paperclip"></span> Anexo</a>
                                    <!-- <button type="submit" class="confirm btn btn-outline-danger btn-sm nowrap" data-toggle="tooltip" data-title="@lang('gestor.confirm_destroy')" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span> @lang('gestor.destroy')</button> -->
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
{{ $vendas->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
