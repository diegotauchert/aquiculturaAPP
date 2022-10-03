@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_pagina.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_pagina.titulo')
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    @permissao('gestor', 'gestor.paginas.create')
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.paginas.create') }}" class="btn btn-primary"><span class="fas fa-asterisk"></span> @lang('gestor_pagina.create')</a>
    </div>
    @endpermissao
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.paginas.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>
@if(count($paginas) > 0)
<div class="table-responsive pt-2">
    <div class="card">
        <div class="card-body">
            <table width="100%" class="table table-striped table-hover" id="datatable">
                <thead>
                <th class="align-middle">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input all-ite" type="checkbox">
                        <span class="custom-control-label">@lang('gestor_pagina.nome')</span>
                    </label>
                </th>
                <th class="align-middle">@lang('gestor_pagina.link')</th>
                <th class="align-middle">@lang('gestor_pagina.situacao')</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($paginas as $pagina)
                    <tr>
                        <td class="align-middle">
                            <label class="custom-control custom-checkbox">
                                <input name="ite[{{ $pagina->id }}]" type="checkbox" class="custom-control-input ite">
                                <span class="custom-control-label">{{ $pagina->nome ?? '' }}</span>
                            </label>
                        </td>
                        <td class="align-middle">{{ $pagina->link }}</td>
                        <td class="align-middle">
                            @if ($pagina->id)
                            <span class="fas fa-{{ $pagina->present()->makeSituacao[1] }}"></span>
                            {{ $pagina->present()->makeSituacao[0] }}
                            @endif
                        </td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.paginas.destroy', $pagina->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    @permissao('gestor', 'gestor.paginas.edit')
                                    <a href="{{ route('gestor.paginas.edit', $pagina->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    @endpermissao
                                    @permissao('gestor', 'gestor.paginas.destroy')
                                    <button type="submit" class="confirm btn btn-outline-danger btn-sm" data-toggle="tooltip" data-title="@lang('gestor.confirm_destroy')" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span> @lang('gestor.destroy')</button>
                                    @endpermissao
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
{{ $paginas->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
