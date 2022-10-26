@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_produto.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_produto.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.produtos.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_produto.create')</a>
    </div>
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal form-row" method="GET" action="{{ route('gestor.produtos.index') }}">
        <div class="form-group col-sm">
            <div class="input-group">
                <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
                <span class="input-group-append">
                    <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                </span>
            </div>
        </div>
        <div class="form-group col-sm">
            <div class="input-group">
                <select name="f_categoria" id="f_categoria" class="form-control selectpicker-custom" title="@lang('gestor_produto.categoria')">
                    <option value=""> - Filtrar pela categoria</option>
                    @foreach($produto->present()->makeCategoriaAll as $sit_k => $sit_v)
                    <option value="{{ $sit_k }}" {{ $sit_k == (old('f_categoria') ? old('f_categoria') : $f_categoria) ? ' selected' : '' }}>
                        {{ $sit_v[0] }}
                    </option>
                    @endforeach
                </select>
                <span class="input-group-append">
                    <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                </span>
            </div>
        </div>
    </form>
</div>
@if(count($produtos) > 0)
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
                <th class="align-middle">@lang('gestor_produto.id')</th>
                <th class="align-middle">@lang('gestor_produto.title')</th>
                <th class="align-middle">Categoria</th>
                <th class="align-middle">Fazenda</th>
                <th class="align-middle">Detalhes</th>
                <th class="align-middle">@lang('gestor_produto.situacao')</th>
                <th class="align-middle">Cadastrado dia</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($produtos as $post)
                    <tr class="@if($post->minimo < $post->quantidade) estoque-ok @elseif($post->minimo == $post->quantidade) estoque-igual alert-warning @else sem-estoque alert-danger bg-warning @endif">
                        <td class="align-middle">
                            {{$post->id}}
                        </td>
                        <td class="align-middle">{{ $post->nome }}</td>
                        <td class="align-middle">{{ $post->present()->makeCategoria[0] }}</td>
                        <td class="align-middle">{{ $post->fazenda->nome }}</td>
                        <td class="align-middle">
                            <p>
                                @if($post->quantidade)<small>Qtd Atual: <strong>{{ $post->quantidade }}</strong></small><br />@endif
                                @if($post->minimo)<small>Mínimo: <strong>{{ $post->minimo }}</strong></small><br />@endif
                                @if($post->vl_total)<small>Valor Total: <strong>R$ {{ $post->vl_total }}</strong></small><br />@endif

                                @if($post->minimo >= $post->quantidade)
                                <span class="badge badge-danger text-white"><i class="fa-solid fa-triangle-exclamation"></i> Ver Estoque</span>
                                @endif
                            </p>
                        </td>
                        <td class="align-middle"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                        <td class="align-middle"><small>{{ $post->created_at->format("d/m/Y") }}<br />{{ $post->created_at->diffForHumans() }}</small></td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.produtos.destroy', $post->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    <a href="{{ route('gestor.lotes.create', ['id' => $post->id]) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Novo Lote"><span class="fas fa-plus"></span> Novo Lote</a>
                                    <a href="{{ route('gestor.produtos.edit', $post->id) }}" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    @if(auth('gestor')->user()->tipo == 4)
                                    <button type="submit" class="confirm btn btn-outline-danger btn-sm" data-toggle="tooltip" data-title="@lang('gestor.confirm_destroy')" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span> @lang('gestor.destroy')</button>
                                    @endif
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
