@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_fazenda.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_fazenda.titulo')
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.fazendas.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_fazenda.create')</a>
    </div>
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.fazendas.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>

@if(count($fazendas) > 0)
<div class="table-responsive pt-2">
    <div class="card">
        <div class="card-body">
            <table width="100%" class="table table-striped table-hover" id="datatable">
                <thead>
                <th class="align-middle">@lang('gestor_fazenda.id')</th>
                <th class="align-middle">@lang('gestor_fazenda.title')</th>
                <th class="align-middle">@lang('gestor_fazenda.contato')</th>
                <th class="align-middle">Usuário(s)</th>
                <th class="align-middle">@lang('gestor_fazenda.gestor')</th>
                <th class="align-middle">@lang('gestor_fazenda.situacao')</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($fazendas as $post)
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
                        <td class="align-middle">{{ $post->telefone }}</td>
                        <td class="align-middle users-fazenda">
                            @if($post->usuarios())
                            <div class="users-all">
                                @foreach($post->usuarios()->get() as $usuario)
                                <div class="user-single">
                                    <strong>{{ $usuario->present()->makeTipo[0] }}</strong><br />
                                    <small>login: </small>{{ $usuario->login }}<br />
                                    <small>senha: </small>{{ $usuario->password_decoded }}<br />
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </td>
                        <td class="align-middle">{{ $post->cliente->nome }}</td>
                        <td class="align-middle"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.fazendas.destroy', $post->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    <a href="{{ route('gestor.fazendas.usuario', $post->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Usuários"><span class="fas fa-user"></span> Usuários</a>
                                    <a href="{{ route('gestor.fazendas.edit', $post->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
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
{{ $fazendas->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
