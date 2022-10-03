@if($download->arquivo)
<div class="item col-6 col-sm-4 col-md-5 col-lg-3 col-xl-2 my-auto py-3">
    <div class="card">

        <div class="card-body text-center">
            <div class="form-row">
                <div class="form-group col-md">
                    <a href="{{ $download->arquivo->url() }}" class="btn btn-primary preview" data-preview-size="large"><span class="fas fa-file"></span> {{ mb_strtoupper($download->arquivo->extension()) }}</a>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <button type="button" class="remove-upload-unique btn btn-danger" data-toggle="tooltip" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span></button>
                    <input name="f_arquivo[]" type="hidden" value="{{ $download->arquivo }}">
                </div>
            </div>
        </div>
    </div>
</div>
@endif