@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_viveiro.titulo'))

@section('content')
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
                                    <a href="{{ route('gestor.viveiros.edit', $post->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
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
@endsection
