@extends('layouts.gestor.app')

@if($acompanhamento->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_acompanhamento.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_acompanhamento.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_acompanhamento.titulo')
            @if($acompanhamento->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>

<form method="POST" action="{{ route('gestor.acompanhamento.store') }}" id="submitForm">
    @csrf

    <input type="hidden" name="producao_id" id="producao_id" value="{{$producao->producao_id}}" />
    <input type="hidden" name="produto_id" id="produto_id" value="{{$producao->produtoId}}" />
    <input type="hidden" name="viveiro_id" id="viveiro_id" value="{{$producao->viveiro_id}}" />
    <input type="hidden" name="producao_horario_id" id="producao_horario_id" />
    <input type="hidden" name="save_hour" id="save_hour" />
    <input type="hidden" name="save_message" id="save_message" />

    <div class="py-2">
        <div class="card">
            @if($producao->produto)
            <div class="card-header h5">Produto: {{$producao->produto}}</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_produto" class="form-control-label">Produto @if($producao->qtdProduto)<small>(Resta {{$producao->qtdProduto}} em estoque)</small>@endif</label>
                        <input name="f_produto" readonly id="f_produto" type="text" value="{{ $producao->produto }}" class="form-control" />
                        @error('f_produto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-sm">
                        <label for="f_qtd" class="form-control-label">Quantidade Diária</label>
                        <input name="f_qtd" readonly id="f_qtd" type="text"
                            value="{{ (old('f_qtd') ? old('f_qtd') : $producao->qtd) }}" class="form-control" />

                        @error('f_qtd')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                @if($producaoHorarios)
                <h4>Registro Diário <small>{{date('d/m/Y')}}</small></h4>
                @php
                $totalHorarios = count($producaoHorarios);
                @endphp

                @if($producao->qtd && $totalHorarios)
                <input name="qtd_lote" id="qtd_lote" type="hidden" value="{{$producao->qtd / $totalHorarios}}" />
                @endif

                <div class="arracoamentos">
                    @foreach($producaoHorarios as $key => $p)
                    @php
                    $disabled = false;
                    $registered = false;
                    $horaFaltante = null;
                    @endphp
                    @if(strtotime($p->hora) > strtotime(date('H:i')))
                    @php
                    $disabled = true;
                    $horaFaltante = strtotime($p->hora) - strtotime(date('H:i'));
                    $hours = (int)($horaFaltante/60/60);
                    $minutes = (int)($horaFaltante/60)-$hours*60;
                    $seconds = (int)$horaFaltante-$hours*60*60-$minutes*60;
                    @endphp
                    @endif

                    @if($p->horario)
                    @php
                    $registered = true;
                    @endphp
                    @endif

                    <div class="arracoamento mb-4 @if($disabled) disabled @endif @if($registered) registered @endif">
                        <div class="form-row">
                            @if($registered)
                            <div class="form-group col-xs m-0 d-flex align-self-center align-items-center justify-content-center text-center mb-2">
                                <i class="fa-solid fa-2x fa-check"></i>
                            </div>
                            @endif
                        
                            <div class="form-group col-md">
                                <label for="f_arracoamento-{{$p->horario_id}}" class="form-control-label d-flex justify-content-between">
                                    <strong>Arraçoamento {{$key + 1}} </strong>
                                    @if($disabled)
                                        <em><small> Indisponivel no momento - Falta <strong>{{ sprintf("%02d", $hours) }}:{{sprintf("%02d", $minutes)}}</strong> hr para liberar</small></em>
                                    @endif
                                    @if($registered)
                                    <em><small> - Registrado às <strong>{{ Carbon\Carbon::parse($p->data)->format("d/m/Y H:i") }}</strong></small></em>
                                    @endif
                                    @if($producao->qtd && $totalHorarios)<small>Qtd: <strong>{{ $producao->qtd / $totalHorarios }}</strong></small>@endif
                                </label>

                                <input @if($disabled || $registered) disabled @endif name="f_arracoamento[{{$p->horario_id}}]" id="f_arracoamento-{{$p->horario_id}}" type="text" value="{{$p->arracoamento ?? date('d/m/Y')}}" class="form-control" />
                                @error('save_message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md">
                                <label for="f_horario-{{$p->horario_id}}" class="form-control-label"><strong><i class="fa-regular fa-clock"></i> Horário</strong></label>
                                <input name="f_horario[{{$p->horario_id}}]" id="f_horario-{{$p->horario_id}}" type="text" readonly value="{{$p->hora}}" class="form-control" />
                                @error('save_hour')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @if(!$registered)
                            <div class="form-group col-xs m-0 d-flex align-items-center align-self-center">
                                <button type="button" title="Confirmar Registro?" onClick="saveHour('{{$p->horario_id}}', '{{$p->hora}}')" class="btn btn-outline-primary btn-sm" @if($disabled || $registered) disabled @endif>
                                    <span><i class="fas fa-thumbs-up"></i> Confirmar</span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <p class="alert alert-danger h6 text-center mb-4"><i class="fa-solid fa-triangle-exclamation"></i> Não possui produto em estoque ou está com status inativo.</p>
            @endif
        </div>
    </div>

    @if($acompanhamentosAntigos && count($acompanhamentosAntigos) > 0)
    <h4>Histórico <small>Registros feitos antes do dia {{date('d/m/Y')}}</small></h4>
    <p>Últimos 20 registros</p>
    <div class="table-responsive pt-2">
        <div class="card">
            <div class="card-body overflow-auto">
                <table width="100%" class="table table-striped table-hover" id="datatable">
                    <thead>
                        <th class="align-middle">Dia</th>
                        <th class="align-middle">Horário</th>
                        <th class="align-middle">Arraçoamento</th>
                    </thead>
                    <tbody>
                        @foreach($acompanhamentosAntigos as $post)
                        <tr>
                            <td class="align-middle"><i class="fa-solid fa-check"></i> {{ $post->data->format("d/m/Y H:i") }}<br /><small>{{ $post->data->diffForHumans() }}</small></td>
                            <td class="align-middle"><strong>{{ $post->horario }}</strong></td>
                            <td class="align-middle">{{ $post->arracoamento }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="py-2 text-center">
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span>
            @lang('gestor.cancel')</a>
    </div>
</form>

<script>
    function saveHour(id, hora){
        if (confirm('Gostaria de Registrar o horário de '+hora+'?') == true) {
            let arracoamento = document.getElementById("f_arracoamento-"+id).value;
            document.getElementById('save_hour').value = hora;
            document.getElementById('save_message').value = arracoamento;
            document.getElementById('producao_horario_id').value = id;
            document.getElementById('submitForm').submit();
            alert('Registrado com sucesso!');
        }
    }
</script>
@endsection
