<div class="clone item list-group-item p-0">
    <div class="row no-gutters">
        <div class="col-md my-auto">
            <div class="p-4">
                <label for="f_conf_seo_keyword_{{ $seo_keyword_k }}" class="form-control-label">@lang('gestor_pagina.seo_keyword')</label>
                <input name="f_conf[seo_keyword][]" id="f_conf_seo_keyword_{{ $seo_keyword_k }}" type="text" value="{{ (old('f_conf') && old('f_conf')['seo_keyword'][$seo_keyword_k] ? old('f_conf')['seo_keyword'][$seo_keyword_k] : $seo_keyword) }}" class="form-control" maxlength="250" placeholder="@lang('gestor_config.seo_keyword')" data-clone-id="f_seo_keyword">
            </div>
        </div>
        <div class="col-sm-12 col-lg-auto bg-light d-flex">
            <div class="m-auto p-4 text-center">
                <button type="button" class="remove-clone btn d-inline-block btn-danger"><span class="fas fa-minus"></span> @lang('gestor.remove')</button>
                <button type="button" class="add-clone btn d-inline-block btn-success"><span class="fas fa-plus"></span> @lang('gestor.add')</button>
                <button type="button" class="duplicate-clone btn d-inline-block btn-info"><span class="fas fa-copy"></span> @lang('gestor.duplicate')</button>
            </div>
        </div>
    </div>
</div>
