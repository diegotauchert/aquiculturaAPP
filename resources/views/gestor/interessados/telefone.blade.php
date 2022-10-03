<div class="clone item list-group-item p-0">
    <div class="row no-gutters">
        <div class="col-md my-auto">
            <div class="p-4">
                <div class="form-row">
                    <div class="form-group col-sm col-lg-12">
                        <label for="f_telefones_numero_{{ $telefone_k }}" class="form-control-label">@lang('gestor_interessado.telefones_numero')</label>
                        <input name="f_telefones_numero[]" id="f_telefones_numero_{{ $telefone_k }}" type="text" value="{{ (old('f_telefones_numero')[$telefone_k] ? old('f_telefones_numero')[$telefone_k] : $telefone->numero) }}" class="form-control masktelefone @error('f_telefones_numero') is-invalid @enderror" placeholder="@lang('gestor_interessado.telefones_numero')" data-clone-id="f_telefones_numero">
                        @error('f_telefones_numero')
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
                <input name="f_telefones_id[]" id="f_telefones_id_{{ $telefone_k }}" type="hidden" value="{{ $telefone->id }}" data-clone-id="f_telefones_id" class="clear">
                <button type="button" class="remove-clone btn btn-block d-inline-block d-md-block mb-md-1 m-md-0 btn-danger"><span class="fas fa-minus"></span> @lang('gestor.remove')</button>
                <button type="button" class="add-clone btn btn-block d-inline-block d-md-block mt-md-1 btn-success"><span class="fas fa-plus"></span> @lang('gestor.add')</button>
                <button type="button" class="duplicate-clone btn btn-block d-inline-block d-md-block mt-md-1 btn-info"><span class="fas fa-copy"></span> @lang('gestor.duplicate')</button>
            </div>
        </div>
    </div>
</div>
