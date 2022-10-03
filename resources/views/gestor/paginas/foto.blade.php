@if($anexo->foto)
<div class="item col-sm-6 col-md-4 col-lg-3 my-auto py-3">
    <div class="card">
        <a href="{{ $anexo->foto->url() }}" class="preview" data-preview-t="img" data-preview-size="large"><img class="card-img" src="{{ $anexo->foto->url() }}"></a>
        <div class="card-body text-center">

            <div class="form-row">
                <div class="form-group col-md">
                    <div class="input-group">
                        <input name="f_foto[descricao][]" class="form-control" type="text" value="{{ $anexo->descricao }}" maxlength="250" placeholder="@lang('gestor_pagina.descricao')">
                        <div class="input-group-append">
                            <button type="button" class="remove-upload btn btn-danger" data-toggle="tooltip" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <input name="f_foto[codigo][]" class="upload-id" type="hidden" value="{{ $anexo->id }}">
        </div>
    </div>
</div>
@endif
