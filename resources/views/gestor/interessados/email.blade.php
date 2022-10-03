<div class="clone item list-group-item p-0">
    <div class="row no-gutters">
        <div class="col-md my-auto">
            <div class="p-4">
                <div class="form-row">
                    <div class="form-group col-sm col-lg-12">
                        <label for="f_emails_email_{{ $email_k }}" class="form-control-label">@lang('gestor_interessado.emails_email')</label>
                        <input name="f_emails_email[]" id="f_emails_email_{{ $email_k }}" type="text" value="{{ (old('f_emails_email')[$email_k] ? old('f_emails_email')[$email_k] : $email->email) }}" class="form-control @error('f_emails_email') is-invalid @enderror" placeholder="@lang('gestor_interessado.emails_email')" data-clone-id="f_emails_email">
                        @error('f_emails_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-auto bg-light d-flex">
            <div class="m-auto p-4 text-center">
                <input name="f_emails_id[]" id="f_emails_id_{{ $email_k }}" type="hidden" value="{{ $email->id }}" data-clone-id="f_emails_id" class="clear">
                <button type="button" class="remove-clone btn btn-block d-inline-block d-md-block mb-md-1 m-md-0 btn-danger"><span class="fas fa-minus"></span> @lang('gestor.remove')</button>
                <button type="button" class="add-clone btn btn-block d-inline-block d-md-block mt-md-1 btn-success"><span class="fas fa-plus"></span> @lang('gestor.add')</button>
                <button type="button" class="duplicate-clone btn btn-block d-inline-block d-md-block mt-md-1 btn-info"><span class="fas fa-copy"></span> @lang('gestor.duplicate')</button>
            </div>
        </div>
    </div>
</div>
