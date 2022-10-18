<div class="card-body border border-light p-4 m-4 rounded">
    <div class="form-row">
        <div class="form-group col-md">
            <label for="f_qtd" class="form-control-label">* Quantidade Diária</label>
            <input name="f_qtd" id="f_qtd" required type="text" value="{{ (old('f_qtd') ? old('f_qtd') : $producao->qtd) }}" class="form-control normatize @error('f_qtd') is-invalid @enderror" maxlength="250" placeholder="Informe a quantidade diária" />
            @error('f_qtd')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        @if($produtos)
        <div class="form-group col-md">
            <label for="f_produto" class="form-control-label">* Produto</label>
            <select name="f_produto" id="f_produto" required class="form-control selectpicker-custom" title="Escolha um Produto">
                <option value="" disabled>- Escolha um Produto</option>
                @foreach($produtos as $produto)
                <option value="{{ $produto->id }}" {{ $produto->id == (old('f_produto') ? old('f_produto') : $produto->id) ? ' selected' : '' }}>
                    {{ $produto->nome }}
                </option>
                @endforeach
            </select>
            @error('f_produto')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        @endif
    </div>
    <div class="form-row">
        <div class="form-group col-md">
            <label for="f_telefone" class="form-control-label">* Horários de Arraçoamento</label>

            <div id="seo_keywords" class="clones list-group">
                <div class="clone item list-group-item p-0">
                    <div class="row no-gutters">
                        <div class="col-md my-auto">
                            <div class="p-4">
                                <label for="f_horario" class="form-control-label">Horário</label>
                                <input name="f_horario[]" id="f_horario" type="text" value="{{ (old('f_horario') ? old('f_horario') : '') }}" class="maskhorario form-control @error('f_horario') is-invalid @enderror" maxlength="5" data-clone-id="f_horario" />
                                
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
            </div>
        </div>
    </div>
</div>