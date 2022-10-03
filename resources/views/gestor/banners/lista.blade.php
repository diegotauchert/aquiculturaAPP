@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_banner.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_banner.titulo')
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    @permissao('gestor', 'gestor.banners.create')
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.banners.create') }}" class="btn btn-primary"><span class="fas fa-asterisk"></span> @lang('gestor_banner.create')</a>
    </div>
    @endpermissao
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.banners.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>
@if(count($banners) > 0)
<div class="table-responsive pt-2">
    <div class="card">
        <div class="card-body">
            <table width="100%" class="table table-striped table-hover" id="datatable">
                <thead>
                <th class="align-middle">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input all-ite" type="checkbox">
                        <span class="custom-control-label">@lang('gestor_banner.nome')</span>
                    </label>
                </th>
                <th class="align-middle">@lang('gestor_banner.ordem')</th>
                <th class="align-middle">@lang('gestor_banner.tipo')</th>
                <th class="align-middle">@lang('gestor_banner.situacao')</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                    <tr>
                        <td class="align-middle">
                            <label class="custom-control custom-checkbox">
                                <input name="ite[{{ $banner->id }}]" type="checkbox" class="custom-control-input ite">
                                <span class="custom-control-label d-flex align-items-center">
                                    @if($banner->arquivo)
                                    <span>
                                        <img src="{{ $banner->arquivo->url(['w'=>50]) }}" class="w-100">
                                    </span>
                                    @endif
                                    <span class="p-2">
                                        {{ $banner->nome }}
                                        @if($banner->dt_inicio && $banner->dt_fim)
                                        <div class="d-flex">
                                            <div class="align-self-center px-1">
                                                <span class="fas fa-calendar-alt"></span>
                                            </div>
                                            <div class=" align-self-center">
                                                {{ $banner->dt_inicio->format('d/m/Y') }}
                                                a
                                                {{ $banner->dt_fim->format('d/m/Y') }}
                                            </div>
                                        </div>
                                        @endif
                                    </span>
                                </span>
                            </label>
                        </td>

                        <td class="align-middle">{{ $banner->ordem }}</td>
                        <td class="align-middle">{{ $banner->present()->makeTipo }}</td>
                        <td class="align-middle">
                            <span class="fas fa-{{ $banner->present()->makeSituacao[1] }}"></span>
                            {{ $banner->present()->makeSituacao[0] }}
                        </td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.banners.destroy', $banner->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    @permissao('gestor', 'gestor.banners.edit')
                                    <a href="{{ route('gestor.banners.edit', $banner->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    @endpermissao
                                    @permissao('gestor', 'gestor.banners.destroy')
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
{{ $banners->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
