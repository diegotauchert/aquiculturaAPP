@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_cultivo.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_cultivo.titulo')
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    <!-- <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.cultivos.create') }}" class="btn btn-primary"><i class="fas fa-asterisk"></i> @lang('gestor_cultivo.create')</a>
    </div> -->
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal form-row" method="GET" action="{{ route('gestor.cultivos.index') }}">
        <div class="form-group col-sm">
            <div class="input-group">
                <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
                <span class="input-group-append">
                    <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                </span>
            </div>
        </div>
    </form>
</div>
@if(count($cultivos) > 0)
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
                <th class="align-middle">@lang('gestor_cultivo.title')</th>
                <th class="align-middle">Categoria</th>
                <th class="align-middle">Fazenda</th>
                <th class="align-middle">Detalhes</th>
                <th class="align-middle">@lang('gestor_cultivo.situacao')</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($cultivos as $post)
                    <tr>
                        <td class="align-middle">{{ $post->nome }}</td>
                        <td class="align-middle">{{ $post->present()->makeCategoria[0] }}</td>
                        <td class="align-middle">{{ $post->fazenda->nome }}</td>
                        <td class="align-middle">
                            <p>
                                @if($post->povoado)<small>Povoado em: <strong>{{ $post->povoado->format('d/m/Y') }}</strong></small><br />@endif
                                @if($post->despesca)<small>Previsão de Despesca: <strong>{{ $post->despesca->format('d/m/Y') }}</strong></small><br />@endif
                                @if($post->tipo)<small>Tipo: <strong>{{ $post->tipo }}</strong></small><br />@endif
                            </p>
                        </td>
                        <td class="align-middle text-{{ $post->present()->makeSituacao[2] }}"><span class="fas fa-{{ $post->present()->makeSituacao[1] }}"></span> {{ $post->present()->makeSituacao[0] }}</td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.cultivos.destroy', $post->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    <a href="{{ route('gestor.cultivos.edit', $post->id) }}" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> Visualizar</a>
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
{{ $cultivos->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
