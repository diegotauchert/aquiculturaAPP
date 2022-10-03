@if($depoimento->foto)
<div class="item col-md-6 my-auto py-3">
    <div class="card">
        <a href="{{ $depoimento->foto->url() }}" class="preview" data-preview-t="img" data-preview-size="large"><img class="card-img" src="{{ $depoimento->foto->url() }}"></a>
        <div class="card-body text-center">
            <button type="button" class="remove-upload-unique btn btn-danger" data-toggle="tooltip" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span></button>
            <input name="f_foto[]" class="name-upload" type="hidden" value="{{ $depoimento->foto }}">
            <input name="f_foto_del[]" class="del-upload" type="hidden" value="">
        </div>
    </div>
</div>
@endif
