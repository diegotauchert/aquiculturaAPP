<div class="card-body border border-light p-4 m-4 rounded">
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