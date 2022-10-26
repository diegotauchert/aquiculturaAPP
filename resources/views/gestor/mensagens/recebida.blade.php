@extends('layouts.gestor.app')

@section('title', __('gestor.listagem') . ' - ' . __('gestor_mensagem.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            <a href="/" title="Voltar para o Início" style="font-size:15px;"><i class="fa-solid fa-house"></i></a> <small>\</small> 
            @lang('gestor_mensagem.titulo') Recebidas
            <small class="text-secondary">\ @lang('gestor.listagem')</small>
        </h1>
    </div>
</div>
<div id="busca" class="pb-2">
    <form class="form-horizontal form-row" method="GET" action="{{ route('gestor.mensagens.index') }}">
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
@if(count($mensagens) > 0)
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
                <th class="align-middle">@lang('gestor_mensagem.title')</th>
                <th class="align-middle">Quem enviou</th>
                <th class="align-middle">Fazenda</th>
                <th class="align-middle">Data</th>
                <th class="align-middle">Visualizada?</th>
                <th class="align-middle text-right">@lang('gestor.action')</th>
                </thead>
                <tbody>
                    @foreach($mensagens as $post)
                    <tr>
                        <td class="align-middle">
                            {{ $post->mensagem }}

                            @if($post->arquivo)
                                <a href="{{ $post->arquivo->url() }}" target="_blank" title="Ver Anexo" style="font-size:16px;"><i class="fa-solid fa-paperclip"></i></a>
                            @endif
                        </td>
                        <td class="align-middle">{{ $post->remetente->nome }} <i class="fa-solid fa-arrow-right"></i> {{ $post->destinatario->nome }}</td>
                        <td class="align-middle">{{ $post->fazenda->nome }}</td>
                        <td class="align-middle">{{ Carbon\Carbon::parse($post->data)->format('d/m/Y') }}</td>
                        <td class="align-middle">
                            @if($post->viewed == 1) 
                            <span class="text-success">Sim</span>
                            @else
                            <span class="text-danger">Não</span>
                            @endif
                        </td>

                        <td class="align-middle text-right">
                            <div class="btn-group">
                                <a href="{{ route('gestor.mensagens.see', $post->id) }}" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="@lang('gestor.edit')"><i class="fa-solid fa-eye"></i> Ver</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{ $mensagens->appends(['f_p' => $f_p])->onEachSide(2)->links() }}
@else
<p class="h2 text-center py-5">@lang('gestor.no_data')</p>
@endif
@endsection
