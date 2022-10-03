@if(count($usuario->logs) > 0)
<div class="col-md-5">
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_usuario.ultimos_logs')</div>
            <div class="list-group list-group-flush">
                @foreach($logs as $log)
                <div class="list-group-item list-group-item-action{{ ($log->situacao == 2 ? ' list-group-item-danger' : $log->present()->atual) }}">
                    <div class="d-flex">
                        <div class="pr-4 my-auto text-center">
                            <span class="fas fa-2x fa-{{ $log->present()->makeTipo }}"></span>
                        </div>
                        <div class="w-50 my-auto">
                            <p class="h6 m-0">{{ $log->present()->descricao }}</p>
                            <p class="m-0">IP: <span class="font-weight-bold">{{ $log->ip }}</span></p>
                        </div>
                        <div class="w-50 my-auto">
                            <p class="text-right m-0"><small>@datetime($log->data)</small></p>
                            <p class="text-right m-0">
                                <button type="button" class="btn btn-outline-dark border-0 o-tooltip" title="{{ ($log->present()->agent->device() ? $log->present()->agent->device() . ' ' : '') }}{{ $log->present()->agent->platform() }} {{ $log->present()->agent->version($log->present()->agent->platform()) }}"><span class="fab fa-{{ $log->present()->iconeSistema }}"></span></button> 
                                <button type="button" class="btn btn-outline-dark border-0 o-tooltip" title="{{ $log->present()->agent->browser() }} {{ $log->present()->agent->version($log->present()->agent->browser()) }}"><span class="fab fa-{{ $log->present()->iconeNavegador }}"></span></button>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="card-footer">
                {{ $logs->onEachSide(1)->links('vendor.pagination.bootstrap-4-min') }}
            </div>
        </div>
    </div>
</div>
@endif