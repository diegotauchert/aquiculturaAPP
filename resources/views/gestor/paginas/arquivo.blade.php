@if($anexo->arquivo)
<div class="item col-sm-6 col-md-4 col-lg-3 my-auto py-3">
    <div class="card">
        <div class="card-body text-center">
            <div class="form-row">
                <div class="form-group col-md">
                    <a href="{{ $anexo->arquivo->url() }}" class="btn btn-primary preview" data-preview-size="large"><span class="fas fa-file"></span> {{ mb_strtoupper($anexo->arquivo->extension()) }}</a>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <div class="input-group">
                        <input name="f_arquivo[descricao][]" class="form-control" type="text" value="{{ $anexo->descricao }}" maxlength="250" placeholder="@lang('gestor_pagina.descricao')">
                        <div class="input-group-append">
                            <button type="button" class="remove-upload btn btn-danger" data-toggle="tooltip" title="@lang('gestor.destroy')"><span class="fas fa-trash"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <input name="f_arquivo[codigo][]" class="upload-id" type="hidden" value="{{ $anexo->id }}">
        </div>
    </div>
</div>
@endif
