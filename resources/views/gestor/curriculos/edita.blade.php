@extends('layouts.gestor.app')

@if($curriculo->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_curriculo.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_curriculo.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_curriculo.titulo')
            @if($curriculo->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>

<form method="POST" action="{{ ($curriculo->id ? route('gestor.curriculos.update', $curriculo->id) : route('gestor.curriculos.store')) }}">
    @csrf

    @if($curriculo->id)
    @method('PUT')
    @endif

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_curriculo.informacoes')</div>
            <div class="card-body">
                @if($curriculo->id)
                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="">@lang('gestor_curriculo.foto')</label>
                            <div class="upload-anexos-unique" data-up-tipo="foto" data-up-link="curriculos"
                                data-up-id="{{ $curriculo->id }}" data-up-nome="foto" data-up-class="col-md-6 my-auto py-3">
                                <div class="list-group uploads pb-2"></div>
                                <div class="files-itens files-ordem row pt-2">
                                    @include('gestor.curriculos.foto')
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_curriculo.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $curriculo->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_curriculo.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_cpf" class="form-control-label">* @lang('gestor_curriculo.cpf')</label>
                        <input name="f_cpf" id="f_cpf" type="text" value="{{ (old('f_cpf') ? old('f_cpf') : $curriculo->cpf) }}" class="form-control maskcpf @error('f_cpf') is-invalid @enderror" maxlength="50" placeholder="@lang('gestor_curriculo.cpf')">
                        @error('f_cpf')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_rg" class="form-control-label">* @lang('gestor_curriculo.rg')</label>
                        <input name="f_rg" id="f_rg" type="text" value="{{ (old('f_rg') ? old('f_rg') : $curriculo->rg) }}" class="form-control masknum @error('f_rg') is-invalid @enderror" maxlength="50" placeholder="@lang('gestor_curriculo.rg')">
                        @error('f_rg')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm col-md-auto">
                        <label for="f_nascimento" class="form-control-label">* @lang('gestor_curriculo.nascimento')</label>
                        <div class="input-group">
                            <input name="f_nascimento" id="f_nascimento" type="text" value="{{ (old('f_nascimento') ? old('f_nascimento') : ($curriculo->nascimento ? $curriculo->nascimento->format('d/m/Y') : '')) }}" class="form-control maskdata @error('f_nascimento') is-invalid @enderror" placeholder="@lang('gestor_curriculo.nascimento')">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                            </div>
                        </div>
                        @error('f_nascimento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm col-md">
                        <label for="f_sexo" class="form-control-label">* @lang('gestor_curriculo.sexo')</label>
                        <div class="input-group">
                            <select name="f_sexo" id="f_sexo" class="form-control selectpicker-custom" title="@lang('gestor_curriculo.sexo')">
                                <option value="">@lang('gestor_curriculo.sexo')</option>
                                @foreach($curriculo->present()->makeSexoAll as $sex_k => $sex_c)
                                <option value="{{ $sex_k }}" {{ ($sex_k == (old('f_sexo') ? old('f_sexo') : $curriculo->sexo) ? ' selected="selected"' : '') }}>{{ $sex_c }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('f_sexo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm col-md">
                        <label for="f_estado_civil" class="form-control-label">* @lang('gestor_curriculo.estado_civil')</label>
                        <div class="input-group">
                            <select name="f_estado_civil" id="f_estado_civil" class="form-control selectpicker-custom" title="@lang('gestor_curriculo.estado_civil')">
                                <option value="">@lang('gestor_curriculo.estado_civil')</option>
                                @foreach($curriculo->present()->makeEstadoCivilAll as $est_c_k => $est_c)
                                <option value="{{ $est_c_k }}" {{ ($est_c_k == (old('f_estado_civil') ? old('f_estado_civil') : $curriculo->estado_civil) ? ' selected="selected"' : '') }}>{{ $est_c }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('f_estado_civil')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_curriculo.informacoes_contato')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm col-md">
                        <label for="f_email" class="form-control-label">* @lang('gestor_curriculo.email')</label>
                        <input name="f_email" id="f_email" type="text" value="{{ (old('f_email') ? old('f_email') : $curriculo->email) }}" class="form-control @error('f_email') is-invalid @enderror" placeholder="@lang('gestor_curriculo.email')">
                        @error('f_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm col-md">
                        <label for="f_telefone" class="form-control-label">* @lang('gestor_curriculo.telefone')</label>
                        <input name="f_telefone" id="f_telefone" type="text" value="{{ (old('f_telefone') ? old('f_telefone') : $curriculo->telefone) }}" class="form-control masktelefone @error('f_telefone') is-invalid @enderror" placeholder="@lang('gestor_curriculo.telefone')">
                        @error('f_telefone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm col-md">
                        <label for="f_endereco" class="form-control-label">* @lang('gestor_curriculo.endereco')</label>
                        <input name="f_endereco" id="f_endereco" type="text" value="{{ (old('f_endereco') ? old('f_endereco') : $curriculo->endereco) }}" class="form-control @error('f_endereco') is-invalid @enderror" placeholder="@lang('gestor_curriculo.endereco')">
                        @error('f_endereco')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-3 col-md-2">
                        <label for="f_numero" class="form-control-label">* @lang('gestor_curriculo.numero')</label>
                        <input name="f_numero" id="f_numero" type="text" value="{{ (old('f_numero') ? old('f_numero') : $curriculo->numero) }}" class="form-control @error('f_numero') is-invalid @enderror" placeholder="@lang('gestor_curriculo.numero')">
                        @error('f_numero')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_complemento" class="form-control-label">@lang('gestor_curriculo.complemento')</label>
                        <input name="f_complemento" id="f_complemento" type="text" value="{{ (old('f_complemento') ? old('f_complemento') : $curriculo->complemento) }}" class="form-control @error('f_complemento') is-invalid @enderror" placeholder="@lang('gestor_curriculo.complemento')">
                        @error('f_complemento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_bairro" class="form-control-label">* @lang('gestor_curriculo.bairro')</label>
                        <input name="f_bairro" id="f_bairro" type="text" value="{{ (old('f_bairro') ? old('f_bairro') : $curriculo->bairro) }}" class="form-control @error('f_bairro') is-invalid @enderror" placeholder="@lang('gestor_curriculo.bairro')">
                        @error('f_bairro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md col-lg-auto">
                        <label for="f_cep" class="form-control-label">* @lang('gestor_curriculo.cep')</label>
                        <input name="f_cep" id="f_cep" type="text" value="{{ (old('f_cep') ? old('f_cep') : $curriculo->cep) }}" class="form-control maskcep @error('f_cep') is-invalid @enderror" placeholder="@lang('gestor_curriculo.cep')">
                        @error('f_cep')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-auto">
                        <label for="f_estado" class="form-control-label">* @lang('gestor_curriculo.estado')</label>
                        <select name="f_estado" id="f_estado" class="form-control selectpicker-custom select-estado" title="@lang('gestor_curriculo.estado')" data-ref="f_cidade">
                            <option value="">@lang('gestor_curriculo.estado')</option>
                            @foreach($s_estados as $s_estado)
                            <option value="{{ $s_estado->id }}" data-subtext="{{ $s_estado->sigla }}" {{ $s_estado->id == (old('f_estado') ? old('f_estado') : ($curriculo->cidade ? $curriculo->cidade->estado_id : '')) ? ' selected' : '' }}>{{ $s_estado->nome }}</option>
                            @endforeach
                        </select>
                        @error('f_estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_cidade" class="form-control-label">* @lang('gestor_curriculo.cidade')</label>
                        <select name="f_cidade" id="f_cidade" class="form-control selectpicker-custom" title="@lang('gestor_curriculo.cidade')">
                            <option value="">@lang('gestor_curriculo.cidade')</option>
                            @foreach(\App\Models\Cidade::where('estado_id', '=', (old('f_estado') ? old('f_estado') : ($curriculo->cidade ? $curriculo->cidade->estado_id : '')))->get() as $s_cidade)
                            <option value="{{ $s_cidade->id }}" {{ $s_cidade->id == (old('f_cidade') ? old('f_cidade') : $curriculo->cidade_id) ? ' selected' : '' }}>{{ $s_cidade->nome }}</option>
                            @endforeach
                        </select>
                        @error('f_cidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_curriculo.informacoes_profissionais')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm col-md">
                        <label for="f_cargo" class="form-control-label">@lang('gestor_curriculo.cargo')</label>
                        <input name="f_cargo" id="f_cargo" type="text" value="{{ (old('f_cargo') ? old('f_cargo') : $curriculo->cargo) }}" class="form-control @error('f_cargo') is-invalid @enderror" placeholder="@lang('gestor_curriculo.cargo')">
                        @error('f_cargo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm col-md">
                        <label for="f_formacao" class="form-control-label">@lang('gestor_curriculo.formacao')</label>
                        <input name="f_formacao" id="f_formacao" type="text" value="{{ (old('f_formacao') ? old('f_formacao') : $curriculo->formacao) }}" class="form-control @error('f_formacao') is-invalid @enderror" placeholder="@lang('gestor_curriculo.formacao')">
                        @error('f_formacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm col-md">
                        <label for="f_experiencia" class="form-control-label">@lang('gestor_curriculo.experiencia')</label>
                        <textarea name="f_experiencia" id="f_experiencia" rows="8" class="form-control @error('f_experiencia') is-invalid @enderror" placeholder="@lang('gestor_curriculo.experiencia')">{{ (old('f_experiencia') ? old('f_experiencia') : $curriculo->experiencia) }}</textarea>
                        @error('f_experiencia')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm col-md">
                        <label for="f_qualificacao" class="form-control-label">@lang('gestor_curriculo.qualificacao')</label>
                        <textarea name="f_qualificacao" id="f_qualificacao" rows="8" class="form-control @error('f_qualificacao') is-invalid @enderror" placeholder="@lang('gestor_curriculo.qualificacao')">{{ (old('f_qualificacao') ? old('f_qualificacao') : $curriculo->qualificacao) }}</textarea>
                        @error('f_qualificacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm col-md">
                        <label for="f_cursos" class="form-control-label">@lang('gestor_curriculo.cursos')</label>
                        <textarea name="f_cursos" id="f_cursos" rows="8" class="form-control @error('f_cursos') is-invalid @enderror" placeholder="@lang('gestor_curriculo.cursos')">{{ (old('f_cursos') ? old('f_cursos') : $curriculo->cursos) }}</textarea>
                        @error('f_cursos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm col-md">
                        <label for="f_idiomas" class="form-control-label">@lang('gestor_curriculo.idiomas')</label>
                        <textarea name="f_idiomas" id="f_idiomas" rows="8" class="form-control @error('f_idiomas') is-invalid @enderror" placeholder="@lang('gestor_curriculo.idiomas')">{{ (old('f_idiomas') ? old('f_idiomas') : $curriculo->idiomas) }}</textarea>
                        @error('f_idiomas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_curriculo.outras_informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_vaga" class="form-control-label">@lang('gestor_curriculo.vaga')</label>
                        <select name="f_vaga" id="f_vaga" class="form-control selectpicker-custom" title="@lang('gestor_curriculo.vaga')">
                            <option value="">@lang('gestor_curriculo.vaga')</option>
                            @foreach($s_vagas as $s_vaga)
                            <option value="{{ $s_vaga->id }}"{{ $s_vaga->id == (old('f_vaga') ? old('f_vaga') : $curriculo->vaga_id) ? ' selected' : '' }}>{{  $s_vaga->nome }}</option>
                            @endforeach
                        </select>
                        @error('f_vaga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_curriculo.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_curriculo.situacao')">
                            <option value="">@lang('gestor_curriculo.situacao')</option>
                            @foreach($curriculo->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $curriculo->situacao) ? ' selected' : '' }}>{{ $sit_v[0] }}</option>
                            @endforeach
                        </select>
                        @error('f_situacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm col-md">
                        <label for="f_salario" class="form-control-label">@lang('gestor_curriculo.salario')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">R$</div>
                            </div>
                            <input name="f_salario" id="f_salario" type="text" value="{{ (old('f_salario') ? old('f_salario') : $curriculo->salario) }}" class="form-control masknumv" placeholder="@lang('gestor_curriculo.salario')">
                        </div>
                        @error('f_salario')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="f_password" class="form-control-label">@lang('gestor_curriculo.password')</label>
                        <div class="input-group">
                            <input name="f_password" id="f_password" type="password" value="" class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_curriculo.password')">

                            <div class="input-group-append">
                                <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')/@lang('gestor.hide')" type="button"><span class="fas fa-eye"></span></button>
                            </div>
                        </div>
                        @error('f_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm">
                        <label for="f_password_confirmation" class="form-control-label">* @lang('gestor_curriculo.password_confirmation')</label>
                        <div class="input-group">
                            <input name="f_password_confirmation" id="f_password_confirmation" type="password" value="" class="form-control @error('f_password') is-invalid @enderror" maxlength="100" placeholder="@lang('gestor_curriculo.password_confirmation')">
                            <div class="input-group-append">
                                <button class="mostrar-senha btn btn-secondary o-tooltip" title="@lang('gestor.show')/@lang('gestor.hide')" type="button"><span class="fas fa-eye"></span></button>
                            </div>
                        </div>
                        @error('f_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
        @if($curriculo->id) <a class="btn btn-lg btn-success" target="_blank" href="{{ route('gestor.curriculos.pdf', $curriculo->id) }}"><span class="fas fa-file"></span> @lang('gestor.pdf')</a> @endif
    </div>
</form>
@endsection
