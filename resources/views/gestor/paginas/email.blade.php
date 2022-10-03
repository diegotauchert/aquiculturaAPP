<div class="clone item list-group-item p-0">
    <div class="row no-gutters">
        <div class="col-md my-auto">
            <div class="p-4">
                <label for="f_email_{{ $email_k }}" class="form-control-label">@lang('gestor_pagina.email')</label>
                <input name="f_email[]" id="f_email_{{ $email_k }}" type="text" value="{{ (old('f_email')[$email_k] ? old('f_email')[$email_k] : $email) }}" class="form-control @error('f_email') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_pagina.email')" data-clone-id="f_email">
                @error('f_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
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
