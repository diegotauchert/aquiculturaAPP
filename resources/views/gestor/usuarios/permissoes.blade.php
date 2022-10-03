@if(count($modulos->where('situacao', '=', 1)) > 0)
<div id="mark" class="py-2">
    <div class="card marking">
        <div class="card-header h5">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="mark-all custom-control-input">
                <span class="custom-control-label">@lang('gestor_usuario.permissoes_acesso')</span>
            </label>
        </div>
        <div class="card-body">
            <div class="form-row">
                @foreach($modulos->where('situacao', '=', 1) as $modulo)
                @include('gestor.usuarios.modulo')
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
