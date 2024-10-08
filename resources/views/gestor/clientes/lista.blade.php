@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_cliente.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_cliente.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    @permissao('gestor', 'gestor.clientes.create')
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.clientes.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_cliente.create')</a>
    </div>
    @endpermissao
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.clientes.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>
@if(count($clientes) > 0)
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
                    <th class="align-middle">@lang('gestor_cliente.nome')</th>
                    <th class="align-middle">@lang('gestor_cliente.data')</th>
                    <th class="align-middle">@lang('gestor_cliente.contato')</th>
                    <th class="align-middle">@lang('gestor_cliente.fazendas')</th>
                    <th class="align-middle">Usuário Principal</th>
                    <th class="align-middle">Cliente em período de teste?</th>
                    <th class="align-middle">@lang('gestor_cliente.situacao')</th>
                    <th class="align-middle">Cadastrado dia</th>
                    <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($clientes as $post)
                    <tr>
                        <td class="align-middle">
                            @if($post->anexos)
                            @if($post->anexos->where('tipo', 1)->count() > 0)
                            @if($post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto)
                            <a href="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url() }}" title="{{ $post->nome }}" class="thumb-href mr-2 preview" target="_blank">
                                <img src="{{ $post->anexos->where('tipo', 1)->sortBy('ordem')[0]->foto->url() }}" alt="Imagem" width="100" />
                            </a>
                            <br />
                            @endif
                            @endif
                            @endif
                            <span>
                                @if($post->categoria)
                                <small class="badge badge-primary text-white">{{ $post->categoria->nome }}</small><br />
                                @endif
                                <small><em>#<strong style="font-size:13px;">{{$post->id}}</strong></em></small><br />
                                {{ $post->nome }}
                            </span>
                        </td>
                        <td class="align-middle">
                            @if($post->dt_nasc)
                            @date($post->dt_nasc)
                            @else
                            -
                            @endif
                        </td>
                        <td class="align-middle">{{ $post->telefone }}<br /><small>{{ $post->email }}</small></td>
                        <td class="align-middle">{{ $post->fazendasCliente->count() }}</td>
                        <td class="align-middle" title="Usuário: {{ $post->usuarioPrincipal }} Senha: {{ $post->senha }}">{{ $post->usuarioPrincipal }}</td>
                        <td class="align-middle">
                            @if($post->externo == 1 && $post->situacao == 1&& $post->dt_expira >= Carbon\Carbon::today())
                            <span class="nowrap"><i class="fas fa-check-square"></i> <small>até dia</small> {{Carbon\Carbon::parse($post->dt_expira)->format("d/m/Y")}}<br /><small>expira {{Carbon\Carbon::parse($post->dt_expira)->diffForHumans()}}</small></span>
                            @endif
                        </td>
                        <td class="align-middle text-{{ $post->present()->makeSituacao[2] }}"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                        <td class="align-middle"><small>{{ $post->created_at->format("d/m/Y") }}<br />{{ $post->created_at->diffForHumans() }}</small></td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.clientes.destroy', $post->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    @permissao('gestor', 'gestor.clientes.edit')
                                    <a href="{{ route('gestor.clientes.edit', $post->id) }}" class="btn btn-outline-primary btn-sm nowrap" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    @endpermissao
                                    <!-- @permissao('gestor', 'gestor.clientes.destroy')
                                    <button type="submit" class="confirm btn btn-outline-danger btn-sm" data-toggle="tooltip" data-title="@lang('gestor.confirm_destroy')" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span> @lang('gestor.destroy')</button>
                                    @endpermissao -->
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
{{ $clientes->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
