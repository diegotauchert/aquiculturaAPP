@if($mensagem->arquivo)
<div class="item col-sm-6 col-md-4 col-lg-3 my-auto py-3">
    <div class="card">
        <div class="card-body text-center">
            <div class="form-row">
                <div class="form-group col-md">
                    <a href="{{ $mensagem->arquivo->url() }}" class="btn btn-primary preview" data-preview-size="large"><span class="fas fa-file"></span> {{ mb_strtoupper($mensagem->arquivo->extension()) }}</a>
                </div>
            </div>
            <input name="f_arquivo[codigo][]" class="upload-id" type="hidden" value="{{ $mensagem->id }}">
        </div>
    </div>
</div>
@endif