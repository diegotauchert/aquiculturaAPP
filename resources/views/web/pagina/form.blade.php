<div class="container-fluid">
    <div class="row">
        <div id="orcamento" class="col col-lg pb-5">
            @if (session('alert'))
            @web_alert(['type' => session('alert')['type']])
            {!! session('alert')['message'] !!}
            @endweb_alert
            @endif

            <form method="POST" action="{{ route('web.indicador.send') }}">
                @csrf
                <p class="title">@lang('web_orcamento.titulo_indicador')<br />
                    <strong><em>@lang('web_orcamento.subtitulo_indicador')</em></strong></p>
                <br />
                <p class="h3">@lang('web_orcamento.boldtitulo_indicador')</p>
                <br />

                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('web_orcamento.nome')</label>
                        <input name="f_nome" id="f_nome" class="form-control @error('f_nome') is-invalid @enderror" type="text" value="{{ old('f_nome') }}" placeholder="@lang('web_orcamento.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-auto">
                        <label for="f_telefone" class="form-control-label">* @lang('web_orcamento.telefone')</label>
                        <input name="f_telefone" id="f_telefone" class="form-control masktelefone @error('f_telefone') is-invalid @enderror" type="tel" value="{{ old('f_telefone') }}" placeholder="@lang('web_orcamento.telefone')">
                        <div class="checkbox">
                            <input style="display: inline;width: 23px;height: 23px;margin-top: 7px;vertical-align: text-bottom;" name="f_whatsapp" id="f_whatsapp" class="form-control" type="checkbox" value="1" />
                            <label style="font-size:12px;" for="f_whatsapp">Esse é teu número de WhastApp?</label>
                        </div>

                        @error('f_telefone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_email" class="form-control-label">* @lang('web_orcamento.email')</label>
                        <input name="f_email" id="f_email" class="form-control @error('f_email') is-invalid @enderror" type="email" value="{{ old('f_email') }}" placeholder="@lang('web_orcamento.email')">
                        @error('f_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_endereco" class="form-control-label">* @lang('web_orcamento.endereco')</label>
                        <input name="f_endereco" id="f_endereco" class="form-control @error('f_endereco') is-invalid @enderror" type="text" value="{{ old('f_endereco') }}" placeholder="@lang('web_orcamento.endereco')">
                        @error('f_endereco')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-auto">
                        <label for="f_estado" class="form-control-label">*
                            @lang('web_orcamento.lugar')</label>
                        <select name="f_estado" id="f_estado" class="form-control @error('f_estado') is-invalid @enderror selectpicker-custom select-estado" title="@lang('web_orcamento.estado_origem')" data-ref="f_cidade">
                            <option value="">@lang('web_orcamento.estado_origem')</option>
                            @foreach(\App\Models\Estado::get() as $s_estado)
                            <option value="{{ $s_estado->id }}" data-subtext="{{ $s_estado->sigla }}" {{ $s_estado->id == (old('f_estado') ? old('f_estado') : '') ? ' selected' : '' }}>
                                {{ $s_estado->nome }}</option>
                            @endforeach
                        </select>
                        @error('f_estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_cidade" class="form-control-label">&nbsp;</label>
                        <select name="f_cidade" id="f_cidade" class="form-control @error('f_cidade') is-invalid @enderror selectpicker-custom" title="@lang('web_orcamento.cidade_origem')">
                            <option value="">@lang('web_orcamento.cidade_origem')</option>
                            @foreach(\App\Models\Cidade::where('estado_id', '=', (old('f_estado') ?
                            old('f_estado') :
                            ''))->get() as $s_cidade)
                            <option value="{{ $s_cidade->id }}" {{ $s_cidade->id == (old('f_cidade') ? old('f_cidade') : '') ? ' selected' : '' }}>
                                {{ $s_cidade->nome }}</option>
                            @endforeach
                        </select>
                        @error('f_cidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conheceu" class="form-control-label">* @lang('web_orcamento.conheceu_indicador')</label>
                        <input name="f_conheceu" id="f_conheceu" class="form-control @error('f_conheceu') is-invalid @enderror" type="text" value="{{ old('f_conheceu') }}" placeholder="@lang('web_orcamento.digite')">
                        @error('f_conheceu')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md">
                        <label for="f_equipamento" class="form-control-label">* @lang('web_orcamento.equipamento_indicador')</label>
                        <br clear="all" />
                        <div class="checkbox ml-3" style="display: inline-block;">
                            <input style="display: inline;width: 23px;height: 23px;margin-top: 7px;vertical-align: text-bottom;" name="f_equipamento" id="f_equipamento1" class="form-control" checked type="radio" value="1" />
                            <label style="font-size:15px;" for="f_equipamento1">Sim</label>
                        </div>
                        <div class="checkbox" style="display: inline-block;">
                            <input style="display: inline;width: 23px;height: 23px;margin-top: 7px;vertical-align: text-bottom;" name="f_equipamento" id="f_equipamento2" class="form-control" type="radio" value="2" />
                            <label style="font-size:15px;" for="f_equipamento2">Não</label>
                        </div>
                        @error('f_equipamento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_mensagem" class="form-control-label">@lang('web_orcamento.mensagem')</label>
                        <textarea name="f_mensagem" id="f_mensagem" class="form-control @error('f_mensagem') is-invalid @enderror" rows="6" placeholder="@lang('web_orcamento.mensagem')">{{ old('f_mensagem') }}</textarea>
                        @error('f_mensagem')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <br clear="all" />
                <button class="btn btn-lg btn-primary" type="submit"><span class="fas fa-envelope"></span>
                    @lang('web.enviar')</button>
            </form>
        </div>
    </div>
</div>
