<div class="card-body border border-light p-4 m-4 rounded">
    <div class="form-row">
        <div class="form-group col-md">
            <label for="f_qtd" class="form-control-label">* Quantidade Diária</label>
            <input name="f_qtd" id="f_qtd" required type="text" value="{{ (old('f_qtd') ? old('f_qtd') : ($racao ? $racao->qtd : '')) }}" class="form-control normatize @error('f_qtd') is-invalid @enderror" maxlength="250" placeholder="Informe a quantidade diária" />
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
                <option value="{{ $produto->id }}" {{ $produto->id == (old('f_produto') ? old('f_produto') : ($racao ? $racao->produto_id : '')) ? ' selected' : '' }}>
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
                @if($racaoHorario)
                @foreach($racaoHorario as $key => $post)
                @include('gestor.producao.categorias.racaohorario')
                @endforeach
                @else
                @include('gestor.producao.categorias.racaohorario')
                @endif
            </div>
        </div>
    </div>
</div>