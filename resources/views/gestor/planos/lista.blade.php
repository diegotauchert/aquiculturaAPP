@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_plano.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_plano.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    @permissao('gestor', 'gestor.planos.create')
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.planos.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_plano.create')</a>
    </div>
    @endpermissao
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.planos.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>
@if(count($planos) > 0)
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
                <th class="align-middle">@lang('gestor_plano.id')</th>
                <th class="align-middle">@lang('gestor_plano.title')</th>
                <th class="align-middle">@lang('gestor_plano.qtd_viveiros')</th>
                <th class="align-middle">@lang('gestor_plano.valor')</th>
                <th class="align-middle">Qtd. Fazendas Utilizando</th>
                <th class="align-middle">@lang('gestor_plano.situacao')</th>
                <th class="align-middle">Cadastrado dia</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($planos as $post)
                    <tr>
                        <td class="align-middle">
                            {{$post->id}}
                        </td>
                        <td class="align-middle">
                            @if($post->anexos)
                            @if($post->anexos->where('tipo', 1)->count() > 0)
                            @if($post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto)
                            <a href="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url() }}" title="{{ $post->nome }}" class="thumb-href mr-2" target="_blank">
                                <img src="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url(['w' => 50, 'h' => 50]) }}" />
                            </a>
                            @endif
                            @endif
                            @endif
                            <span>
                                @if($post->categoria)
                                <small class="badge badge-primary text-white">{{ $post->categoria->nome }}</small><br />
                                @endif
                                {{ $post->nome }}
                            </span>
                        </td>
                        <td class="align-middle">{{ $post->qtd_viveiros }}</td>
                        <td class="align-middle">R$ {{ $post->valor }}</td>
                        <td class="align-middle">{{ $post->fazendas->count() }}</td>
                        <td class="align-middle"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                        <td class="align-middle"><small>{{ $post->created_at->format("d/m/Y") }}<br />{{ $post->created_at->diffForHumans() }}</small></td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.planos.destroy', $post->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    <a href="{{ route('gestor.planos.edit', $post->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
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
{{ $planos->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
