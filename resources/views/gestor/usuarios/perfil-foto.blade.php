@if($usuario->foto)
<div class="item col-6 col-sm-4 col-md-5 col-lg-4 my-auto py-3">
    <div class="card">
        <a href="{{ $usuario->foto->url() }}" class="preview" data-preview-t="img" data-preview-size="large"><img class="card-img rounded-circle" src="{{ $usuario->foto->url() }}"></a>
        <div class="card-body text-center">
            <button type="button" class="remove-upload-unique btn btn-danger" data-toggle="tooltip" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span></button>
            <input name="f_foto[]" type="hidden" value="{{ $usuario->foto }}">
        </div>
    </div>
</div>
@endif