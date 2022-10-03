@extends('layouts.gestor.app')

@section('title', __('gestor_dashboard.titulo'))

@section('content')

<script defer src="{{ asset(mix('js/dashboard.init.js')) }}" type="text/javascript"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <h4 class="page-title">Dashboard</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 mb-4">Atividades no Sistema</h4>
                <div class="slimscroll hospital-dash-activity">
                    <div class="activity">
                        @if(count($logs) > 0)
                        @php
                        $i = 0;
                        @endphp
                        @foreach($logs as $key => $log)
                        @php
                        $i++;
                        @endphp
                        @if($i == 1)
                        <i class="mdi mdi-checkbox-marked-circle-outline icon-success"></i>
                        @elseif($i == 2)
                        <i class="mdi mdi-timer-off icon-pink"></i>
                        @elseif($i == 3)
                        <i class="mdi mdi-alert-decagram icon-purple"></i>
                        @elseif($i == 4)
                        <i class="mdi mdi-clipboard-alert icon-warning"></i>
                        @elseif($i == 5)
                        <i class="mdi mdi-thumb-up icon-info"></i>
                        @php
                        $i = 0;
                        @endphp
                        @endif

                        @if($log->usuario)
                        <div class="time-item">
                            <div class="item-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="m-0">{{ $log->usuario->nome }}</h6>
                                    <span class="text-muted">{{ $log->data->format("d/m/Y H:i") }}</span>
                                </div>
                                <p class="text-muted mt-3">{{ $log->present()->descricao }}
                                    <a href="" class="text-info">{{ $log->ip }}</a>
                                </p>
                                <div>
                                    <a title="{{ ($log->present()->agent->device() ? $log->present()->agent->device() . ' ' : '') }}{{ $log->present()->agent->platform() }} {{ $log->present()->agent->version($log->present()->agent->platform()) }}"><em class="fab h5 fa-{{ $log->present()->iconeSistema }}"></em></a>
                                    <a title="{{ $log->present()->agent->browser() }} {{ $log->present()->agent->version($log->present()->agent->browser()) }}"><em class="fab h5 fa-{{ $log->present()->iconeNavegador }}"></em></a>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>

            </div>  <!--end card-body-->
        </div><!--end card-->
    </div>
</div><!--end row-->
@endsection
