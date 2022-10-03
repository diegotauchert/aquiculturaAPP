@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_curriculo.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_curriculo.titulo')
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
    @permissao('gestor', 'gestor.curriculos.create')
    <div class="col col-sm-auto my-auto py-2 text-center text-md-right">
        <a href="{{ route('gestor.curriculos.create') }}" class="btn btn-primary"><span class="fas fa-asterisk"></span> @lang('gestor_curriculo.create')</a>
    </div>
    @endpermissao
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal" method="GET" action="{{ route('gestor.curriculos.index') }}">
        <div class="input-group">
            <input name="f_p" id="f_p" value="{{ $f_p }}" type="text" maxlength="250" class="form-control" placeholder="@lang('gestor.search')">
            <span class="input-group-append">
                <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
            </span>
        </div>
    </form>
</div>
@if(count($curriculos) > 0)
<div class="table-responsive pt-2">
    <div class="card">
        <div class="card-body">
            <table width="100%" class="table table-striped table-hover" id="datatable">
                <thead>
                <th class="align-middle">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input all-ite" type="checkbox">
                        <span class="custom-control-label">@lang('gestor_curriculo.nome') / @lang('gestor_curriculo.cpf')</span>
                    </label>
                </th>
                <th class="align-middle">@lang('gestor_curriculo.vaga')</th>
                <th class="align-middle">@lang('gestor_curriculo.telefone') / @lang('gestor_curriculo.email')</th>
                <th class="align-middle">@lang('gestor_curriculo.atualizado')</th>
                <th class="align-middle">@lang('gestor_curriculo.situacao')</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($curriculos as $curriculo)
                    <tr>
                        <td class="align-middle">
                            <label class="custom-control custom-checkbox">
                                <input name="ite[{{ $curriculo->id }}]" type="checkbox" class="custom-control-input ite">
                                <span class="custom-control-label">
                                    @permissao('gestor', 'gestor.curriculos.pdf')
                                    <a data-toggle="tooltip" style="font-size:15px;" target="_blank" href="{{ route('gestor.curriculos.pdf', $curriculo->id) }}"><i class="fas fa-file-pdf"></i></a>
                                    @endpermissao
                                    {{ $curriculo->nome }}<br>
                                    {{ $curriculo->cpf }}<br>
                                </span>
                            </label>
                        </td>
                        <td class="align-middle">
                            @if($curriculo->vaga)
                            {{ $curriculo->vaga->nome }}
                            @endif
                            @if($curriculo->salario)
                            <br />
                            <small>Pretensão</small> R$ {{ $curriculo->salario }}
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($curriculo->telefone)
                            <button class="btn btn-outline-dark border-0 copy" data-clipboard-text="{{ $curriculo->telefone }}">{{ $curriculo->telefone }}</button><br>
                            @endif
                            @if($curriculo->email)
                            <a href="mailto:{{ $curriculo->email }}" class="btn btn-outline-dark border-0">{{ $curriculo->email }}</a><br>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($curriculo->updated_at)
                            @datetime($curriculo->updated_at)
                            @endif
                        </td>
                        <td class="align-middle {{ $curriculo->present()->makeSituacao[1] }} stiuacao-{{ $curriculo->situacao }}"><span class="fas fa-{{ $curriculo->present()->makeSituacao[1] }}"></span> {{ $curriculo->present()->makeSituacao[0] }}</td>
                        <td class="align-middle text-right">
                            <form method="POST" action="{{ route('gestor.curriculos.destroy', $curriculo->id) }}">
                                @method('DELETE')
                                @csrf

                                <div class="btn-group">
                                    @permissao('gestor', 'gestor.curriculos.edit')
                                    <a href="{{ route('gestor.curriculos.edit', $curriculo->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                                    @endpermissao
                                    @permissao('gestor', 'gestor.curriculos.destroy')
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
{{ $curriculos->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
