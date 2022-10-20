<div class="clone item list-group-item p-0">
    <div class="row no-gutters">
        <div class="col-md my-auto">
            <div class="p-4">
                <label for="f_horario" class="form-control-label">Horário</label>
                <input name="f_horario[]" id="f_horario" type="text" value="{{ (old('f_horario') ? old('f_horario') : (isset($post) ? $post->hora : '')) }}" class="maskhorario form-control @error('f_horario') is-invalid @enderror" maxlength="5" data-clone-id="f_horario" />
                <input name="f_horario_id[]" id="f_horario_id" type="hidden" value="{{ isset($post) ? $post->id : '' }}" data-clone-id="f_horario_id" />
                
                @error('f_horario')
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