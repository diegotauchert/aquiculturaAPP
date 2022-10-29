<div class="card-body border border-light p-4 m-4 rounded">
    <h4>Qualidade da água</h4>
    <div class="form-row">
        <div class="form-group col-md">
            <label for="f_ph" class="form-control-label">PH</label>
            <input name="f_ph" id="f_ph" required type="text" value="{{ (old('f_ph') ? old('f_ph') : $producao->ph) }}" class="form-control normatize @error('f_ph') is-invalid @enderror" maxlength="250" />
            @error('f_ph')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md">
            <label for="f_salinidade" class="form-control-label">Salinidade</label>
            <input name="f_salinidade" id="f_salinidade" required type="text" value="{{ (old('f_salinidade') ? old('f_salinidade') : $producao->salinidade) }}" class="form-control normatize @error('f_salinidade') is-invalid @enderror" maxlength="250" />
            @error('f_salinidade')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md">
            <label for="f_turbidez" class="form-control-label">Turbidez</label>
            <input name="f_turbidez" id="f_turbidez" required type="text" value="{{ (old('f_turbidez') ? old('f_turbidez') : $producao->turbidez) }}" class="form-control normatize @error('f_turbidez') is-invalid @enderror" maxlength="250" />
            @error('f_turbidez')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md">
            <label for="f_alcalinidade" class="form-control-label">Alcalinidade</label>
            <input name="f_alcalinidade" id="f_alcalinidade" required type="text" value="{{ (old('f_alcalinidade') ? old('f_alcalinidade') : $producao->alcalinidade) }}" class="form-control normatize @error('f_alcalinidade') is-invalid @enderror" maxlength="250" />
            @error('f_alcalinidade')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md">
            <label for="f_oxigenio" class="form-control-label">Oxigênio Dissolvido</label>
            <input name="f_oxigenio" id="f_oxigenio" required type="text" value="{{ (old('f_oxigenio') ? old('f_oxigenio') : $producao->oxigenio) }}" class="form-control normatize @error('f_oxigenio') is-invalid @enderror" maxlength="250" />
            @error('f_oxigenio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md">
            <label for="f_temperatura" class="form-control-label">Temperatura</label>
            <input name="f_temperatura" id="f_temperatura" required type="text" value="{{ (old('f_temperatura') ? old('f_temperatura') : $producao->temperatura) }}" class="form-control normatize @error('f_temperatura') is-invalid @enderror" maxlength="250" />
            @error('f_temperatura')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>

<div class="card-body border border-light p-4 m-4 rounded">
    <h4>Biometria</h4>
    <div class="form-row">
        <div class="form-group col-md">
            <label for="f_qtd" class="form-control-label">Quantidade da Amostra</label>
            <input name="f_qtd" id="f_qtd" required type="text" value="{{ (old('f_qtd') ? old('f_qtd') : $producao->qtd) }}" class="form-control normatize @error('f_qtd') is-invalid @enderror" maxlength="250" />
            @error('f_qtd')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md">
            <label for="f_gramatura" class="form-control-label">Gramatura Total <small>(Apenas números)</small></label>
            <input name="f_gramatura" id="f_gramatura" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required type="text" value="{{ (old('f_gramatura') ? old('f_gramatura') : $producao->gramatura) }}" class="form-control normatize @error('f_gramatura') is-invalid @enderror" maxlength="250" />
            @error('f_gramatura')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md">
            <label for="f_tara" class="form-control-label">Tara da Balança</label>
            <input name="f_tara" id="f_tara" required type="text" value="{{ (old('f_tara') ? old('f_tara') : $producao->tara) }}" class="form-control normatize @error('f_tara') is-invalid @enderror" maxlength="250" />
            @error('f_tara')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-sm">
            <label for="f_despesca" class="form-control-label">Previsão de despesca</label>
            <div class="input-group">
                <input name="f_despesca" id="f_despesca" type="text" value="{{ (old('f_despesca') ? old('f_despesca') : ($producao->despesca ? $producao->despesca->format('d/m/Y') : '')) }}" class="form-control maskdata @error('f_despesca') is-invalid @enderror" placeholder="@lang('gestor_cliente.despesca')" />
                <div class="input-group-append">
                    <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                </div>
            </div>
            @error('f_despesca')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>