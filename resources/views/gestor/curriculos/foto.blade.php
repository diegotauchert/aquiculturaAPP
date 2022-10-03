@if($curriculo->foto)
<div class="item col-md-6 my-auto">
    <div class="">
        <a href="{{ $curriculo->foto->url() }}" class="preview" data-preview-t="img" data-preview-size="large">
            <img class="card-img foto-curriculo" src="{{ $curriculo->foto->url() }}" style="width:200px;" />
        </a>
        <div class="card-body text-center">
            <button type="button" class="remove-upload-unique btn btn-danger" data-toggle="tooltip" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span></button>
            <input name="f_foto" class="name-upload" type="hidden" value="{{ $curriculo->foto }}">
            <input name="f_foto_del" class="del-upload" type="hidden" value="">
        </div>
    </div>
</div>
@endif
