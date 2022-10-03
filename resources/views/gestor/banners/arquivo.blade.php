@if($banner->arquivo)
<div class="item col-md-6 my-auto py-3">
    <div class="card">
        <a href="{{ $banner->arquivo->url() }}" class="preview" data-preview-t="img" data-preview-size="large"><img class="card-img" src="{{ $banner->arquivo->url() }}"></a>
        <div class="card-body text-center">
            <button type="button" class="remove-upload-unique btn btn-danger" data-toggle="tooltip" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span></button>
            <input name="f_arquivo[]" class="name-upload" type="hidden" value="{{ $banner->arquivo }}">
            <input name="f_arquivo_del[]" class="del-upload" type="hidden" value="">
        </div>
    </div>
</div>
@endif
