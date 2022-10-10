@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_produto.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_produto.titulo')
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.produtos.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_produto.create')</a>
    </div>
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.produtos.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>
@if(count($produtos) > 0)
<div class="table-responsive pt-2">
    <div class="card">
        <div class="card-body">
            <table width="100%" class="table table-striped table-hover" id="datatable">
                <thead>
                <th class="align-middle">@lang('gestor_produto.id')</th>
                <th class="align-middle">@lang('gestor_produto.title')</th>
                <th class="align-middle">Fazenda</th>
                <th class="align-middle">Detalhes</th>
                <th class="align-middle">@lang('gestor_produto.situacao')</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($produtos as $post)
                    <tr>
                        <td class="align-middle">
                            {{$post->id}}
                        </td>
                        <td class="align-middle">
                            <span>
                                {{ $post->nome }}
                            </span>
                        </td>
                        <td class="align-middle">{{ $post->fazenda->nome }}</td>
                        <td class="align-middle">
                            <p>
                                <small>Qtd Atual: <strong>{{ $post->quantidade }}</strong></small><br />
                                <small>Mínimo: <strong>{{ $post->minimo }}</strong></small><br />
                                <small>Valor Total: <strong>{{ $post->vl_total }}</strong></small><br />
                            </p>
                        </td>
                        <td class="align-middle"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.produtos.destroy', $post->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    <a href="{{ route('gestor.lotes.create', ['id' => $post->id]) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Novo Lote"><span class="fas fa-plus"></span> Novo Lote</a>
                                    <a href="{{ route('gestor.produtos.edit', $post->id) }}" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    <button type="submit" class="confirm btn btn-outline-danger btn-sm" data-toggle="tooltip" data-title="@lang('gestor.confirm_destroy')" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span> @lang('gestor.destroy')</button>
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
{{ $produtos->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
