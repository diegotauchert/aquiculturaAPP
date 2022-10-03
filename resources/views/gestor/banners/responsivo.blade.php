@if($banner->responsivo)
<div class="item col-md-6 my-auto py-3">
    <div class="card">
        <a href="{{ $banner->responsivo->url() }}" class="preview" data-preview-t="img" data-preview-size="large"><img class="card-img" src="{{ $banner->responsivo->url() }}"></a>
        <div class="card-body text-center">
            <button type="button" class="remove-upload-unique btn btn-danger" data-toggle="tooltip" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span></button>
            <input name="f_responsivo[]" type="hidden" value="{{ $banner->responsivo }}">
        </div>
    </div>
</div>
@endif