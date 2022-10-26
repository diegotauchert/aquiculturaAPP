@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_menu.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_menu.titulo')
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    @permissao('gestor', 'gestor.menus.create')
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.menus.create') }}" class="btn btn-primary"><span class="fas fa-asterisk"></span> @lang('gestor_menu.create')</a>
    </div>
    @endpermissao
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.menus.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><span class="fas fa-search"></span></button>
            </span>
        </div>
    </form>
</div>
@if(count($menus) > 0)
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
                <th class="align-middle">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input all-ite" type="checkbox">
                        <span class="custom-control-label">@lang('gestor_menu.nome')</span>
                    </label>
                </th>
                <th class="align-middle">@lang('gestor_menu.link')</th>
                <th class="align-middle">@lang('gestor_menu.ordem')</th>
                <th class="align-middle">@lang('gestor_menu.exibe')</th>
                <th class="align-middle">@lang('gestor_menu.situacao')</th>
                <th class="align-middle">@lang('gestor_menu.referencia')</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr>
                        <td class="align-middle">
                            <label class="custom-control custom-checkbox">
                                <input name="ite[{{ $menu->id }}]" type="checkbox" class="custom-control-input ite">
                                <span class="custom-control-label">{{ $menu->nome }}</span>
                            </label>
                        </td>
                        <td class="align-middle">{{ $menu->link }}</td>
                        <td class="align-middle">{{ $menu->ordem }}</td>
                        <td class="align-middle"><span class="fas fa-{{ $menu->present()->makeExibe[1] }}"></span> {{ $menu->present()->makeExibe[0] }}</td>
                        <td class="align-middle"><span class="fas fa-{{ $menu->present()->makeSituacao[1] }}"></span> {{ $menu->present()->makeSituacao[0] }}</td>
                        <td class="align-middle">{{ $menu->referencia ? $menu->referencia->nome : '-' }}</td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.menus.destroy', $menu->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    @permissao('gestor', 'gestor.menus.edit')
                                    <a href="{{ route('gestor.menus.edit', $menu->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    @endpermissao
                                    @permissao('gestor', 'gestor.menus.destroy')
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
{{ $menus->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
