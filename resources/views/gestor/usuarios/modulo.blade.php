@permissao('gestor', $modulo->link)
<div class="form-group col-lg{{ (count($modulo->modulos) > 2 ? '-12' : '') }} my-auto py-2">
    <div class="card marking m-0">
        <div class="card-header h6">
            <label class="custom-control custom-checkbox">
                <input name="permissoes[]" value="{{ $modulo->id }}" type="checkbox" class="mark-all custom-control-input" @if((in_array($modulo->id, (old('permissoes') ? old('permissoes') : []))) || (count($usuario->permissoes->where('modulo_id', '=', $modulo->id)) > 0)) checked="checked" @endif >
                       <span class="custom-control-label">{{ $modulo->nome }}</span>
            </label>
        </div>
        @if(count($modulo->modulos()->where('situacao', '=', 1)->orderBy('exibe', 'desc')->orderBy('nome', 'asc')->get()) > 0)
        <div class="card-body p-0 mx-5">
            <div class="form-row">
                @foreach($modulo->modulos()->where('situacao', '=', 1)->orderBy('exibe', 'desc')->orderBy('nome', 'asc')->get() as $modulo)
                @include('gestor.usuarios.modulo')
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endpermissao
